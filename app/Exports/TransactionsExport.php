<?php

namespace App\Exports;

use App\Models\BoxTransaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return ['Fecha', 'Vendedor', 'Tipo', 'Cantidad', 'Notas'];
    }

    public function map($tx): array
    {
        // Mapear type a español
        $tipo = $tx->type === 'issue'
            ? 'Salida'
            : ($tx->type === 'return' ? 'Ingreso' : ucfirst($tx->type));

        return [
            $tx->created_at->toDateTimeString(),
            $tx->vendor->name,
            $tipo,
            $tx->quantity,
            $tx->notes,
        ];
    }
}
