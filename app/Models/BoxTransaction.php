<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoxTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'admin_id',
        'type',
        'quantity',
        'notes',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'quantity'    => 'integer',
        'deleted_at'  => 'datetime',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    /**
     * Relación con el vendedor (usuario)
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * Relación con el admin que registró la transacción
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
