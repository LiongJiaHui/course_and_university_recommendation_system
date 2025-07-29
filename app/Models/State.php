<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = "states";

    protected $fillable = [
        "state_name"
    ];

    // relationship
    public function university () {
        return $this->hasMany(University::class, 'uni_id');
    }

    public function area() {
        return $this->hasMany(State::class, 'area_id');
    }
}
