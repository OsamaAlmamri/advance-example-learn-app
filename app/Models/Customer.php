<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id','user_id'];

    public function format()
    {
        return
            [
                "customer_id" => $this->id,
                "name" => $this->name,
                "email" => $this->user->email,
                "last_update" => $this->updated_at->diffForHumans()
            ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
