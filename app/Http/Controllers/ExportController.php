<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AirmaxClientsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AirmaxClient;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function airmax(Request $request)
    {
        $this->authorize('viewAny', AirmaxClient::class);
        return Excel::download(new AirmaxClientsExport($request->query('keyword')), 'airmax-clients.xlsx');
    }

    public function backup()
    {
        $this->authorize('update', AirmaxClient::class);
        $available = Storage::files('backup');
        $latest = array_pop($available);
        if ($latest) {
            return Storage::download($latest);
        }      
    }
}
