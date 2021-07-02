<?php

namespace Tests\Feature;

use Tests\TestCase;

class ImagesManagementTest extends TestCase
{
    /** @test */
    public function it_can_list_all_the_images_when_there_are_images_in_session()
    {
        $this->withoutExceptionHandling();

        $response = $this->withSession(['images' => ['https://test.rxflodev.com/image-store/foo.png']])
            ->get('images')
            ->json('data');

        $this->assertCount(1, $response['images']);
    }

    /** @test */
    public function it_return_an_empty_array_of_images_when_there_are_no_images_in_session()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('images')
            ->json('data');

        $this->assertCount(0, $response['images']);
    }
}
