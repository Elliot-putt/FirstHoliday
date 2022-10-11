<?php

namespace App\Http\Controllers;

use App\Jobs\FileUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller {

    /////////////////////////////////////////////
    ///////////////Media delete//////////////////
    /////////////////////////////////////////////
    public function fileDelete(int $file): RedirectResponse
    {
        if($file)
        {
            $storedFile = Media::whereId($file)->first();
            $storedFile->delete();
        }

        return back()->with('success_message', 'File Successfully deleted from the system!');
    }

    public static function fileDeleteMethod(int $file): RedirectResponse
    {
        if($file)
        {
            $storedFile = Media::whereId($file)->first();
            $storedFile->delete();
        }

        return back()->with('success_message', 'File Successfully deleted from the system!');
    }

}
