<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerExperience extends Model
{
    protected $fillable = [
        'vehicle_report_id',
        'customer_feedback',
        'customer_answer',
    ];
}
