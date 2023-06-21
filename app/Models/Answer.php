<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id', 
        'lot_id',
        'answer',
        'valid',
        'validation_text',
        'inspected'
    ];

    public function files() {
        return $this->hasMany(File::class);
    }

    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }

    public function lot()
    {
        return $this->hasOne(Lot::class, 'id', 'lot_id');
    }
}