<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends APIModel
{
    protected $table = 'templates';
    protected $fillable = ['code', 'account_id', 'title', 'contents', 'status', 'categories'];
}
