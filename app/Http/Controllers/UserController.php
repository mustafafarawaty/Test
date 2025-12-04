<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Requests\UpdateUserRequest;

/**
 * Controller for managing users (list, update, delete).
 */
class UserController extends Controller
{

    /**
     * List all users.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::select('id', 'name', 'email', 'role', 'created_at')->paginate(15);

        return response()->json($users);
    }

    /**
     * Show a single user (self or admin).
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
         $auth= auth('api')->user();

         // Only admin or owner can see profile
         if ($auth->id !== $user->id & $auth->role !== 'admin') {
            return response()->json(['error' => 'Forbidden'], 403);
         }

        return response()->json($user);
    }

    /**
     * Update a user`s data.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
         $auth= auth('api')->user();

        // Only admin or owner can update
        if ($auth->id !== $user->id && $auth->role !== 'admin') {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $data = $request->only(['name', 'email', 'role']);

        // Only admin can update user`s role
        if (isset($data['role']) && !is_null($data['role'])) {

            if ($auth->role !== 'admin') {
                return response()->json(['error' => 'Only The Admin Can Change The Role'], 403);
            }

            if ($auth->id == $user->id) {
                return response()->json(['error' => 'You Cant Change Your Own Role'], 403);
            }
          
        }

        $user->update($data);

        return response()->json(['message' => 'User updated', 'user' => $user]);
    }

    /**
     * Delete a user.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $auth = auth('api')->user();

           if ($auth->id == $user->id) {
                return response()->json(['error' => 'You Cant Delete Your Own Account'], 403);
            }
            
        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}
