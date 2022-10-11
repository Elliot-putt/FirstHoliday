<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BackupController extends Controller {

    ///////////////////////////////////////////////////
    ///////////////// index Functions /////////////////
    ///////////////////////////////////////////////////
    public function index()
    {
        $files = collect(File::allFiles(Storage::disk('backup')->path('BookingSystem')))
            ->filter(function($file) {
                return $file->getExtension() == 'zip';
            })
            ->sortByDesc(function($file) {
                return $file->getCTime();
            })
            ->map(fn($file) => [
                'name' => $file->getBaseName(),
                'url' => 'storage/backup/bookingsystem/' . $file->getBaseName(),
            ]);

        return Inertia::render('Backups/View', [
            'files' => $files,
        ]);
    }
    ///////////////////////////////////////////////////
    /////// Database backup Functions /////////////////
    ///////////////////////////////////////////////////
    public function dbBackup()
    {
        Artisan::call('backup:run --only-db');

        return to_route('backups.index');

    }
    ///////////////////////////////////////////////////
    /////// Full backup Functions /////////////////////
    ///////////////////////////////////////////////////
    public function fullBackup()
    {

        Artisan::call('backup:run');

        return to_route('backups.index');
    }
    ///////////////////////////////////////////////////
    ////////// Delete backup Functions ////////////////
    //////////////////////////////////////////////////
    public function destroy()
    {

        $files = Storage::disk('backup')->allFiles('');
        Storage::disk('backup')->delete($files);
        Artisan::call('backup:run --only-db');

        return to_route('backups.index');
    }

}
