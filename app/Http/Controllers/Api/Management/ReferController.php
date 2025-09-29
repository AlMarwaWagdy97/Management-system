<?php

namespace App\Http\Controllers\Api\Management;

use App\Models\Refer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Management\ReferResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReferController extends Controller
{
    /**
     * Display a listing of the refers with filters.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Refer::with([
            'account' => function($q) {
                $q->select(['id', 'user_name', 'email', 'mobile', 'status', 'image']);
            },
            'managers' => function($q) {
                $q->select(['managers.id', 'managers.name', 'managers.status']);
            }
        ])
        ->select('refers.*') // Explicitly select all columns from refers table
        ->orderBy('id', 'DESC');

        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', (int)$request->status);
        }

        // Search in all relevant fields
        if ($request->has('name') && $request->name !== '') {
            $search = $request->name;
            $query->where(function($q) use ($search) {
                // Search in refer table fields
                $q->where('refers.name', 'like', "%{$search}%")
                  ->orWhere('refers.employee_name', 'like', "%{$search}%")
                  ->orWhere('refers.code', 'like', "%{$search}%");
            });
        }

        // Individual filters (for more specific searches)
        if ($request->has('code') && $request->code !== '') {
            $query->where('code', $request->code);
        }

        if ($request->has('employee_number') && $request->employee_number !== '') {
            $query->where('employee_number', $request->employee_number);
        }

        if ($request->has('department') && $request->department !== '') {
            $query->where('employee_department', 'like', "%{$request->department}%");
        }

        if ($request->has('job') && $request->job !== '') {
            $query->where('job', 'like', "%{$request->job}%");
        }

        if ($request->has('is_group_manager') && $request->is_group_manager !== '') {
            $query->where('is_group_manager', (bool)$request->is_group_manager);
        }

        $perPage = $request->input('per_page', 15);
        $refers = $query->paginate($perPage);

        $response = [
            'success' => $refers->isNotEmpty(),
            'message' => $refers->isNotEmpty() ? 'Data retrieved successfully.' : 'No data found matching your criteria.',
            'data' => $refers->isNotEmpty() ? ReferResource::collection($refers) : [],
            'pagination' => [
                'total' => $refers->total(),
                'per_page' => $refers->perPage(),
                'current_page' => $refers->currentPage(),
                'last_page' => $refers->lastPage(),
                'from' => $refers->firstItem(),
                'to' => $refers->lastItem(),
            ]
        ];

        return response()->json($response);
    }

    /**
     * Store a newly created refer in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'employee_name' => 'nullable|string|max:255',
            'employee_number' => 'nullable|string|max:50',
            'employee_department' => 'nullable|string|max:255',
            'ax_store_name' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'location' => 'nullable|string',
            'details' => 'nullable|string',
            'status' => 'boolean',
            'employee_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('employee_image')) {
            $imagePath = $request->file('employee_image')->store('refers', 'public');
        }

        $refer = Refer::create([
            'account_id' => auth()->id() ?? 1, // Default to 1 if not authenticated
            'slug' => Str::slug($request->name . '-' . time()),
            'name' => $request->name,
            'employee_name' => $request->employee_name,
            'employee_number' => $request->employee_number,
            'employee_image' => $imagePath,
            'employee_department' => $request->employee_department,
            'ax_store_name' => $request->ax_store_name,
            'job' => $request->job,
            'whatsapp' => $request->whatsapp,
            'location' => $request->location,
            'details' => $request->details,
            'status' => $request->status ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Refer created successfully',
            'data' => new ReferResource($refer)
        ], 201);
    }

    /**
     * Display the specified refer.
     */
    public function show($id): JsonResponse
    {
        $refer = Refer::find($id);

        if (!$refer) {
            return response()->json([
                'success' => false,
                'message' => 'Refer not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ReferResource($refer)
        ]);
    }

    /**
     * Update the specified refer in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $refer = Refer::find($id);

        if (!$refer) {
            return response()->json([
                'success' => false,
                'message' => 'Refer not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'employee_name' => 'nullable|string|max:255',
            'employee_number' => 'nullable|string|max:50',
            'employee_department' => 'nullable|string|max:255',
            'ax_store_name' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'location' => 'nullable|string',
            'details' => 'nullable|string',
            'status' => 'boolean',
            'employee_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle file upload
        if ($request->hasFile('employee_image')) {
            // Delete old image if exists
            if ($refer->employee_image) {
                \Storage::disk('public')->delete($refer->employee_image);
            }
            $imagePath = $request->file('employee_image')->store('refers', 'public');
            $refer->employee_image = $imagePath;
        }

        $refer->update([
            'name' => $request->name ?? $refer->name,
            'employee_name' => $request->has('employee_name') ? $request->employee_name : $refer->employee_name,
            'employee_number' => $request->has('employee_number') ? $request->employee_number : $refer->employee_number,
            'employee_department' => $request->has('employee_department') ? $request->employee_department : $refer->employee_department,
            'ax_store_name' => $request->has('ax_store_name') ? $request->ax_store_name : $refer->ax_store_name,
            'job' => $request->has('job') ? $request->job : $refer->job,
            'whatsapp' => $request->has('whatsapp') ? $request->whatsapp : $refer->whatsapp,
            'location' => $request->has('location') ? $request->location : $refer->location,
            'details' => $request->has('details') ? $request->details : $refer->details,
            'status' => $request->has('status') ? $request->status : $refer->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Refer updated successfully',
            'data' => new ReferResource($refer)
        ]);
    }

    /**
     * Remove the specified refer from storage.
     */
    public function destroy($id): JsonResponse
    {
        $refer = Refer::find($id);

        if (!$refer) {
            return response()->json([
                'success' => false,
                'message' => 'Refer not found'
            ], 404);
        }

        // Delete image if exists
        if ($refer->employee_image) {
            \Storage::disk('public')->delete($refer->employee_image);
        }

        $refer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Refer deleted successfully'
        ]);
    }
}
