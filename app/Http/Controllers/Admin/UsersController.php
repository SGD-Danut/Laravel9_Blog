<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; //Includem modelul User
use App\Http\Requests\AddUserRequest; //Includem requestul personalizat pentru addFormUser
use Illuminate\Support\Facades\File;  //Includem fațada File
use App\Http\Requests\UpdateUserRequest; //Includem requestul personalizat pentru editFormUser

class UsersController extends Controller
{
    public function __construct() {
        $this->middleware('onlyAdmin');
    }

    //Creăm funcția de afișare a utilizatorilor
    public function showUsers() {
        $users = User::all()->sortBy('name');
        return view('admin.users')->with('users', $users);
    }

    public function newUserForm() {
        return view('admin.new-user-form');
    }

    public function createNewUser(AddUserRequest $request) {
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        
        if($request->hasFile('photo')) {
            $photoExtension = $request->file('photo')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->name) . '_' . time() . '.' . $photoExtension;
            $request->file('photo')->move('images/users', $photoName);

            $user->photo = $photoName;
        }

        $confirmationUpdateMessage = "Utilizatorul " . $request->name . " a fost adăugat cu succes!";
        
        if ($request->validateEmail == 1) {
            $user->email_verified_at = now();
            $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " Email-ul utilizatorului este validat.";
        } else {
            $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " Email-ul utilizatorului nu este validat.";
        }
        
        $user->save();
        
        return redirect(route('users'))->with('success', $finalConfirmationUpdateMessage);
    }

    public function editUserForm($userId) {
        $user = User::findOrFail($userId);
        return view('admin.edit-user-form')->with('user', $user);
    }

    public function updateUser(UpdateUserRequest $request, $userId) {
        $this->validate(
            $request, 
            [
                'email' => 'unique:users,email,' . $userId
            ],
            [
                'email.unique' => 'Această adresă de email este deja înregistrată!'
            ],
        );
        
        $user = User::findOrFail($userId);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->role = $request->role;
        
        if($request->hasFile('photo')) {
            if ($user->photo != 'defaultUserPhoto.png') {
                File::delete('images/users/' . $user->photo);
            }
            $photoExtension = $request->file('photo')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->name) . '_' . time() . '.' . $photoExtension;
            $request->file('photo')->move('images/users', $photoName);

            $user->photo = $photoName;
        }
        $confirmationUpdateMessage = 'Datele utilizatorului au fost actualizate cu succes';
        //Daca utilizatorul alege optiunea 'Nici-o acțiune':
        if ($request->userEmailAction == 'noAction') {
            $finalConfirmationUpdateMessage = $confirmationUpdateMessage . '.';
        }
        //Trimite notificare utilizatorului de confirmare email - prin email:
        if ($request->userEmailAction == 'notifyUserToConfirmEmail') {
            if ($user->email_verified_at == null) {
                $user->sendEmailVerificationNotification();
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " și a fost trimisă o notificare utilizatorului prin email pentru confirmare a email-ului.";
            } else {
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . ", dar nu s-a trimis o notificare utilizatorului prin email pentru confirmare a email-ului deoarece adresa de email este deja validată.";
            }
        }
        //Validare email:
        if ($request->userEmailAction == 'validateEmail') {
            if ($user->email_verified_at == null) {
                $user->email_verified_at = now();
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " și email-ul a fost validat cu succes.";
            } else {
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " dar email-ul nu a fost validat cu succes deoarece este deja validat.";   
            }
        }
        //Invalidare email:
        if ($request->userEmailAction == 'invalidateEmail') {
            if ($user->email_verified_at != null) {
                $user->email_verified_at = null;
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " și email-ul a fost invalidat cu succes.";
            } else {
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " și email-ul nu a fost invalidat cu succes deoarece este deja invalidat.";
            }
        }

        $user->save();
        
        return redirect(route('users'))->with('success', $finalConfirmationUpdateMessage);
    }

    public function deleteUser(Request $request, $userId) {
        $user = User::findOrFail($userId);
        if ($user->role == 'admin') {
            return redirect(route('users'));
        }
        if ($user->photo != 'defaultUserPhoto.png') {
            File::delete('images/users/' . $user->photo);
        }
        $user->delete();
        return redirect(route('users'))->with('success', 'Utilizatorul ' . $user->name . ' a fost sters definitiv din baza de date!');
    }
}
