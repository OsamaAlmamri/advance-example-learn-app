<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const PENDING = "pending";
    public const CONFIRMED = "confirmed";
    public const CANCELED = "canceled";
}
