<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class ImageSaved
{
    use Dispatchable;

    /**
     * @var array
     */
    public $images;

    /**
     * Create a new event instance.
     *
     * @param array $images
     */
    public function __construct(array $images)
    {
        $this->images = $images;
    }
}
