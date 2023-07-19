<?php


namespace App\Http\Controllers\Auth;

use App\Applications\User\Model\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{

    use HttpResponses;
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        Log::emergency('ABCD');
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function login(Request $request)
    {
        if ($token = $this->guard()->attempt($request->only('email', 'password'))) {
//            if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('','Credentials do not match',401);
//                response()->json([
//                'message' => 'Invalid login details'
//            ], 401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
//        $token = $user->createToken('auth_token')->plainTextToken;
//        dd($user->name);
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('LOGGED ' . $user->first_name)->plainTextToken
//            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request){
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'You have succesfully been logged out and your token has been removed'
        ]);
    }


    public function createUserToken(Request $request){
        $token = $request->user()->createToken($request->token_name);

        return ['token' => $token->plainTextToken];
    }

    /**
     * @throws ValidationException
     */
    public function getToken(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        return $user->createToken($request->device_name)->plainTextToken;
}

    public function test(){
        return 'TEST';
    }

    public function user(Request $request){
//        $obj = Auth::user();
//        $obj['roles_array'] = Auth::user()->roles_array();
//        $permissions = Auth::user()->permissions_array();
//        $obj['permissions_array'] = $permissions;
//       return response()->json($obj);
        return $request->user();
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('web');
    }

}
