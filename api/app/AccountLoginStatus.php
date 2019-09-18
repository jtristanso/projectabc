<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountLoginStatus extends APIModel
{
    protected $table = 'account_login_status';
    protected $fillable = ['account_id', 'status'];
}

