<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function userprofile()
    {
        return view('user.profile');
    }

    public function changepasswordpage()
    {
        return view('user.changepassword');
    }

    public function addstaffpage()
    {
        return view('user.addstaff');
    }

    public function stafflist()
    {
        $data = User::all();
        return view('user.stafflist',compact('data'));
    }

    public function staffedit(User $user,$id)
    {
        $item = User::findOrFail($id);
        return view('user.addstaff',compact('item'));
    }

    public function addstaffsubmit(Request $request)
    {
        request()->validate([
            'usertype'            => ['required'],
            'name'      => ['required'],
            'email'      => ['required'],
            'userimage'      => ['required'],
            //for engilsh
            'usermobile'            => ['required'],
            'password'      => ['required'],
            
            
        ]);
        // dd($request->all());

        if ($request->hasFile('userimage')) {
            $request->validate([
                'userimage' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);
            $ext = $request->file('userimage')->extension();
            $userimage = 'profile_' . time() . '.' . $ext;
            $request->file('userimage')->move(storage_path('app/public/profile/'), $userimage);
        } else {
            $userimage = '';
        }

        User::create([
            'usertype'             => $request->usertype,
            'name' => $request->name,
            'email' => $request->email,
            'userimage'       => $userimage,
            'usermobile'             => $request->usermobile,
           'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
            'created_at'        => date('Y-m-d H:i:s')
        ]);
       

        return redirect()->route('stafflist');
    }

    public function updatestaff(Request $request)
{
    // Validate the form data
    $validatedData = $request->validate([
        'usertype' => 'required',
        'name' => 'required',
        'email' => 'required|email',
        'usermobile' => 'required|numeric',
        // 'userimage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        // 'password' => 'required',
    ]);

    // Find the user by ID
    $id= $request->user_id;
    $user = User::findOrFail($id);
    $userimage = $user->userimage;

    // Upload and update user image if provided
     if ($request->hasFile('userimage')) {
            $request->validate([
                'userimage' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
            ]);
            $ext = $request->file('userimage')->extension();
            $images = 'profile_' . time() . '.' . $ext;
            $request->file('userimage')->move(storage_path('app/public/profile/'), $images);

            $file = storage_path('/app/public/profile/' . $userimage);
            if (file_exists($file)) {
                @unlink($file);
            }
        } else {
            $images = $userimage;
        }

        //  User::whereId($id)->update([
        //     'usertype'             => $request->usertype,
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'userimage'       => $images,
        //     'usermobile'             => $request->usermobile,           
        //     'password'             => Hash::make($request->password),           
        //     'updated_at'        => date('Y-m-d H:i:s')
        // ]);

        $userData = [
    'usertype' => $request->usertype,
    'name' => $request->name,
    'email' => $request->email,
    'userimage' => $images,
    'usermobile' => $request->usermobile,
    'updated_at' => now(),
];

// Check if a new password is provided
if (!empty($request->password)) {
    // Hash the new password
    $userData['password'] = Hash::make($request->password);
}

User::whereId($id)->update($userData);
    // Redirect back or to a specific route
    return redirect()->route('stafflist');
}

public function staffdelete(User $user,$id)
{
    $data = $user::find($id);
    $userimage=$data->userimage;
    if($user->whereId($id)->delete()){
         $file = storage_path('/app/public/profile/' . $userimage);
            if (file_exists($file)) {
                @unlink($file);
            }
        }
        return redirect()->route('stafflist');
}


}
