<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class requestTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_name', 'account_id', 'status'
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
