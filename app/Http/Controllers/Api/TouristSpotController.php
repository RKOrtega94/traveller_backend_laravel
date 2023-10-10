<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TouristSpot;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

            $touristSpot->load('location');

            return $this->sendResponse($touristSpot, 'Tourist Spot retrieved successfully.', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function show($id): JsonResponse
    {
        try {
            $touristSpot = TouristSpot::findOrFail($id);

            $touristSpot->load('location');

            return $this->sendResponse($touristSpot, 'Tourist Spot retrieved successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError('Tourist spot not found.', [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
