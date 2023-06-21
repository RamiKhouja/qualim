<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_id',
        'user_id',
        'valid',
        'in_progress'
    ];
}
