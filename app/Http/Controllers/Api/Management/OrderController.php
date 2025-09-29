<?php

namespace App\Http\Controllers\Api\Management;

use App\Http\Controllers\Controller;
use App\Http\Resources\Management\OrderResource;
use App\Models\OrderView;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Format a success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Format an error response
     *
     * @param string|array $message
     * @param int $code
     * @param mixed $errors
     * @return JsonResponse
     */
    protected function errorResponse($message = 'Error', $code = 400, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Get all orders with filtering and pagination
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'per_page' => 'sometimes|integer|min:1|max:100',
                'page' => 'sometimes|integer|min:1',
                'identifier' => 'sometimes|string|max:255',
                'name' => 'sometimes|string|max:255', 
                'email' => 'sometimes|string|email|max:255', 
                'phone' => 'sometimes|string|max:20',
                'source' => 'sometimes|string|max:255', 
                'payment_method' => 'sometimes|string|max:255', 
                'payment_method_name' => 'sometimes|string|max:255', 
                'donation_status' => 'sometimes|string|max:255',
                'status' => 'sometimes|string|max:255',
                'amount_from' => 'sometimes|numeric|min:0',
                'amount_to' => 'sometimes|numeric|min:0|gte:amount_from',
                'price_from' => 'sometimes|numeric|min:0',
                'price_to' => 'sometimes|numeric|min:0|gte:price_from',
                'marketer_id' => 'sometimes|integer|exists:refers,id',
                'refer_name' => 'sometimes|string|max:255',
                'referer' => 'sometimes|integer|exists:refers,id', 
                'date_from' => 'sometimes|date',
                'date_to' => 'sometimes|date|after_or_equal:date_from',
                'sort_by' => 'sometimes|string|in:order_view.created_at,total,quantity',
                'sort_order' => 'sometimes|string|in:asc,desc',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation failed', 422, $validator->errors());
            }

            try {
                $query = OrderView::with(['paymentMethodTranslationEn']);

                // Apply filters
                if ($request->filled('identifier')) {
                    $query->where('identifier', 'like', '%' . $request->identifier . '%');
                }

                if ($request->filled('name')) {
                    $query->where('full_name', 'like', '%' . $request->name . '%');
                }

                if ($request->filled('mail') || $request->filled('email')) {
                    $email = $request->input('mail', $request->input('email'));
                    $query->where('donor_email', 'like', '%' . $email . '%');
                }

                if ($request->filled('phone')) {
                    $query->where('donor_mobile', 'like', '%' . $request->phone . '%');
                }

                if ($request->filled('source')) {
                    $query->where('source', $request->source);
                }

                if ($request->filled('payment_method')) {
                    $query->where('payment_method_id', $request->payment_method);
                }

                // Payment method filter by name (search in payment_methods.payment_key)
                if ($request->filled('payment_method_name')) {
                    $searchTerm = '%' . $request->payment_method_name . '%';
                    
                    // Debug: Log the search term
                    \Log::info('Searching for payment method:', [
                        'term' => $searchTerm,
                        'query_params' => $request->all()
                    ]);
                    
                    $query->whereHas('paymentMethod', function($q) use ($searchTerm) {
                        $q->where('payment_key', 'like', $searchTerm);
                        
                        // Debug: Log the payment methods that match the search
                        $matchingMethods = \App\Models\PaymentMethod::where('payment_key', 'like', $searchTerm)->get();
                        \Log::info('Matching payment methods:', $matchingMethods->toArray());
                    });
                    
                    // Debug: Log the generated SQL
                    \Log::info('Payment method search SQL:', [
                        'sql' => $query->toSql(),
                        'bindings' => $query->getBindings()
                    ]);
                }

                if ($request->filled('donation_status')) {
                    $query->where('status', $request->donation_status);
                }

                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }

                // Handle both price_* and amount_* parameters (price_* takes precedence)
                $amountFrom = $request->input('price_from', $request->input('amount_from'));
                $amountTo = $request->input('price_to', $request->input('amount_to'));

                if (!is_null($amountFrom)) {
                    $query->where('total', '>=', $amountFrom);
                }

                if (!is_null($amountTo)) {
                    $query->where('total', '<=', $amountTo);
                }

                if ($request->filled('referer')) {
                    $query->where('refer', $request->referer);
                }

                if ($request->filled('marketer_id')) {
                    $query->where('refer_id', $request->marketer_id);
                }

                if ($request->filled('refer_name')) {
                    $query->join('refers', 'order_view.refer_id', '=', 'refers.id')
                          ->where('refers.name', 'like', '%' . $request->refer_name . '%');
                }

                if ($request->filled('marketer_id')) {
                    $query->where('refer_id', $request->marketer_id);
                } else if ($request->filled('referer')) {
                    $query->where('refer_id', $request->referer);
                }

                if ($request->filled('date_from')) {
                    $query->whereDate('created_at', '>=', $request->date_from);
                }

                if ($request->filled('date_to')) {
                    $query->whereDate('created_at', '<=', $request->date_to);
                }

                // Apply sorting
                $sortBy = $request->input('sort_by', 'order_view.created_at');
                $sortOrder = $request->input('sort_order', 'desc');
                $query->orderBy($sortBy, $sortOrder);

                // Get paginated results
                $perPage = $request->input('per_page', 15);
                $orders = $query->paginate($perPage);

                // Check if any orders were found
                if ($orders->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No orders found matching the search criteria.',
                        'data' => [],
                        'pagination' => [
                            'total' => 0,
                            'per_page' => $perPage,
                            'current_page' => $orders->currentPage(),
                            'last_page' => 0,
                            'from' => null,
                            'to' => null
                        ]
                    ], 200);
                }

                return $this->successResponse([
                    'data' => OrderResource::collection($orders),
                    'pagination' => [
                        'total' => $orders->total(),
                        'per_page' => $orders->perPage(),
                        'current_page' => $orders->currentPage(),
                        'last_page' => $orders->lastPage(),
                        'from' => $orders->firstItem(),
                        'to' => $orders->lastItem(),
                    ]
                ]);

            } catch (\Illuminate\Database\QueryException $e) {
                \Log::error('Database error in OrderController@index: ' . $e->getMessage());
                return $this->errorResponse('Database error: ' . $e->getMessage(), 500);
            } catch (\Exception $e) {
                \Log::error('Error in OrderController@index: ' . $e->getMessage());
                \Log::error($e->getTraceAsString());
                return $this->errorResponse('Server error: ' . $e->getMessage(), 500);
            }

        } catch (\Exception $e) {
            \Log::error('Unexpected error in OrderController@index: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return $this->errorResponse('An unexpected error occurred', 500);
        }
    }

    /**
     * Get a single order by ID
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $order = OrderView::with(['paymentMethodTranslationEn'])->findOrFail($id);
            return $this->successResponse(new OrderResource($order));
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Order not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while fetching the order', 500);
        }
    }
}