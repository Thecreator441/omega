<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $disk = Storage::disk('backups');

        $files = $disk->files(env('APP_NAME'));
        $backups = [];

        // make an array of backup files, with their filesize and creation date
        foreach ($files as $key => $file) {
            // only take the zip files into account
            if ($disk->exists($file) && substr($file, -4) === '.zip') {
                $backups[] = [
                    'file_path' => $file,
                    'file_name' => str_replace(env('APP_NAME') . '/', '', $file),
                    'file_size' => $disk->size($file),
                    'last_modified' => $disk->lastModified($file),
                    'age' => $disk->lastModified($file) - $disk->size($file),
                    'disk' => 'backups'
                ];
            }
        }

        // reverse the backups, so the newest one would be on top
        $backups = array_reverse($backups);
//        dd($backups);
        return view("admin.pages.backup")->with(compact('backups'));
    }

    public function store()
    {
//        dd(Request::all());
        try {
            // start the backup process
            Artisan::call('backup:run');
//            $output = Artisan::output();

            // log the results
            Log::info("New backup started by admin interface \r\n");

            return Redirect::back()->with('success', trans('alertDanger.backup'));
        } catch (\Exception $ex) {
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.backup'));
        }
    }

    /**
     * Downloads a backup zip file.
     *
     * TODO: make it work no matter the flysystem driver (S3 Bucket, etc).
     */
    public function download()
    {
        try {
            $file_path = storage_path(Request::input('disk') . '/' . env('APP_NAME') . '/' . Request::input('file_name'));
            $file = env('APP_NAME') . '/' . Request::input('file_name');
            $disk = Storage::disk(Request::input('disk'));

            if ($disk->exists($file)) {
//                $stream = $disk->readStream($file);
                $headers = [
                    "Content-Type" => $disk->getMimetype($file),
                    "Content-Length" => $disk->getSize($file),
                    "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
                ];
//
//                return \Response::stream(function () use ($stream) {
//                    fpassthru($stream);
//                }, 200, $headers);

                return \Response::download($file_path, basename($file), $headers);
            }
        } catch (\Exception $ex) {
            dd($ex);
        }
    }

    /**
     * Deletes a backup file.
     */
    public function delete()
    {
        try {
            $disk = Storage::disk(Request::input('disk'));
            $file = env('APP_NAME') . '/' . Request::input('file_name');

            $disk->delete($file);

            return Redirect::back()->with('success', trans('alertSuccess.backupdel'));
        } catch (\Exception $ex) {
            return Redirect::back()->with('danger', trans('alertDanger.backupdel'));
        }
    }
}
