<?php

namespace App\Http\Controllers;
use App\Work;
use Illuminate\Http\Request;

class WorkController extends APIController
{
  function __construct(){
    $this->model = new Work();
    $this->notRequired = array(
      'year_started', 'year_ended', 'month_started', 'month_ended'
    );
  }  
}
