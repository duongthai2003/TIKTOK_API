<?php

namespace App\Http\Controllers;

use App\Models\Following;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class followingcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $user_id = $request->userId;
          $users = DB::table('users') ->join('following', 'users.id', '=', 'following.following_user_id') ->select('users.*')->where("user_id",$user_id)->orderBy("following.id","DESC")->get();

        return  $users;



    }

    public function getfollowerlist(Request $request)
    {
        $user_id = $request->userId;
        $users = DB::table('users') ->join('following', 'users.id', '=', 'following.user_id') ->select('users.*')->where("following_user_id",$user_id)->orderBy("following.id","DESC")->get();

         return  $users;
    }

    public function friendlist(Request $request)

    {
        $userid = $request->userId;
        $users = DB::select("SELECT users.*
                                    FROM users JOIN following ON users.id = following.user_id
                                     WHERE following_user_id = $userid AND  user_id IN(
                                           SELECT following_user_id
                                       FROM following
                                       WHERE user_id =$userid)
                                       ORDER BY following.id DESC ");

return $users;
    }

    public  function followingvideolis(Request $request){
        $userid = $request->userId;
        $page = $request->page;

//        $video =  DB::select("
//SELECT users.*,videos.*
//FROM (users JOIN videos ON users.id=videos.user_id)
//WHERE videos.user_id IN (
//SELECT following.following_user_id
//  FROM following
//  WHERE user_id= $userid
//)
//        ");

        $data = Video::with(['user','comment'])->orderBy('id','DESC')->take($page*10)->whereIn("user_id",
          DB::table("following")->select("following_user_id")->where("user_id",$userid)
         )->get();  // truy vấn lồng dùng whereIn



        return $data;
    }

    public function getvideofriend(Request $request)
    {
        if ($request ->validate([
            'userId'=> 'required',
            'page'=> 'required'

        ]) ) {
            $userid = $request->userId;
            $page = $request->page;

            $video = Video::with(['user'])->orderBy('videos.id', 'DESC')->take($page * 10)
                ->whereIn("videos.user_id",
                    DB::table("users")->select("users.id")->join("following", "users.id", "=", "following.user_id")
                        ->where("following_user_id", $userid)
                        ->whereIn("user_id", DB::table("following")->select("following_user_id")
                            ->where("user_id", $userid)))->get();
            return $video;

//        SELECT videos.*
//FROM videos
//WHERE videos.user_id IN(
//        SELECT users.id
//  FROM users JOIN following ON users.id = following.user_id
//  WHERE following_user_id = 5 AND  user_id IN(
//        SELECT following_user_id
//  FROM following
//  WHERE user_id =5))
//  ORDER BY id DESC


        }else{
            return ;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    function handleSetFriendCount($user_id,$followingUserId,$CongTru){

        $check_follower = DB::table("following")->where([['user_id',$followingUserId],["following_user_id",$user_id]])->get();

        if(count($check_follower)>0){
            DB::update("
                UPDATE users
                            SET friend_counts = friend_counts $CongTru 1
                         WHERE id =$user_id 
                ");
            DB::update("
                UPDATE users
                            SET friend_counts = friend_counts $CongTru 1
                         WHERE id =$followingUserId 
                ");
        }
    }

    function handle_Following_count ($user_id,$followingUserId,$Cong_tru){
        DB::update("
                            UPDATE users
                            SET following_counts = following_counts $Cong_tru 1
                            WHERE id =$user_id
                         ");
        DB::update("
                            UPDATE users
                            SET follower_counts = follower_counts $Cong_tru 1
                            WHERE id =$followingUserId
                          ");
    }

    public function store(Request $request)
    {
        if ($request ->validate([
            'userID'=> 'required',
            'followingUserId'=> 'required'

        ]) ){

            $user_id = $request['userID'];
            $followingUserId = $request['followingUserId'];
            $check_following = DB::table("following")->where([['user_id',$user_id],["following_user_id",$followingUserId]])->get();
            if(count($check_following)>0){
                // nếu trong csdl người dùng này dẫ follo thi sẽ xoas no ik

                DB::table("following")->where([['user_id',$user_id],["following_user_id",$followingUserId]])->delete();

                $this->handle_Following_count($user_id,$followingUserId,"-");
                $this->handleSetFriendCount($user_id,$followingUserId,"-");



            }else{
                // nếu chx tung follo thì sẽ luu vai]o csdl
                $folowing = new Following();

                $folowing->user_id = $user_id;
                $folowing->following_user_id = $followingUserId;
                $folowing->save();

                $this->handle_Following_count($user_id,$followingUserId,"+");
               $this->handleSetFriendCount($user_id,$followingUserId,"+");


            }


        }else{
            return ;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
