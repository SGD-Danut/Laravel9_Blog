<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest; //Includem requestul personalizat pentru editFormUserProfile
use Illuminate\Support\Facades\File;  //Includem fațada File
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfilePasswordRequest;

class UserProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function showUserProfileForm() {
        $user = User::findOrFail(auth()->id());
        return view('admin.edit-user-profile-form')->with('user', $user);
    }

    public function updateUserProfile(UpdateUserRequest $request) {
        $this->validate(
            $request, 
            [
                'email' => 'unique:users,email,' . auth()->id()
            ],
            [
                'email.unique' => 'Această adresă de email este deja înregistrată!'
            ],
        );
        
        $user = User::findOrFail(auth()->id());

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        
        if($request->hasFile('photo')) {
            if ($user->photo != 'defaultUserPhoto.png') {
                File::delete('images/users/' . $user->photo);
            }
            $photoExtension = $request->file('photo')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->name) . '_' . time() . '.' . $photoExtension;
            $request->file('photo')->move('images/users', $photoName);

            $user->photo = $photoName;
        }

        $user->save();
        
        return redirect()->back()->with('success', 'Profilul a fost actualizat cu succes!');
    }

    public function updatePassword(UpdateProfilePasswordRequest $request) {
        $credentials = [
            'email' => auth()->user()->email,
            'password' => $request->old_password
        ];

        if (Auth::attempt($credentials)) {
            $newPassword = bcrypt($request->new_password);
            // $user = auth()->user();
            $user = User::findOrFail(auth()->id());
            $user->password = $newPassword;

            $user->save();
            
            return redirect()->back()->with('success', 'Parola a fost modificată cu succes. <br> Noua parolă pentru acest cont este <strong>' . $request->new_password . '</strong>. <br> Notați noua parolă într-un loc sigur.');
        }

        return redirect()->back()->with('error', 'Parola nu a fost modificată cu succes, parola actuală nu este corectă!');
    }
}
