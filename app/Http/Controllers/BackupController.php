<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
   public function index()
{
    $files = Storage::files('backups');

    return view('backup.index', compact('files'));
}


   public function create()
{
    $fileName = 'backup_' . date('dmY') . '.sql';

    $path = storage_path('app/backups/' . $fileName);

    if (!file_exists(storage_path('app/backups'))) {
        mkdir(storage_path('app/backups'), 0755, true);
    }

    $database = env('DB_DATABASE');
    $username = env('DB_USERNAME');
    $password = env('DB_PASSWORD');

    $mysqldump = "C:\\xamppnew\\mysql\\bin\\mysqldump.exe";

    $command = "\"{$mysqldump}\" -u {$username} ";

    if ($password) {
        $command .= "-p{$password} ";
    }

    $command .= "{$database} > \"{$path}\"";

    system($command);


    return back()->with(
        'success',
        'Database backup created successfully'
    );
}
}
