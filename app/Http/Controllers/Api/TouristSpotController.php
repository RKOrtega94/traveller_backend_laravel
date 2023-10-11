<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TouristSpot;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDOException;

class TouristSpotController extends Controller
{
    function getAll(): JsonResponse
    {
        try {
            $search = request()->query('search', '');
            $limit = request()->query('limit', 10);
            $page = request()->query('page', 1);

            // $location = request()->query('location', '');

            $touristSpot = TouristSpot::where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->paginate($limit, ['*'], 'page', $page);

            $touristSpot->load(['location', 'categories']);

            return $this->sendResponse($touristSpot, 'Tourist Spot retrieved successfully.', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function show($id): JsonResponse
    {
        try {
            $touristSpot = TouristSpot::findOrFail($id);

            $touristSpot->load(['location', 'categories']);

            return $this->sendResponse($touristSpot, 'Tourist Spot retrieved successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError('Tourist spot not found.', [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function create(): JsonResponse
    {
        try {
            $validated = Validator::make(request()->all(), [
                'name' => 'required|string',
                'description' => 'nullable|string',
                'address' => 'nullable|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'location_id' => 'required|integer',
            ]);

            if ($validated->fails()) {
                return $this->sendError("Validation fails.", $validated->errors(), Response::HTTP_BAD_REQUEST);
            }

            $touristSpot = TouristSpot::create($validated->validated());

            $touristSpot->load(['location', 'categories']);

            return $this->sendResponse($touristSpot, 'Tourist Spot created successfully.', Response::HTTP_CREATED);
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
            $touristSpot = TouristSpot::findOrFail($id);

            $validated = Validator::make(request()->all(), [
                'name' => 'required|string',
                'description' => 'nullable|string',
                'address' => 'nullable|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'location_id' => 'required|integer',
            ]);

            if ($validated->fails()) {
                return $this->sendError("Validation fails.", $validated->errors(), Response::HTTP_BAD_REQUEST);
            }

            $touristSpot->update($validated->validated());

            $touristSpot->load(['location', 'categories']);

            return $this->sendResponse($touristSpot, 'Tourist Spot updated successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError('Tourist spot not found.', [], Response::HTTP_NOT_FOUND);
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
            $touristSpot = TouristSpot::findOrFail($id);

            $touristSpot->delete();

            return $this->sendResponse($touristSpot, 'Tourist Spot deleted successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError('Tourist spot not found.', [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
