<?php

namespace App\Http\Controllers\Api\Management;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    /**
     * Display a listing of the managers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $name = $request->input('name');
            $email = $request->input('email');
            $mobile = $request->input('mobile');
            $status = $request->input('status');
            $perPage = $request->input('per_page', 15);

            $query = Manager::query()
                ->with(['account' => function($q) {
                    $q->select(['id', 'user_name', 'email', 'mobile', 'status', 'image']);
                }]);

            if ($request->has('email') && $email !== '') {
                $query->whereHas('account', function($q) use ($email) {
                    $q->where('email', 'like', "%{$email}%");
                });
            }

            if ($request->has('name') && $name !== '') {
                $query->where('name', 'like', "%{$name}%");
            }

            if ($request->has('mobile') && $mobile !== '') {
                $query->whereHas('account', function($q) use ($mobile) {
                    $q->where('mobile', 'like', "%{$mobile}%");
                });
            }

            // Apply status filter
            if ($request->has('status') && $status !== '') {
                $query->where('status', $status);
            }

            // Apply general search (only if no specific filters are set)
            $hasSpecificFilters = $request->has('email') || $request->has('name') || $request->has('mobile');
            if ($search && !$hasSpecificFilters) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhereHas('account', function($q) use ($search) {
                          $q->where('user_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                      });
                });
            }

            // Get paginated results
            $managers = $query->paginate($perPage);

            // Format the response
            $response = [
                'success' => true,
                'data' => $managers->isEmpty() ? [] : $managers->items(),
                'current_page' => $managers->currentPage(),
                'per_page' => (int)$managers->perPage(),
                'total' => $managers->total(),
                'last_page' => $managers->lastPage()
            ];

            // Add empty message if no results
            if ($managers->isEmpty()) {
                $response['message'] = 'لا توجد بيانات';
            }

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ ما',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Apply filters to the query
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param Request $request
     * @return void
     */
    protected function applyFilters($query, Request $request)
    {
        // Apply status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('account', function($q) use ($search) {
                      $q->where('user_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%");
                  });
            });
        }
    }

    // Add other methods (show, store, update, destroy) as needed
}
