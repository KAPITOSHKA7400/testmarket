<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = ['game_id', 'type_name'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
