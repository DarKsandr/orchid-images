<?php

namespace DarKsandr\Images;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\Models\Attachment;

class Image
{
    protected string $resize_name;
    protected array $resizes;

    protected string $format;

    public function __construct()
    {
        $this
            ->setResize(config('images.default'))
            ->setFormat(config('images.format'));
    }

    public function setResize(string $name): self
    {
        $this->resize_name = $name;
        $resizes = config('images.resizes', []);
        $this->resizes = $resizes[ $this->resize_name ];

        return $this;
    }

    public function setFormat(string $name): self
    {
        $this->format = $name;

        return $this;
    }

    public function save(Collection $attachments): void
    {
        $directory = 'resizes';
        Storage::makeDirectory($directory);
        $attachments->each(function(Attachment $attachment) use($directory){
            $files = [];
            $path = $directory."/".$attachment->id."/";

            Storage::deleteDirectory($path);
            Storage::makeDirectory($path);

            foreach ($this->resizes as $resize){
                $img = \Intervention\Image\Facades\Image::make(Storage::path($attachment->physicalPath()));

                if(!(empty($resize['width']) && empty($resize['height']))){
                    $img->resize($resize['width'], $resize['height'], function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                $name = uniqid() .'.'.$this->format;
                $filepath = $path.$name;
                $img->save(Storage::path($filepath));

                $files[] = [...$resize, 'srcset' => $filepath];
            }

            Storage::put($path.'map.json', json_encode($files, JSON_UNESCAPED_UNICODE));
        });
    }

    static public function make(Collection $attachments): void
    {
        $image = new self;
        $image->save($attachments);
    }

    static public function resize(string $name): self
    {
        $image = new self;
        return $image->setResize($name);
    }
}