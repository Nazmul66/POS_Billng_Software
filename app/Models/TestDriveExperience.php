<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestDriveExperience extends Model
{
    protected $fillable = [
        'vehicle_report_id',
        'test_drive',
        'feedback_answer',
    ];
}
