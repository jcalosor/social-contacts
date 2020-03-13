<?php

namespace App\Database\Models;

use App\Database\AbstractModel;

class User extends AbstractModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'first_name',
        'last_name',
        'address',
        'city',
        'zip',
        'country',
        'email',
        'phone'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
