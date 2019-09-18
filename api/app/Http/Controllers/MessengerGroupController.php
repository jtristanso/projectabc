<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Increment\Messenger\Models\MessengerGroup;
use Increment\Messenger\Models\MessengerMember;
use Increment\Messenger\Models\MessengerMessage;
use Carbon\Carbon;
use Increment\Account\Models\Account;
use Illuminate\Support\Facades\DB;
use App\Events\Message;
class MessengerGroupController extends APIController
{
    function __construct(){
      $this->model = new MessengerGroup();
    }

    public function create(Request $request){
      $data = $request->all();

      $creator = intval($data['creator']);
      $memberData = intval($data['member']);
      $message = $data['message'];
      $this->model = new MessengerGroup();
      $insertData = array(
        'account_id'  => $creator,
        'title'       => 'NONE',
        'payload'     => $data['payload'] 
      );
      $this->insertDB($insertData);
      $id = intval($this->response['data']);
      if($id > 0){
        $member = new MessengerMember();
        $member->messenger_group_id = $id;
        $member->account_id = $creator;
        $member->status = 'admin';
        $member->created_at = Carbon::now();
        $member->save();

        $messageModel = new MessengerMessage();
        $messageModel->messenger_group_id = $id;
        $messageModel->account_id = $creator;
        $messageModel->message = $message;
        $messageModel->created_at = Carbon::now();
        $messageModel->save();

        $member = new MessengerMember();
        $member->messenger_group_id = $id;
        $member->account_id = $memberData;
        $member->status = 'member';
        $member->created_at = Carbon::now();
        $member->save();

        $messageArray = array(
          'messenger_group_id'  => $id,
          'account_id'          => $creator,
          'message'             => $message,
          'status'              => 'messenger',
          'account'             => $this->retrieveAccountDetails($creator),
          'created_at_human'    =>  Carbon::now()->copy()->tz('Asia/Manila')->format('F j, Y')
        );

        broadcast(new Message($messageArray))->toOthers();

        $responseData = array(
          'id'  => $id,
          'account_id'  => $memberData,
          'title' => $this->retrieveAccountDetails($memberData)
        );

        return response()->json(array(
          'data'  => $responseData,
          'error' => null,
          'timestamps'  => Carbon::now()
        ));
      }else{
        return response()->json(array(
          'data'  => null,
          'error' => null,
          'timestamps'  => Carbon::now()
        ));
      }
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $accountType = $data['account_type'];
      $accountId = $data['account_id'];
      $username = $data['username'];
      $existed = array();
      $flag = false;
      $active = 0;

      $result = null;

      if($accountType == 'partner' || $accountType == 'PARTNER'){
        $result = DB::table('messenger_members as T1')
          ->join('messenger_groups as T2', 'T2.id', '=', 'T1.messenger_group_id')
          ->where('T1.account_id', '=', $accountId)
          ->where('T2.payload', '!=', 'support')
          ->orderBy('T2.updated_at', 'DESC')
          ->select('T2.*')
          ->get();
        $result = json_decode($result, true);
        if(sizeof($result) > 0){
          $i = 0;
          foreach ($result as $key) {
            $result[$i]['account_details'] = $this->retrieveAccountDetails($result[$i]['account_id']);
            $result[$i]['members'] = $this->getMembers($result[$i]['id'], null);
            $result[$i]['title'] = $this->retrieveAccountDetails($result[$i]['account_id']);
            $existed[] = $result[$i]['account_id'];
            $result[$i]['new'] = false;
            if($i == 0){
              $result[$i]['flag'] = true;
              $flag = true;
            }else{
              $result[$i]['flag'] = false;
            }
            $i++;
          }
        }

      }else if($accountType == 'user' || $accountType == 'USER'){
        $result = MessengerGroup::where('account_id', '=', $accountId)->where('payload', '!=',  'support')->orderBy('updated_at', 'DESC')->get();

        if(sizeof($result) > 0){
          $i = 0;
          foreach ($result as $key) {
            $details = $this->retrieveAccountDetails($result[$i]['account_id']);
            $result[$i]['account_details'] = $this->retrieveAccountDetails($result[$i]['account_id']);
            $members = $this->getMembers($result[$i]['id'], $username);
            $result[$i]['members'] = ($members) ? $members['result'] : null;
            $result[$i]['title'] = $this->getTitle($result[$i]['id']);
            $result[$i]['new'] = false;
            if($members == true && $members['exist_username'] == true){
              $result[$i]['flag'] = true;
              $active = $i;
              $flag = true;
            }else{
              $result[$i]['flag'] = false;
            }
            $i++;
          }
        }
      }

      $accounts = null;
      if(($accountType == 'user' || $accountType == 'USER') && $flag == false){
        if(sizeof($result) > 0){
          $result[0]['flag'] = true;
        }
        $accounts = $this->getPartner($username);
      }

      return response()->json(array(
        'data'  => (sizeof($result) > 0) ? $result : null,
        'accounts'  => $accounts,
        'active'  => $active,
        'error' => null,
        'timestamps'  => Carbon::now()
      ));
    }

    public function getMembers($messengerGroupId, $username){
      $result = MessengerMember::where('messenger_group_id', '=', $messengerGroupId)->get();
      $flag = false;
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $account = $this->retrieveAccountDetails($result[$i]['account_id']);
          $result[$i]['account_details'] = $account;
          if($account['username'] == $username){
            $flag = true;
          }
          $i++;
        }
      }
      return (sizeof($result) > 0) ? array(
        'result' => $result,
        'exist_username' => $flag
      ) : null;
    }

    public function getMemberExisted($messengerGroupId){
      $result = MessengerMember::where('messenger_group_id', '=', $messengerGroupId)->where('status', '=', 'member')->get();
      return (sizeof($result) > 0) ? $result[0]['account_id'] : null;
    }

    public function getTitle($messengerGroupId){
      $result = MessengerMember::where('messenger_group_id', '=', $messengerGroupId)->where('status', '=', 'member')->get();
      $title = null;
      if(sizeof($result) > 0){
          $title = $this->retrieveAccountDetails($result[0]['account_id']);
      }
      return ($title) ? $title : null;
    }

    public function getPartner($username){
      $accounts = null;
      $accounts = Account::where('username', '=', $username)->where('account_type', '=', 'PARTNER')->get();
      if(sizeof($accounts) > 0){
        $i = 0;
        foreach ($accounts as $key) {
          $accounts[$i]['title'] = $this->retrieveAccountDetails($accounts[$i]['id']);
          $accounts[$i]['flag'] = true;
          $accounts[$i]['new'] = true;
          $i++;
        }
      }
      return (sizeof($accounts) > 0) ? $accounts : null;
    }

}
