<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserCommentsResource;
use App\Http\Resources\UserPostsResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   
    public function index()
    {   
      
        $users =User::paginate();
        return new UsersResource($users);
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required', 
           'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);

         $user = new User();
         $user->name = $request->get('name');
         $user->email = $request->get('email');
         $user->password = Hash::make($request->get('password'));
       
       
         // todo handle featured_image file upload 
         if($request->hasFile('avatar')) {
            $user_img_name = $request->file('avatar');
            $user_name = time().'.'.$user_img_name->getClientOriginalExtension();
            $destinationPath = public_path('/avatar');
            $user_img_name->move($destinationPath, $user_name);
    
            $user->avatar = $destinationPath.'/'.$user_name;
    
          }


         $user->save();

         $token = $user->createToken('token');
         $user->api_token = $token->plainTextToken;
         $user->save();
         return new UserResource($user);

    }

   
    public function show( $id)
    {
        $user = User::find($id); 
        
        return new \App\Http\Resources\UserResource($user);

    }

    
    public function update(Request $request, $id)
    {

        $user = User::find($id);
        if( $request->has('name')   ){
           $user->name = $request->get('name');

        }

          // todo handle featured_image file upload 
          if($request->hasFile('avatar')) {
            $user_img_name = $request->file('avatar');
            $user_name = time().'.'.$user_img_name->getClientOriginalExtension();
            $destinationPath = public_path('/avatar');
            $user_img_name->move($destinationPath, $user_name);
    
            $user->avatar = $destinationPath.'/'.$user_name;
    
          }

        $user->save();

        return new UserResource($user);
    }

 
    public function destroy($id)
    {
        //
    }


    public function posts($id){
         $user = User::find($id);
         $posts = $user->posts()->paginate();
         return new UserPostsResource($posts);
    }

    public function comments($id){
        $user = User::find($id);
        $comments = $user->comments()->paginate();
        return new UserCommentsResource($comments);
   }


   public function getToken(Request $request){


             $request->validate([
                'email' => 'required',
                'password' => 'required',                
             ]);
              // lazam email w password ykono machi farghin ki taktab fel app :
              //omba3d jib wach ktabt fel app email w password rir homa bla header bsk request yjib bzf swalh



             $credintials = $request->only('email' , 'password');
             // jabnahom dok nchofo ida kayan hada email w password fel data base nhada l if 

             if( Auth::attempt($credintials)){

                 // ida kaynin dkhlna hna w njbo kaml object ta3 hada email wel password bach ndokhlo 
                 $user =User::where('email' , $request->get('email'))->first();
                // $token = $user->createToken('token');
                // nraj3o rir token ta3o li ybayan ano rah login
                 return new TokenResource([ 'token' =>  $user->api_token]) ;
             }
             return 'not found';
}

}
