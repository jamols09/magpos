<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;
use App\Http\Resources\UserProfileResource;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $obj_countries = new Countries();   
    
        $countries = $obj_countries->all()->pluck('name.common');
        $user_id = request()->user()->id;
        $resource =  new UserProfileResource(User::find($user_id));

        if($user_id) {
            return $resource->additional([
                'country' => $countries,
                'message' => 'Success'
            ]);
        } else {
            return response(['error' => 'User info not found']);
        }

    }

    public function update(Request $request)
    {

        $user_id = $request->user()->id;
        $user = User::find($user_id);
        $user->fill($request->post());
        $user->save();

        return response(['message' => 'User details updated']);
    }

    public function uploadAvatar(Request $request)
    {
    
        if($request->has('image')) {

            $user_id = $request->user()->id;
            $user = User::find($user_id);

            switch ($request->file('image')->getMimeType()) {
                case 'image/png':
                    break;
                case 'image/gif':
                    break;
                case 'image/jpeg':
                    break;
                default:
                    return response(['error' => 'File type not allowed']);
            }

            $path = storage_path('app\public\avatar');
            
            $file = $request->file('image');
            $file_name = $file->getClientOriginalName();
            
            //If user already has a photo delete previous
            if($user->avatar) {
                if(is_file($path.'\\'.decrypt($user->avatar))) {
                    unlink($path.'\\'.decrypt($user->avatar));
                }
            }

            //If image has same name generate random string
            if(is_file($path.'\\'.$file->getClientOriginalName())) {
                $random = Str::random(15);
                $file_name = $random.'_'.$file_name;
            }

            $file->storeAs('avatar', $file_name, 'public');

            $user->avatar = encrypt($file_name);
            $user->save();

            return response(['message' => 'Profile Uploaded']);
        }

        return response(['error' => 'File does not exists']);
    }

    public function getAvatar(Request $request)
    {

        $user_id = $request->user()->id;
        $user = User::find($user_id);
        $file_name = decrypt($user->avatar);
        $path = storage_path('app\public\avatar');

        if(!is_file($path.'\\'.$file_name)) { //if file is not found set default image
            return asset(Storage::url('avatar/186dmcuqm6436.jpeg'));
        }

        return asset(Storage::url('avatar/'.$file_name));
    }
    
}
