<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    /**
     * リレーション定義
     */
    public function microposts() {
        return $this->hasMany(Micropost::class);
    }
    public function followings() {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    public function followers() {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    public function favorites() {
        return $this->belongsToMany(Micropost::class, 'favorites', 'user_id', 'micropost_id')->withTimestamps();
    }
    
    /**
     * 関係するモデルの要素数を一斉ロードする
     */
    public function loadRelationshipCounts() {
        $this->loadCount(['microposts', 'followings', 'followers', 'favorites']);
    }
    
    /**
     * 多対多リレーションの登録
     * @return boolean
     */
    public function follow($user_id) {
        $exist = $this->is_following($user_id);
        $its_me = $this->id == $user_id;
        
        if ($exist || $its_me) {
            return false;
        } else {
            $this->followings()->attach($user_id);
            return true;
        }
    }
    public function unfollow($user_id) {
        $exist = $this->is_following($user_id);
        $its_me = $this->id == $user_id;
        
        if ($exist && !$its_me) {
            $this->followings()->detach($user_id);
            return true;
        } else {
            $this->followings()->attach($user_id);
            return false;
        }
    }
    public function favorite($micropost_id) {
        if ($this->is_favorite($micropost_id)) {
            return false;
        } else {
            $this->favorites()->attach($micropost_id);
            return true;
        }
    }
    public function unfavorite($micropost_id) {
        if ($this->is_favorite($micropost_id)) {
            $this->favorites()->detach($micropost_id);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * リレーションの既存判定
     * @return boolean
     */ 
    public function is_following($user_id) {
        return $this->followings()->where('follow_id', $user_id)->exists();
    }
    public function is_favorite($micropost_id) {
        return $this->favorites()->where('micropost_id', $micropost_id)->exists();
    }
    
    /**
     * ウェルカムページ用
     * フォローしているユーザと自分自身の投稿を取得
     */
    public function feed_microposts() {
        $user_ids = $this->followings()->pluck('users.id')->toArray();
        $user_ids[] = $this->id;
        
        return Micropost::whereIn('user_id', $user_ids);
    }
}
