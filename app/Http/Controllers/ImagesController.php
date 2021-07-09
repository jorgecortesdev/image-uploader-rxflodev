<?php

namespace App\Http\Controllers;

use App\Services\StorageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class ImagesController extends Controller
{
    /**
     * @var StorageService
     */
    protected $storage;

    /**
     * @param StorageService $storage
     */
    public function __construct(StorageService $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->sendJsonResponse(['images' => $this->storage->all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $this->validate($request, ['images' => 'required', 'images.*' => 'image|mimes:png'], ['mimes' => 'File type must be png']);
            $savedImages = $this->storage->save($request->file('images'));
            return $this->sendJsonResponse(['images' => $savedImages], 201);
        } catch (ValidationException $e) {
            $errors = Arr::flatten($e->errors());
            return $this->sendJsonError(array_shift($errors), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->storage->delete($id)) {
            return $this->sendJsonResponse(['message' => 'DELETED'], 204);
        }

        return $this->sendJsonResponse(['message' => 'Nothing happened!']);
    }
}
