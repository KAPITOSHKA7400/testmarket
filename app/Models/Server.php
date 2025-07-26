<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    //
    protected $fillable = ['game_id', 'type_id', 'server_name'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class, 'type_id');
    }
}
