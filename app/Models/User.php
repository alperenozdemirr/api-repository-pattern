<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
        'status',
        'type',
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->addresses()->delete();
            $user->baskets()->delete();
            $user->favorites()->delete();
            $user->comments()->delete();
            foreach ($user->orders as $order){
                $order->order_details()->delete();
            }
            $user->orders()->delete();
        });
    }

    public function image(): HasOne
    {
        return $this->hasOne(File::class,'user_id','id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class,'user_id','id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class,'user_id','id');
    }

    public function baskets(): HasMany
    {
        return $this->hasMany(ShoppingCart::class,'user_id','id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class,'user_id','id');
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class,'user_id','id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class,'user_id','id');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
