<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(Order $order)
    {
        return view('invoices.show', compact('order'));
    }

    public function download(Order $order)
    {
        $pdf = Pdf::loadView('invoices.pdf', compact('order'));
        return $pdf->download("invoice-{$order->id}.pdf");
    }
}
