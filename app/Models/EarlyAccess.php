<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EarlyAccess extends Model
{
    protected $table = 'early_access_list';
    protected $fillable = ['email'];
}
