<?php

namespace App\Http\Controllers;

use App\Models\likevideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpseclib3\Crypt\DES;

class likecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return likevideo::with('user')->where("video_id",$request['video_id'])->orderBy('id','DESC')->get();


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request ->validate([
            'userID'=> 'required',
            'videoID'=> 'required'

        ]) ){


            $user_id = $request['userID'];
            $video_id = $request['videoID'];
            $check_liked = DB::table("like_video")->where([['video_id',$video_id],['user_id',$user_id]])->get();

            if(count($check_liked)>0){
//                DB::table('like_video')->truncate(); // xóa toàn bộ dl bảng và rết lại id tự tăng
                DB::table("like_video")->where([['video_id',$video_id],['user_id',$user_id]])->delete();
            // nếu trong csdl người dùng này dẫ like thi sẽ xoas no ik
            }else{
// nếu chx tung like thì sẽ luu vai]o csdl
        $like = new likevideo();
        $like->video_id = $video_id;
        $like->user_id = $user_id;
        $like->save();

            }
            $like_count_of_a_video = DB::table("like_video")->where("video_id",$video_id)->count();

            DB::table('videos')->where("id",$video_id)->update(['like_count' => $like_count_of_a_video] );




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

    public  function get_list_video_user_liked(Request $request){
       $resuilt = DB::table('like_video')->select('video_id')->where('user_id',$request['user_id'])->orderBy('video_id','DESC')->get();
return  $resuilt;

    }
}
