<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class InvoiceController extends Controller
{
    public function show(): View
    {
        // Demo invoice data — replace with a real Invoice model as needed.
        $invoice = [
            'number' => 'INV-'.now()->format('Ymd').'-001',
            'date' => now()->toDateString(),
            'from' => config('app.name'),
            'to' => 'Acme Corporation',
            'items' => [
                ['name' => 'Web Development', 'qty' => 1, 'price' => 2500.00],
                ['name' => 'UI/UX Design', 'qty' => 1, 'price' => 1200.00],
                ['name' => 'Hosting (12 months)', 'qty' => 12, 'price' => 25.00],
            ],
        ];

        return view('adminlte.invoice.index', compact('invoice'));
    }
}
