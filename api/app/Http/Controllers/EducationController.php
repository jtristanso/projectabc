<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Education;
use Carbon\Carbon;

class EducationController extends APIController
{
  function __construct(){
    $this->model = new Education();
    $this->notRequired = array(
      'year_started', 'year_ended', 'month_started', 'month_ended'
    );
  }
}
