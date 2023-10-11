<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TouristType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDOException;

class TouristTypeController extends Controller
{
    function getAll(): JsonResponse
    {
        try {
            $location_id = request()->query('location_id', '');
            $city_id = request()->query('city_id', '');
            $state_id = request()->query('state_id', '');
            $country_id = request()->query('country_id', '');

            $query = TouristType::query();

            if ($location_id) {
                $query->whereHas('tourist_spots', function ($query) use ($location_id) {
                    $query->where('location_id', $location_id);
                });
            }

            $types = $query->get();

            return $this->sendResponse($types, 'Tourist Types retrieved successfully.', Response::HTTP_OK);
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

            $type = TouristType::create([
                'name' => request()->input('name'),
                'description' => request()->input('description'),
                'icon' => request()->input('icon'),
            ]);

            return $this->sendResponse($type, 'Tourist Type created successfully.', Response::HTTP_CREATED);
        } catch (ValidationException $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_BAD_REQUEST);
        } catch (PDOException $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
