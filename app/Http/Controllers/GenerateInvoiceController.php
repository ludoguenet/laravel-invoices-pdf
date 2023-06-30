<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GenerateInvoiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $invoice = Invoice::first();

        if (Storage::directoryMissing('invoices')) {
            Storage::makeDirectory('invoices');
        }

        Pdf::loadView('invoices.index', ['invoice' => $invoice])
            ->save($filename = Storage::path('invoices') . DIRECTORY_SEPARATOR . $invoice->id . '.pdf');

        return response()->file($filename);
    }
}
