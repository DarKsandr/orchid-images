<?php

namespace DarKsandr\Images\Components;

use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;
use Illuminate\View\View;
use Orchid\Attachment\Models\Attachment;

class ImageComponent extends Component
{
    public array $resizes;

    public function __construct(
        public Attachment $image
    ){
        $this->resizes = Storage::fileExists("resizes/{$image->id}/map.json")
            ? json_decode(Storage::get("resizes/{$image->id}/map.json"))
            : [];
    }

    public function render(): View
    {
        return view('images::components.image');
    }
}