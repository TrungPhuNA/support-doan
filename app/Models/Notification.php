<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $guarded = [''];

    const TYPE_REGISTER = 1;
    const TYPE_QUICK_PURCHASE = 2;
    const TYPE_DEPOSIT = 3;
    const TYPE_SUCCESS_BUY =  4;
}
