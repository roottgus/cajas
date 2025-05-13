<?php

namespace App\Http\Controllers;

use App\Models\BoxTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BoxController extends Controller
{
    /**
     * Splash Landing de FritoLay
     */
    public function landing()
    {
        return view('landing');
    }

    /**
     * Reporte público: lista todos los vendedores con sus estadísticas
     */
    public function publicIndex()
    {
        $vendors = User::where('is_admin', false)
            ->get()
            ->map(function($vendor) {
                $issued   = BoxTransaction::where('vendor_id', $vendor->id)
                                          ->where('type', 'issue')
                                          ->sum('quantity');
                $returned = BoxTransaction::where('vendor_id', $vendor->id)
                                          ->where('type', 'return')
                                          ->sum('quantity');
                $vendor->stats = [
                    'issued'   => $issued,
                    'returned' => $returned,
                    'pending'  => $issued - $returned,
                ];
                return $vendor;
            });

        return view('box.public', compact('vendors'));
    }

    /**
     * Detalle de Dashboard para un vendedor (público también)
     */
    public function vendorView(User $vendor)
    {
        $issued   = BoxTransaction::where('vendor_id', $vendor->id)
                                  ->where('type', 'issue')
                                  ->sum('quantity');
        $returned = BoxTransaction::where('vendor_id', $vendor->id)
                                  ->where('type', 'return')
                                  ->sum('quantity');
        $pending  = $issued - $returned;

        $history = BoxTransaction::where('vendor_id', $vendor->id)
                                 ->orderBy('created_at', 'desc')
                                 ->get();

        $allVendors = User::where('is_admin', false)->get();

        return view('box.vendor-dashboard', compact(
            'vendor', 'allVendors', 'issued', 'returned', 'pending', 'history'
        ));
    }

    /**
     * Dashboard global de administración
     */
    public function dashboard()
    {
        $vendors = User::where('is_admin', false)->get();

        return view('box.dashboard', compact('vendors'));
    }

    /**
     * Listar formulario y vendors para admin
     */
    public function vendorsIndex()
    {
        $vendors = User::where('is_admin', false)->get();
        return view('box.vendors.index', compact('vendors'));
    }

    /**
     * Almacena nuevo vendedor (admin)
     */
    public function vendorsStore(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'is_admin' => false,
        ]);

        return redirect()->route('box.vendors.index')
                         ->with('success', 'Vendedor creado correctamente.');
    }

    /**
     * Elimina un vendedor y todas sus transacciones
     */
    public function vendorsDestroy(User $vendor)
    {
        BoxTransaction::where('vendor_id', $vendor->id)->delete();
        $vendor->delete();

        return back()->with('success', 'Vendedor eliminado correctamente.');
    }

    /**
     * Registra salida de cajas (admin)
     */
    public function issue(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:users,id',
            'quantity'  => 'required|integer|min:1',
            'notes'     => 'nullable|string',
        ]);

        BoxTransaction::create([
            'vendor_id' => $request->vendor_id,
            'admin_id'  => auth()->id(),
            'type'      => 'issue',
            'quantity'  => $request->quantity,
            'notes'     => $request->notes,
        ]);

        return back()->with('success', 'Salida de cajas registrada.');
    }

    /**
     * Registra ingreso de cajas (admin)
     */
    public function return(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:users,id',
            'quantity'  => 'required|integer|min:1',
            'notes'     => 'nullable|string',
        ]);

        BoxTransaction::create([
            'vendor_id' => $request->vendor_id,
            'admin_id'  => auth()->id(),
            'type'      => 'return',
            'quantity'  => $request->quantity,
            'notes'     => $request->notes,
        ]);

        return back()->with('success', 'Ingreso de cajas registrado.');
    }

    /**
     * Muestra el formulario para editar una transacción.
     */
    public function editTransaction(BoxTransaction $transaction)
    {
        return view('box.transactions.edit', compact('transaction'));
    }

    /**
     * Procesa la actualización de la transacción.
     */
    public function updateTransaction(Request $request, BoxTransaction $transaction)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes'    => 'nullable|string',
        ]);

        $transaction->update($data);

        return redirect()->route('box.dashboard')
                         ->with('success', 'Transacción actualizada correctamente.');
    }

    /**
     * Elimina una transacción.
     */
    public function destroyTransaction(BoxTransaction $transaction)
    {
        $transaction->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Transacción eliminada']);
        }

        return redirect()->route('box.dashboard')
                         ->with('success', 'Transacción eliminada correctamente.');
    }
}
