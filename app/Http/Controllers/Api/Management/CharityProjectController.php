<?php

namespace App\Http\Controllers\Api\Management;

use App\Http\Controllers\Controller;
use App\Http\Resources\Management\CharityProjectResource;
use App\Models\CharityProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class CharityProjectController extends Controller
{
    /**
     * Format a success JSON response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    protected function successResponse($data = null, string $message = 'Success', int $status = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    /**
     * Format an error JSON response.
     *
     * @param string $message
     * @param int $status
     * @param array $errors
     * @return JsonResponse
     */
    protected function errorResponse(string $message = 'Error', int $status = 400, array $errors = []): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    /**
     * Get all charity projects with filtering and pagination
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'number' => 'sometimes|integer',
                'category_id' => 'sometimes|integer|exists:category_projects,id',
                'category' => 'sometimes|string',
                'project_types' => 'sometimes|string',
                'location_type' => 'sometimes|string',
                'status' => 'sometimes|integer',
                'featuer' => 'sometimes|boolean',
                'finished' => 'sometimes|boolean',
                'recurring' => 'sometimes|boolean',
                'title' => 'sometimes|string|max:255',
                'target_amount_from' => 'sometimes|numeric|min:0',
                'target_amount_to' => 'sometimes|numeric|min:0|gt:target_amount_from',
                'date_from' => 'sometimes|date',
                'date_to' => 'sometimes|date|after_or_equal:date_from',
                'created_at_from' => 'sometimes|date',
                'created_at_to' => 'sometimes|date|after_or_equal:created_at_from',
                'sort_by' => 'sometimes|string|in:created_at,updated_at,start_date,end_date,collected_target',
                'sort_order' => 'sometimes|string|in:asc,desc',
                'per_page' => 'sometimes|integer|min:1|max:100',
                'source' => 'sometimes|string|in:web,app,both',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation failed', 422, $validator->errors()->toArray());
            }

            $query = CharityProject::with(['trans', 'category.trans', 'tags']);

            // Filter by project number
            if ($request->filled('number')) {
                $query->where('number', $request->number);
            }

            // Filter by category ID or name using many-to-many relationship
            if ($request->filled('category_id')) {
                $query->whereHas('categories', function($q) use ($request) {
                    $q->where('category_projects.id', $request->category_id);
                });
            } elseif ($request->filled('category')) {
                $categoryName = $request->category;

                $query->whereHas('categories', function($q) use ($categoryName) {
                    $q->whereHas('trans', function($transQuery) use ($categoryName) {
                        $transQuery->where('title', 'like', "%$categoryName%");
                    });
                });
            }

            // Filter by project type (handle different formats and cases)
            if ($request->filled('project_types')) {
                $type = strtolower(trim($request->project_types));
                
                $query->where(function($q) use ($type) {
                    // Try different variations of the type
                    $variations = [
                        $type,
                        strtoupper($type),
                        ucfirst($type),
                        str_replace(' ', '_', $type),
                        str_replace('_', ' ', $type)
                    ];
                    
                    foreach (array_unique($variations) as $variation) {
                        $q->orWhere('project_types', 'like', "%$variation%");
                    }
                });
                
                // Log the filter attempt
                Log::debug('Project type filter applied', [
                    'input_type' => $request->project_types,
                    'normalized_type' => $type,
                    'query' => $query->toSql(),
                    'bindings' => $query->getBindings()
                ]);
            }

            if ($request->filled('location_type')) {
                $query->where('location_type', $request->location_type);
            }

            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('featuer')) {
                $query->where('featuer', $request->boolean('featuer'));
            }

            if ($request->has('finished')) {
                $query->where('finished', $request->boolean('finished'));
            }

            if ($request->has('recurring')) {
                $query->where('recurring', $request->boolean('recurring'));
            }

            // Search by title
            if ($request->filled('title')) {
                $searchTerm = '%' . $request->title . '%';
                $query->whereHas('trans', function($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm);
                });
            }

            // Target amount range (using target_price field)
            if ($request->filled('target_amount_from')) {
                $query->where('target_price', '>=', $request->target_amount_from);
            }
            
            if ($request->filled('target_amount_to')) {
                $query->where('target_price', '<=', $request->target_amount_to);
            }

            // Handle different date filtering scenarios
            if ($request->filled('created_at')) {
                // Single created_at parameter - filter by exact date
                $query->whereDate('created_at', $request->created_at);
            } elseif ($request->filled('date_from') || $request->filled('date_to')) {
                // Date range using date_from/date_to parameters
                $dateFrom = $request->filled('date_from') ? $request->date_from : null;
                $dateTo = $request->filled('date_to') ? $request->date_to : null;

                if ($dateFrom) {
                    $query->whereDate('created_at', '>=', $dateFrom);
                }
                if ($dateTo) {
                    $query->whereDate('created_at', '<=', $dateTo);
                }
            } elseif ($request->filled('created_at_from') || $request->filled('created_at_to')) {
                // Date range using created_at_from/created_at_to parameters
                $dateFrom = $request->filled('created_at_from') ? $request->created_at_from : null;
                $dateTo = $request->filled('created_at_to') ? $request->created_at_to : null;

                if ($dateFrom) {
                    $query->whereDate('created_at', '>=', $dateFrom);
                }
                if ($dateTo) {
                    $query->whereDate('created_at', '<=', $dateTo);
                }
            }

            if ($request->filled('source')) {
                $source = $request->source;
                if (in_array($source, ['web', 'app','both'])) {
                    $query->where('location_type', $source);
                } elseif ($source === 'both') {
                    $query->whereIn('location_type', ['web', 'app']);
                }
            }

            $sortBy = $request->input('sort_by', 'created_at');
            $sortOrder = $request->input('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Get paginated results
            $perPage = $request->input('per_page', 15);
            $projects = $query->paginate($perPage);

            // If no results found, return empty array with 200 status
            if ($projects->isEmpty()) {
                return $this->successResponse([
                    'data' => [],
                    'pagination' => [
                        'total' => 0,
                        'per_page' => $perPage,
                        'current_page' => 1,
                        'last_page' => 1,
                        'from' => null,
                        'to' => null,
                    ]
                ]);
            }

            return $this->successResponse([
                'data' => CharityProjectResource::collection($projects),
                'pagination' => [
                    'total' => $projects->total(),
                    'per_page' => $projects->perPage(),
                    'current_page' => $projects->currentPage(),
                    'last_page' => $projects->lastPage(),
                    'from' => $projects->firstItem(),
                    'to' => $projects->lastItem(),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in CharityProjectController@index: ' . $e->getMessage());
            return $this->errorResponse('An error occurred while fetching projects', 500);
        }
    }

    /**
     * Get a single charity project by ID
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $project = CharityProject::with(['trans', 'category.trans', 'tags', 'payment'])->find($id);

            if (!$project) {
                return $this->errorResponse('Project not found', 404);
            }

            return $this->successResponse([
                'data' => new CharityProjectResource($project)
            ]);

        } catch (\Exception $e) {
            Log::error('Error in CharityProjectController@show: ' . $e->getMessage());
            return $this->errorResponse('An error occurred while fetching the project', 500);
        }
    }
}
