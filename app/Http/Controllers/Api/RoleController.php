<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDOException;

class RoleController extends Controller
{
    function getAll(): JsonResponse
    {
        try {
            $roles = Role::with(['permissions'])->get();
            return $this->sendResponse($roles, 'Roles retrieved successfully.', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function getRole($id): JsonResponse
    {
        try {
            $role = Role::with(['permissions'])->find($id);
            if (!$role) {
                return $this->sendError('Role not found.', [], Response::HTTP_NOT_FOUND);
            }
            return $this->sendResponse($role, 'Role retrieved successfully.', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function create(): JsonResponse
    {
        try {
            $validated = Validator::make(request()->all(), [
                'name' => 'required|string',
                'permissions' => 'required|array',
                'permissions.*' => 'required|exists:permissions,id',
            ]);

            if ($validated->fails()) {
                return $this->sendError('Validation error.', $validated->errors(), Response::HTTP_BAD_REQUEST);
            }

            $input = request()->all();

            $input['slug'] = strtolower(str_replace(' ', '-', $input['name'])); // Generate slug from name
            $input['is_active'] = true; // Set is_active to true by default

            $role = Role::create($input);

            $role->permissions()->attach($input['permissions']);

            $role->load('permissions');

            return $this->sendResponse($role, 'Role created successfully.', Response::HTTP_CREATED);
        } catch (ValidationException $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_BAD_REQUEST);
        } catch (PDOException $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function update($id): JsonResponse
    {
        try {
            $role = Role::findOrFail($id);

            $validated = Validator::make(request()->all(), [
                'name' => 'required|string',
                'permissions' => 'required|array',
                'permissions.*' => 'required|exists:permissions,id',
            ]);

            if ($validated->fails()) {
                return $this->sendError('Validation error.', $validated->errors(), Response::HTTP_BAD_REQUEST);
            }

            $input = request()->all();

            $input['slug'] = strtolower(str_replace(' ', '-', $input['name'])); // Generate slug from name

            $role->update($input);

            $role->permissions()->sync($input['permissions']);

            $role->load('permissions');

            return $this->sendResponse($role, 'Role updated successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError('Role not found.', [], Response::HTTP_NOT_FOUND);
        } catch (ValidationException $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_BAD_REQUEST);
        } catch (PDOException $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function delete($id): JsonResponse
    {
        try {
            $role = Role::findOrFail($id);

            $role->delete();

            return $this->sendResponse($role, 'Role deleted successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError('Role not found.', [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
