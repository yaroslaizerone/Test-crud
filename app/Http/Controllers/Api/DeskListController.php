<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListStoreRequest;
use App\Http\Resources\ListResource;
use App\Models\DeskList;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;

class DeskListController extends Controller
{
    public function index()
    {
        try {
            return ListResource::collection(DeskList::all());
        } catch (Exception $e) {
            Log::error('Error in DeskListController@index: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function store(ListStoreRequest $request)
    {
        try {
            $created_list = DeskList::create($request->validated());
            return new ListResource($created_list);
        } catch (Exception $e) {
            Log::error('Error in DeskListController@store: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        try {
            return new ListResource(DeskList::findOrFail($id));
        } catch (Exception $e) {
            Log::error('Error in DeskListController@show: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(ListStoreRequest $request, DeskList $deskList)
    {
        try {
            $deskList->update($request->validated());
            return new ListResource($deskList);
        } catch (Exception $e) {
            Log::error('Error in DeskListController@update: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage() ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Находим запись по ID
            $deskList = DeskList::findOrFail($id);

            // Удаляем запись
            $deskList->forceDelete();

            // Ответ на запрос удаления
            return response(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Запись не найдена.'], 404);
        } catch (Exception $e) {
            Log::error('Error in DeskListController@destroy: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
