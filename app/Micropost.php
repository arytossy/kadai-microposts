<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content'];
    
    /**
     * リレーション定義
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function favorers() {
        return $this->belongsToMany(User::class, 'favorites', "micropost_id", 'user_id');
    }
}
