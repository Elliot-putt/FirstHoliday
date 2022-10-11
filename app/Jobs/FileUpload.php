<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class FileUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file;
    private $model;
    private $collection;
    private $fileName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    //optional $document allows requests to be added so files can be approved for uploaded
    public function __construct($file, $model, $collection)
    {
        $this->file = $file;
        $this->collection = $collection;
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if($this->file)
        {
            foreach($this->file as $doc)
            {
                $file = $doc;
                $fileName = str_replace(" ", "_", $file->getClientOriginalName());
                $media = $this->model->addMedia($file)->toMediaCollection($this->collection);
                $media->name = $fileName;
                $media->save();

            }
        }
    }
}
