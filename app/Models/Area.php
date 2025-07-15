<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';

    protected $fillable = [
        'area_name',
        'state_id'
    ];

    // Relationships
    public function state(){
        return $this->hasOne(State::class, 'state_id');
    }
}
