<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
}
