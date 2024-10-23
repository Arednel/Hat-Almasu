<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $table = 'supporttickets';

    protected $fillable = [
        'fullName',
        'course',
        'department',
        'mail',
        'phoneNumber',
        'reason',
        'student_login',
        'student_password',
        'subjects_to_add',
        'subjects_to_remove',
        'stuff_comment',
        'confirmationImages',
    ];
}
