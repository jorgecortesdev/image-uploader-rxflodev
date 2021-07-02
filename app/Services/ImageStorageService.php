<?php

namespace App\Services;

use App\Events\ImageSaved;
use Illuminate\Support\Facades\Http;

class ImageStorageService implements StorageService
{
    /**
     * @var string
     */
    protected $host;

    public function __construct()
    {
        $this->host = config('services.rxflodev.host');
    }

    public function all(): array
    {
        return session()->get('images', []);
    }

    public function save(array $images): array
    {
        $savedImages = [];

        foreach ($images as $image) {
            $savedImages[] = $this->postImage($image);
        }

        $savedImages = $this->latest($savedImages);

        ImageSaved::dispatch($savedImages);

        return $savedImages;
    }

    public function delete(int $id): bool
    {
        $images = session()->get('images', []);
        if (isset($images[$id])) {
            array_splice($images, $id, 1);
            session()->put('images', $images);
            return true;
        }

        return false;
    }

    /**
     * @param $image
     * @return string
     */
    protected function encodeImage($image): string
    {
        return base64_encode(file_get_contents($image->path()));
    }

    /**
     * @param $image
     * @return string
     */
    protected function postImage($image): string
    {
        $response = Http::asForm()->post($this->host, ['imageData' => $this->encodeImage($image)]);

        return $response->json('url');
    }

    /**
     * @param array $savedImages
     * @return array
     */
    protected function latest(array $savedImages): array
    {
        return array_reverse($savedImages);
    }

}
