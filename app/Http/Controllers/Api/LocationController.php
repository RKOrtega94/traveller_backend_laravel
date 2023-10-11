<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    function getAll(): JsonResponse
    {
        try {
            $limit = request()->query('limit', 10);
            $page = request()->query('page', 1);
            $search = request()->query('search', '');
            $city_id = request()->query('city_id', null);
            $state_id = request()->query('state_id', null);

            Log::info('Search: ' . $search);
            Log::info('City id: ' . $city_id);
            Log::info('State id: ' . $state_id);

            $locations = Location::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            })
                ->whereHas('city', function ($query) use ($city_id, $state_id) {
                    if ($city_id) {
                        $query->where('id', $city_id);
                    }

                    if ($state_id) {
                        $query->where('state_id', $state_id);
                    }
                })
                ->paginate($limit, ['*'], 'page', $page);

            $locations->load('city');

            Log::info($locations);

            return $this->sendResponse($locations, 'Locations retrieved successfully.', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
