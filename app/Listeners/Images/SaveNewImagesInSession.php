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
        $images = array_merge($event->images, session()->get('images', []));
        session()->put('images', $images);
    }
}
