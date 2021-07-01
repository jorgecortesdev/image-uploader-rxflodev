<?php

namespace App\Listeners\Images;

use App\Events\ImageSaved;

class SaveNewImagesInSession
{
    /**
     * Handle the event.
     *
     * @param ImageSaved $event
     * @return void
     */
    public function handle(ImageSaved $event)
    {
        foreach ($event->images as $image) {
            session()->push('images', $image);
        }
    }
}
