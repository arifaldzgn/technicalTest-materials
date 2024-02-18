<?php

namespace App\Models;

use App\Models\requestTicket;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Ticket;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;
    protected $fillable = [
        'material_name', 
        'request_ticket_id', 
        'quantity', 
        'usage'
    ];

    public function requestTicket()
    {
        return $this->belongsTo(requestTicket::class, 'request_ticket_id');
    }
}
