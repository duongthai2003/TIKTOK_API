<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Pawlox\VideoThumbnail\VideoThumbnail;

class videocontroller extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->page;
      $data = Video::with(['user','comment'])->orderBy('id','DESC')->take($page*10)->get();
     //with(['user','comment']  lien ket 2 bang thi viet nhu nay


        return response([
            'data'=>$data

        ]);
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

        $request->validate([
            'file_url'=>"required|mimes:mp4",
//            'thumnailvideo'=>"required|mimes:jpg,png,jpeg"
        ]);

           $post = new Video();
         $request['description']? $post->description = $request->description :$post->description ="";
         $request['music']? $post->music = $request->music: $post->music ="";
         $post->user_id = $request->user_id;

         $video = $request['file_url'];

            $format = $video->getClientOriginalExtension();
            $name = time().'_'.$video->getClientOriginalName();
         $video->move('Video',"$name");
            $post->file_url='TIKTOK_API/public/Video/'.$name;
            $post->file_format=$format;

//             $request['thumnailvideosecond']; : giay chup anh

//         $img = $request['thumnailvideo'];
////        $img_format = $img->getClientOriginalExtension();
////         $nameimg = "thumnail_". substr($name,0,-4).'.jpg';//.$img_format;//substr : cat chuoi
//        $nameimg = "thumnail_thai.jpg" ;
//
//                $img->move("Thumnailvideo", "$nameimg");
// //        $post->img_url='TIKTOK_API/public/Thumnailvideo/'.$nameimg;





         $post->save();

//         return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $video = Video::with(['user','comment'])->where('id',$id)->get();
        $video = Video::with('user')->where('id',$id)->get();
        $iduser = $video[0]['user']['id']; // lay ra user_id
        $lisvideoss= DB::table('videos')->where('user_id',$iduser)->get(); //lay ra list video ma user da dang
        $data = response()->json([
            $video,$lisvideoss
        ]);
        return $data;
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

    public function searchvideo(Request $request){
        $value =$request->q;
        $page =$request->page;
        //$videos = Video::with('user')->where('description','like','%'.$value.'%')->paginate($page*5);
        $videos = Video::with('user')->where('description','like','%'.$value.'%')->orderBy('id','DESC')->take($page*8)->get();

        return $videos;
    }

    public  function deleteanvideo(Request $request){
//        $id_user = $request->iduser;
//        $id_video =$request->idvideo;
//        $fileurl = Video::find($id_video)->file_url;
//        $filepath = 'C:/xampp/htdocs/'.$fileurl ;
//        File::delete($filepath);//xoa video trong file
//        DB::table('videos')->where([['id',$id_video],['user_id',$id_user]])->delete();//xóa vdieo ở csdl
//        DB::table('like_video')->where("video_id",$id_video)->delete(); // xoa like
//        DB::table('comment')->where("video_id",$id_video)->delete(); // xóa comment của video


        $file_path = public_path("Video/"."thaiduong.mp4");
        unlink($file_path);

        return $file_path;

    }


}
