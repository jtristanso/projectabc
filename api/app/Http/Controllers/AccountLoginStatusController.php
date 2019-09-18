<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountLoginStatus;
use Carbon\Carbon;

class AccountLoginStatusController extends APIController
{
    function __construct(){
      $this->model = new AccountLoginStatus();
    }

    public function updateByParams($accountId, $status){
      $condition = array(
        'condition' => array(
          array(
            'column' => 'account_id',
            'value' => $accountId,
            'clause' => '='
          ) 
        ));

        $this->model = new AccountLoginStatus();
        $this->retrieveDB($condition);
        if(sizeof($this->response['data']) > 0){
          $this->model = new AccountLoginStatus();
          $this->updateDB(array(
            'id' => $this->response['data'][0]['id'],
            'status' => $status
          ));
        }else{
          $this->model = new AccountLoginStatus();
          $this->insertDB(array(
            'account_id' => $accountId,
            'status' => $status
          ));
        }
        return true;
    }

    public function update(Request $request){
      $data = $request->all();
      AccountLoginStatus::where('account_id', '=', $data['account_id'])->update(array(
        'status' => intval($data['status']),
        'updated_at' => Carbon::now()
      ));
      return response()->json(array(
        'data' => true,
        'timestamps' => Carbon::now()
      ));
    }
}
