<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function __invoke(Penjualan $penjualan)
    {
        return Pdf::loadView('nota-penjualan', ['data' => $penjualan])
            ->setPaper([0, 0, 226.772, 600])
            ->download('nota.pdf');
    }
}
