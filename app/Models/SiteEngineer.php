<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteEngineer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'emp_number',
    ];
}