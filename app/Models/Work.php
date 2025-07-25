<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = ['user_id', 'file', 'type', 'title', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

	public function likes()
	{
		return $this->hasMany(Like::class);
	}

    public function isLikedBy($user)
    {
        if (!$user) {
            return false;
        }
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function views()
    {
        return $this->hasMany(WorkView::class);
    }

    public function getViewsCountAttribute()
    {
        return $this->views()->count();
    }
}
