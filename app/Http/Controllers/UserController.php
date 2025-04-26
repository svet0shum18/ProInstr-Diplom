<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function PHPUnit\Framework\returnArgument;


class UserController extends Controller
{
    public function create()//показ формы регистарици пользователя
    {
        return view("user.create");
    }

    public function store(Request $request) //принимаем данные из формы регистрации
    {   
        $request->validate([
            'name' => ['required','max:255'],
            'email'=> ['required','email','max:255', 'unique:users'],
            'password'=> ['required','confirmed'],
        ]);

        $user = User::create($request->all());
        event(new Registered($user));

        Auth::login($user);


        return redirect()->route('verification.notice');
    }

    public function login() 
    {
        return view("user.login");
    }

    public function loginAuth(Request $request) 
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required',],

        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Проверяем, является ли пользователь администратором
            if (Auth::user()->is_admin) {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Добро пожаловать, '. Auth::user()->name);
            }
            
            return redirect()->intended(route('dashboard'));
        }




        return back()->withErrors([
            'email' => 'Неверный логин или пароль'
        ]);
    }


    public function logout() 
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function destroy(Request $request)
{
    $request->validate([
        'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    Auth::logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('status', 'Ваш аккаунт успешно удален.');
}


    public function forgotPasswordStore(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::ResetLinkSent
                    ? back()->with(['success' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }


    public function resetPasswordUpdate(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PasswordReset
                    ? redirect()->route('login')->with('success', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }



    // СМЕНА ИМЕНИ В КАБИНЕТЕ
    public function updateName(Request $request)
{
    $request->validate( [
        'name' => 'required|string|max:255|min:2',
    ]);


    $user = Auth::user();
    $user->name = $request->name;
    $user->save();

    return response()->json([
        'success' => true,
        'name' => $user->name
    ]);
}


    public function dashboard()
    {
        return view("user.dashboard");
    }
     

}
