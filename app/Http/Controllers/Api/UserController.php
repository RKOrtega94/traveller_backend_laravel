<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDOException;

class UserController extends Controller
{
    /**
     * Get all users.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getAll(Request $request): JsonResponse
    {
        try {
            $search = $request->query('search', '');
            $limit = $request->query('limit', 10);
            $page = $request->query('page', 1);

            $users = User::where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->paginate($limit, ['*'], 'page', $page);

            $users->load('role');
            return $this->sendResponse($users, 'Users retrieved successfully.', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function create(Request $request): JsonResponse
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string',
                'role_id' => 'required|exists:roles,id',
            ]);

            if ($validated->fails()) {
                return $this->sendError('Validation error.', $validated->errors(), Response::HTTP_BAD_REQUEST);
            }

            $user = User::create([
                'name' => request()->input('name'),
                'email' => request()->input('email'),
                'password' => bcrypt(request()->input('password')),
                'role_id' => request()->input('role_id'),
            ]);

            $user->load('role');

            return $this->sendResponse($user, 'User created successfully.', Response::HTTP_CREATED);
        } catch (ValidationException $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_BAD_REQUEST);
        } catch (PDOException $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function show($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            $user->load('role');

            return $this->sendResponse($user, 'User retrieved successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError('User not found.', [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function update(Request $request, $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            $validated = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'required|string',
                'role_id' => 'required|exists:roles,id',
            ]);

            if ($validated->fails()) {
                return $this->sendError('Validation error.', $validated->errors(), Response::HTTP_BAD_REQUEST);
            }

            $user->update([
                'name' => request()->input('name'),
                'email' => request()->input('email'),
                'password' => bcrypt(request()->input('password')),
                'role_id' => request()->input('role_id'),
            ]);

            $user->load('role');

            return $this->sendResponse($user, 'User updated successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError('User not found.', [], Response::HTTP_NOT_FOUND);
        } catch (ValidationException $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (PDOException $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function delete($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();

            return $this->sendResponse($user, 'User deleted successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError('User not found.', [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
