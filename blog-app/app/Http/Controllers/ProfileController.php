<?php

namespace App\Http\Controllers;

use App\Rules\MatchOldPassword;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //edit
    public function edit(){
        return view("profile.edit");
    }


//  2 type of store and upload in file
//       1.request->move("loaction","file_name")[to public]
//       2.Storage:put("location","file_name")[to storage]

    public function update(Request $request){
        $request->validate([
            "photo"=>"required|mimes:jpg,jpeg,png",
        ]);
        $file = $request->file("photo");
        $newFileName = uniqid()."_profile.".$file->getClientOriginalExtension();
        $dir = "public/profile/";
//        $file->move("store/",$fileNameRand);

        $file->StoreAs($dir,$newFileName);
//        Storage::putFileAs($dir,$file,$newFileName);

        $user = \App\Models\User::find(Auth::id());

        $user->photo = $newFileName;
        $user->update();

//        $arr = scandir(public_path("/storage/"));

        return redirect()->route("profile.edit");
    }

    public function changePassword(Request $request){
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

//        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        $user = new \App\Models\User();
        $currentUser = $user->find(Auth::id());
        $currentUser->password = Hash::make($request->new_password);
        $currentUser->update();

        Auth::logout();
        return redirect()->route('login');
    }

}
