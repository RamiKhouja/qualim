<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'num', 
        'owner',
        'phase',
        'in_progress',
        'admin_valid',
        'parent_lot_id'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner');
        //return $this->belongsTo(User::class, 'id', 'owner');
    }

    public function answers() 
    {
        return $this->hasMany(Answer::class);
    }

    public function destinations()
    {
        return $this->belongsToMany(User::class, 'lot_users')->select('users.*', 'lot_users.*');
        //return $this->HasMany(User::class, 'lot_users.user_id', 'users.id');

    }

    public function parentLot()
    {
        return $this->belongsTo(Lot::class, 'parent_lot_id');
    }

    public function childLots()
    {
        return $this->hasMany(Lot::class, 'parent_lot_id');
    }
}
