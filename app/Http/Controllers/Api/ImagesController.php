<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StorageService;
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
     * @return string
     */
    public function index(): string
    {
        return $this->sendResponse(['images' => $this->storage->all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request): string
    {
        try {
            $this->validate($request, ['images' => 'required', 'images.*' => 'image|mimes:png']);
            $savedImages = $this->storage->save($request->file('images'));
            $response = $this->sendResponse(['images' => $savedImages]);
        } catch (ValidationException $e) {
            $errors = Arr::flatten($e->errors());
            $response = $this->sendError(array_shift($errors));
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $index
     * @return string
     */
    public function destroy($index): string
    {
        if ($this->storage->delete($index)) {
            return $this->sendResponse(['message' => 'DELETED']);
        }

        return $this->sendError('NOT DELETED');
    }
}
