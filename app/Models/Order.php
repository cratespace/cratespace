<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Billing\Order as OrderContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model implements OrderContract
{
    use HasFactory;
}
