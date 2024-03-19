<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    protected $fillable = [
        'user_id', 'name', 'image',
        'bidmargin','description'
    ];
    protected $casts = [
        'created_at' => 'datetime', // This will ensure that created_at is treated as a Carbon instance
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function currentBids()
    {
        return $this->hasMany(CurrentBid::class);
    }
}
