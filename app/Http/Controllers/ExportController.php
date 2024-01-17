<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AirmaxClientsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AirmaxClient;

class ExportController extends Controller
{
    public function airmax()
    {
        $this->authorize('viewAny', AirmaxClient::class);
        return Excel::download(new AirmaxClientsExport, 'airmax-clients.xlsx');;
    }
}
