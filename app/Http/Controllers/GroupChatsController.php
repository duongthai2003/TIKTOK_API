<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupChats;
use Illuminate\Support\Facades\Auth;


class GroupChatsController extends Controller
{
    public function createGroupChat(Request $request) {
        $usersChat = [Auth::id(),  $request->receiver_id]; 
        sort($usersChat); 
        $getGroup = GroupChats::where("name_group", implode('_', $usersChat))->first();
      
      if(!$getGroup){ 
             $groupChat = GroupChats::create([
              'member_1' => Auth::id(),
              'member_2' => $request->receiver_id,
              'name_group' => implode('_', $usersChat),
          ]); 
          return response()->json([
            'data' => $groupChat, 
        ], 201);
      } else{
        return response()->json([
            'message' => 'Group already exists',
        ], 201);
      }
    }
}
