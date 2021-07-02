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
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index(): string
    {
        return $this->sendResponse(['images' => session()->get('images', [])]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param StorageService $storage
     * @return string
     */
    public function store(Request $request, StorageService $storage): string
    {
        try {
            $this->validate($request, ['images' => 'required', 'images.*' => 'image|mimes:png']);
            $savedImages = $storage->save($request->file('images'));
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
        $images = session()->get('images', []);
        if (isset($images[$index])) {
            array_splice($images, $index, 1);
            session()->put('images',$images);
            return $this->sendResponse(['message' => 'DELETED']);
        }

        return $this->sendError('NOT DELETED');
    }
}
