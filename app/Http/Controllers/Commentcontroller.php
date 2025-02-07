<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Commentcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $idvideo = $request->video_id;
        return Comment::with('user')->where('video_id',$idvideo)->get();

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
        if(  $request->validate([
            'content'=>"required"
        ])){
            $comment= new Comment();
            $comment->content =$request->content;
            $comment->video_id =$request->videoid;
            $comment->user_id =$request->userid;
            $comment->save();

            $comment_count_of_a_video = DB::table("comment")->where("video_id",$request->videoid)->count();

            DB::table('videos')->where("id",$request->videoid)->update(['comment_count' => $comment_count_of_a_video] );

 
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
    public function destroy(Request $request)
    {
         DB::table('comment')->where([
            ['id',$request->id_Comment],
            ['user_id',$request->id_user]
        ])->delete();
        return "Delete success";
    }
}
