<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ImageUploadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $host = $this->getHost();

        Http::fake([
            "${host}/*" => Http::response([
                'status' => 'success',
                'message' => 'Image saved successfully.',
                'url' => 'https://test.rxflodev.com/image-store/foo.png'
            ], 200)
        ]);
    }

    /** @test */
    public function it_allows_a_user_to_post_one_image()
    {
        $file = UploadedFile::fake()->image('foo.png');

        $response = $this->post('images', ['images' => [$file]]);

        $response->assertJson([
            'status' => 'success',
            'data' => [
                'images' => [
                    'https://test.rxflodev.com/image-store/foo.png'
                ]
            ]
        ]);
    }

    /** @test */
    public function it_allows_a_user_to_post_two_images()
    {
        $fileOne = UploadedFile::fake()->image('foo.png');
        $fileTwo = UploadedFile::fake()->image('foo.png');

        $response = $this->post('images', ['images' => [$fileOne, $fileTwo]]);

        $response->assertJson([
            'status' => 'success',
            'data' => [
                'images' => [
                    'https://test.rxflodev.com/image-store/foo.png',
                    'https://test.rxflodev.com/image-store/foo.png',
                ]
            ]
        ]);
    }

    /** @test */
    public function it_requires_images_field()
    {
        $response = $this->post('images', []);

        $response->assertJson([
            'status' => 'error',
            'message' => 'The images field is required.'
        ]);
    }

    /** @test */
    public function it_only_allows_png_format()
    {
        $file = UploadedFile::fake()->image('foo.gif');

        $response = $this->post('images', ['images' => [$file]]);

        $response->assertJson([
            'status' => 'error',
            'message' => "The images.0 must be a file of type: png."
        ]);
    }

    /** @test */
    public function it_can_put_a_saved_image_in_session()
    {
        $file = UploadedFile::fake()->image('foo.png');

        $response = $this->post('images', ['images' => [$file]]);

        $response->assertSessionHas(['images' => [
            'https://test.rxflodev.com/image-store/foo.png'
        ]]);
    }

    /** @test */
    public function it_can_put_multiple_saved_images_in_session()
    {
        $fileOne = UploadedFile::fake()->image('foo.png');
        $fileTwo = UploadedFile::fake()->image('foo.png');

        $response = $this->post('images', ['images' => [$fileOne, $fileTwo]]);

        $response->assertSessionHas(['images' => [
            'https://test.rxflodev.com/image-store/foo.png',
            'https://test.rxflodev.com/image-store/foo.png',
        ]]);
    }

    /**
     * @return mixed
     */
    protected function getHost()
    {
        return parse_url(
            config('services.rxflodev')['host']
        )['host'];
    }
}
