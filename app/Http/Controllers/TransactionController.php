<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use PDF;

class TransactionController extends Controller
{
    public function export(Request $request, $format)
    {
        // Construye la query con los filtros
        $query = \App\Models\BoxTransaction::with('vendor')
            ->when($request->vendor_id,   fn($q) => $q->where('vendor_id', $request->vendor_id))
            ->when($request->from,        fn($q) => $q->whereDate('created_at', '>=', $request->from))
            ->when($request->to,          fn($q) => $q->whereDate('created_at', '<=', $request->to))
            ->when($request->filter_type, fn($q) => $q->where('type', $request->filter_type))
            ->when($request->search_notes,fn($q) => $q->where('notes', 'like', "%{$request->search_notes}%"));

        if ($format === 'excel') {
            return Excel::download(
                new TransactionsExport($query),
                'historial_'.now()->format('Ymd_His').'.xlsx'
            );
        }

        if ($format === 'pdf') {
            $transactions = $query->get();
            $pdf = PDF::loadView('box.dashboard.exports.pdf', compact('transactions'));
            return $pdf->download('historial_'.now()->format('Ymd_His').'.pdf');
        }

        abort(400, 'Formato no soportado.');
    }
}
