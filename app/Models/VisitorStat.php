<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorStat extends Model
{
    protected $fillable = ['visit_date', 'visitors'];
    protected $casts = ['visit_date' => 'date'];
}
