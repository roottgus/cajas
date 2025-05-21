<?php

use App\Http\Controllers\BoxController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Splash Landing
Route::get('/', [BoxController::class, 'landing'])->name('landing');

// Reporte Público (sin auth)
Route::get('/box/public', [BoxController::class, 'publicIndex'])->name('box.public');

// Detalle de Vendedor (público también)
Route::get('/box/vendor/{vendor}', [BoxController::class, 'vendorView'])
     ->name('box.vendor');

// Breeze auth routes (login, register, logout…)
require __DIR__.'/auth.php';

// Rutas protegidas para Administrador
Route::middleware('auth')->group(function () {

    // Dashboard global de administración
    Route::get('/box/dashboard', [BoxController::class, 'dashboard'])
         ->name('box.dashboard');

    // Listar
    Route::get('/box/vendors', [BoxController::class, 'vendorsIndex'])
         ->name('box.vendors.index');

    // Crear
    Route::post('/box/vendors', [BoxController::class, 'vendorsStore'])
         ->name('box.vendors.store');

    // Editar
    Route::get('/box/vendors/{vendor}/edit', [BoxController::class, 'vendorsEdit'])
         ->name('box.vendors.edit');
    Route::put('/box/vendors/{vendor}', [BoxController::class, 'vendorsUpdate'])
         ->name('box.vendors.update');

    // Eliminar
    Route::delete('/box/vendors/{vendor}', [BoxController::class, 'vendorsDestroy'])
         ->name('box.vendors.destroy');
        
    // Reporte manual de cajas por el admin (salida/ingreso)
    Route::post('/box/issue',  [BoxController::class, 'issue'])
         ->name('box.issue');
    Route::post('/box/return', [BoxController::class, 'return'])
         ->name('box.return');

    // Editar transacción
    Route::get('/box/transaction/{transaction}/edit', [BoxController::class, 'editTransaction'])
         ->name('box.transaction.edit');
    Route::patch('/box/transaction/{transaction}', [BoxController::class, 'updateTransaction'])
         ->name('box.transaction.update');

    // Eliminar transacción (opcional)
    Route::delete('/box/transaction/{transaction}', [BoxController::class, 'destroyTransaction'])
         ->name('box.transaction.destroy');

    // Exportar transacciones filtradas en Excel o PDF
    Route::get('/box/transactions/export/{format}', [TransactionController::class, 'export'])
         ->name('box.transactions.export');

});

// API para estadísticas dinámicas del admin (sin recarga completa)
Route::get('/api/admin/stats', function (Request $request) {
    $query = \App\Models\BoxTransaction::query();

    // Filtro por vendedor
    if ($request->filled('vendor_id')) {
        $query->where('vendor_id', $request->vendor_id);
    }

    // Filtro por rango de fechas
    if ($request->filled('from')) {
        $query->whereDate('created_at', '>=', $request->from);
    }
    if ($request->filled('to')) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    // Filtro por tipo de transacción
    if ($request->filled('filter_type')) {
        $query->where('type', $request->filter_type);
    }

    // Búsqueda libre en notas
    if ($request->filled('search_notes')) {
        $query->where('notes', 'like', '%'.$request->search_notes.'%');
    }

    // Cálculo de estadísticas
    $issued   = (clone $query)->where('type', 'issue')->sum('quantity');
    $returned = (clone $query)->where('type', 'return')->sum('quantity');
    $pending  = $issued - $returned;

    // Recuperar transacciones filtradas
    $transactions = $query
        ->with('vendor', 'admin')
        ->orderBy('created_at', 'desc')
        ->get(['id', 'vendor_id', 'admin_id', 'type', 'quantity', 'notes', 'created_at']);

    return response()->json([
        'stats'        => compact('issued', 'returned', 'pending'),
        'transactions' => $transactions,
    ]);
})->middleware('auth');
