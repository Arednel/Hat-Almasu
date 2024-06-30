<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $table = 'supporttickets';

    protected $fillable = [
        'fullName',
        'testType',
        'course',
        'department',
        'subject',
        'mail',
        'phoneNumber',
        'reason',
        'confirmationImages',
    ];
}
