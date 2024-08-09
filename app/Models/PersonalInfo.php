<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    protected $table = 'personal_info'; // Ensure this matches the table name
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'contact_preference',
        'street_address',
        'apt',
        'city',
        'state',
        'zip_code',
        'selection',
    ];
}
