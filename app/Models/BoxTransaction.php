<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class BoxTransaction extends Model
{
    protected $fillable = [
        'vendor_id',
        'admin_id',
        'type',
        'quantity',
        'notes',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
