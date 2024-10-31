<?php

namespace App\Http\Controllers;

use App\Http\Resources\userresource;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class usercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  User::paginate();
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
//        $validator= $request->validate([
//           'name'=>"required",
//           'nickname'=>"required",
//           'email'=>"required|unique:users",
//           'password'=>"required"
//       ]);
        $validator = Validator::make($request->all(),[
            'name'=>"required",
           'nickname'=>"required",
           'email'=>"required|unique:users|email",
           'password'=>"required"
        ]);
        if ($validator->fails()) {
            $error = $validator->errors();;
            return $error;
    }else {
            $post = new  User();
            $post->name = $request->name;
            $post->nickname = $request->nickname;
            $post->email = $request->email;
            $post->password = bcrypt($request['password']);

            if ($request['avatar']) {
                $request->validate([
                    'avatar' => "mimes:jpeg,png,bmp,tiff,jpg"
                ]);

                $image = $request['avatar'];
                $imageformat = $image->getClientOriginalExtension(); // lay ra duoi cua file da chon
                $nameImage = time() . '_' . $image->getClientOriginalName(); // dat ten cho file
//            Storage::disk('public')->put($nameImage,File::get($image)); // de lưu file nhưng nó se luu vào tep storage muốn đổi thif phai vao file config/filesystem de cau hinh
                $image->move('Avatar', $nameImage); //noi luu file
                $post->avatar = 'TIKTOK_API/public/Avatar/' . $nameImage;
            } else {
                $post->avatar = "";
            }
            $request['bio'] ? $post->bio = $request->bio : $post->bio = "";
         $post->save();


//            return redirect()->back();
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        return response()->json([
            'data'=>User::find($id)
        ]);
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
    public function update(Request $request,User $user)
    {

//        $request->validate([
//            'name'=>"required",
//            'nickname'=>"required",
//            'email'=>"required"
//
//        ]);

        $user->name = $request->name ;
        $user->nickname = $request->nickname;
//        $user->email = $request->email ;
        $user->bio = $request->bio ;

        if($request->avatar){
            $img = $request->avatar;
            $imgname = time()."_".$img->getClientOriginalName();
            $img_pach ='C:/xampp/htdocs/'. $user->avatar;  // duong dẫn đến ảnh cũ
            File::delete($img_pach); // xóa ảnh cũ
            $img->move('Avatar',$imgname); // thêm ảnh mới
            $user->avatar = 'TIKTOK_API/public/Avatar/'.$imgname;
        }

        $user->update() ;
return $user  ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {


        $img_pach ='C:/xampp/htdocs/'. $user->avatar;  // duong dẫn đến ảnh cũ
        File::delete($img_pach); // xóa ảnh cũ
        $user->delete();
    }

    public function login()
    {
        if (Auth::attempt(
            [
                'email' => request('email'),
                'password' => request('password')
            ]
        )) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;

            return response()->json(
                [
                    'data' => $success
                ]

            );
        }
        else {
            return response()->json(
                [
                    'error' => 'Unauthorised'
                ], 401);
        }
    }

    public function details()
    {
        $user = Auth::user();

//        return User::all();
        return response()->json(
            [
                'data' => $user
            ]
        );
    }

    public function getanuser($nickname){
        if(Auth::user()){
            return "duong thai";
        }
      $user = User::with('videos')->where('nickname',$nickname)->get();
        return response([
            'data'=>$user
        ]);
    }

//    public function searchuser (){
//        $as =  User::paginate();
//        return $as;
//    }
    public function search(Request $request)
    {
        $value =$request->q;
        $type = $request->type;
        $page = $request['page'];
         $user = DB::table('users')->where('nickname','like','%'.$value.'%')->take($type=='more'?$page*10:5)->get();

        return $user;
    }
    public function suggess(Request $request){
        $a=$request->page;
        $user = DB::table('users')->take($a*5)->get();
        return $user;
    }
}
