<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = [''];
    const HOT = 1;

    const STATUS_ACTIVE = 1;
}
