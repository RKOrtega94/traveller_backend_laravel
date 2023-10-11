<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDOException;

class CategoryController extends Controller
{
    function getAll(): JsonResponse
    {
        try {
            $search = request()->query('search', '');

            $categories = Category::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })->get();

            return $this->sendResponse($categories, 'Categories retrieved successfully.', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function create(): JsonResponse
    {
        try {
            $validated = Validator::make(request()->all(), [
                'name' => 'required|string',
                'description' => 'required|string',
                'icon' => 'string',
            ]);

            if ($validated->fails()) {
                return $this->sendError('Validation error.', $validated->errors(), Response::HTTP_BAD_REQUEST);
            }

            $category = Category::create(request()->all());

            return $this->sendResponse($category, 'Category created successfully.', Response::HTTP_CREATED);
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
            $category = Category::findOrFail($id);

            $category->load([
                'tourist_spot' => function ($query) {
                    $query->with(['location']);
                }
            ]);

            return $this->sendResponse($category, 'Category retrieved successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function update($id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);

            $validated = Validator::make(request()->all(), [
                'name' => 'string',
                'description' => 'string',
                'icon' => 'string',
            ]);

            if ($validated->fails()) {
                return $this->sendError('Validation error.', $validated->errors(), Response::HTTP_BAD_REQUEST);
            }

            $category->update(request()->all());

            return $this->sendResponse($category, 'Category updated successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_NOT_FOUND);
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
            $category = Category::findOrFail($id);

            $category->delete();

            return $this->sendResponse($category, 'Category deleted successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
