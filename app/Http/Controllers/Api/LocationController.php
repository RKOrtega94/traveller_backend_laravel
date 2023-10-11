<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDOException;

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
            $country_id = request()->query('country_id', null);

            $locations = Location::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
                ->whereHas('city', function ($query) use ($city_id, $state_id, $country_id) {
                    $query->with('state')
                        ->join('states', 'cities.state_id', '=', 'states.id') // Add a join to the "states" table
                        ->when($city_id, function ($query, $city_id) {
                            return $query->where('city_id', $city_id);
                        })
                        ->when($state_id, function ($query, $state_id) {
                            return $query->where('state_id', $state_id);
                        })
                        ->when($country_id, function ($query, $country_id) {
                            return $query->where('states.country_id', $country_id); // Use the "states" table in the where clause
                        });
                })
                ->paginate($limit, ['*'], 'page', $page);

            $locations->load('city');

            return $this->sendResponse($locations, 'Locations retrieved successfully.', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function show($id): JsonResponse
    {
        try {
            $location = Location::findOrFail($id);

            $location->load('city');

            return $this->sendResponse($location, 'Location retrieved successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError('Location not found.', [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function create(): JsonResponse
    {
        try {
            $validated = Validator::make(request()->all(), [
                'name' => 'required|string',
                'zip_code' => 'required|string',
                'city_id' => 'required|exists:cities,id',
            ]);

            if ($validated->fails()) {
                return $this->sendError('Validation error.', $validated->errors(), Response::HTTP_BAD_REQUEST);
            }

            $input = request()->all();

            $location = Location::create($input);

            $location->load('city');

            return $this->sendResponse($location, 'Location created successfully.', Response::HTTP_CREATED);
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
            $location = Location::findOrFail($id);

            $validated = Validator::make(request()->all(), [
                'name' => 'required|string',
                'zip_code' => 'required|string',
                'city_id' => 'required|exists:cities,id',
            ]);

            if ($validated->fails()) {
                return $this->sendError('Validation error.', $validated->errors(), Response::HTTP_BAD_REQUEST);
            }

            $input = request()->all();

            $location->update($input);

            $location->load('city');

            return $this->sendResponse($location, 'Location updated successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError('Location not found.', [], Response::HTTP_NOT_FOUND);
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
            $location = Location::findOrFail($id);

            $location->delete();

            return $this->sendResponse($location, 'Location deleted successfully.', Response::HTTP_OK);
        } catch (ModelNotFoundException $th) {
            return $this->sendError('Location not found.', [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
