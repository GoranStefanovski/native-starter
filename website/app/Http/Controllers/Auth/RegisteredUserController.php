<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Applications\User\Model\User;
use App\Http\Requests\StoreUserRequest;
use App\Providers\RouteServiceProvider;
use App\Traits\HttpResponses;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    use HttpResponses;

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  StoreUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());
//        $request->validate([
//            'name'=>['required'],
//            'email'=>['required','email','unique:users,email'],
//            'password'=>['required','min:8','confirmed'],
//            'device_name'=>['required'],
//        ]);
        $user = User::create([
            'first_name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('REGISTERED ' . $user->first_name)->plainTextToken
        ]);

//        event(new Registered($user));
//
//        Auth::login($user);
//
//        return $user;
//        return redirect(RouteServiceProvider::HOME);
    }
}
