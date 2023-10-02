<?php


namespace App\Http\Controllers\Auth;

use App\Applications\User\Model\Role;
use App\Applications\User\Model\User;
use App\Applications\Common\Model\SubTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Providers\RouteServiceProvider;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Applications\Common\DAL\MediaDALInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * @property MediaDALInterface $mediaDAL
 * @property User $user
 */
class AuthenticatedSessionController extends Controller
{

    use HttpResponses;

    public function __construct(
        User $user,
        SubTypes $subTypes,
        MediaDALInterface $mediaDAL,
    ){
        $this->user = $user;
        $this->subTypes = $subTypes;
        $this->mediaDAL = $mediaDAL;
    }
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
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('','Credentials do not match',401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('LOGGED ' . $user->first_name)->plainTextToken
        ]);
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
        $sub_name = SubTypes::where('id', $request->sub_type)->first();
        $request->validated($request->all());
        // ALl this data will be editable on edit profile
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'is_disabled' => $request->is_disabled,
            'is_artist' => $request->roles == '5' ? true : false,
            'company' => $request->company,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_id' => $request->country_id,
            'country' => \Countries::find($request['country_id'])->name,
            'password' => Hash::make($request->password),
            'sub_type' => $request->sub_type,
            'sub_name' => $sub_name->name,
        ]);
         
        $user->roles()->attach($request->roles);
        $this->mediaDAL->save($request,$user,'user_avatars');

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('REGISTERED ' . $user->first_name)->plainTextToken
        ]);
    }

    public function registerPublic(StoreUserRequest $request) {

        $user = User::create([
            'username' => $request->first_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('REGISTERED ' . $user->first_name)->plainTextToken
        ]);
    }

    public function editUser(Request $request, $id){
        $user = $this->user::find($id);
        $sub_name = SubTypes::where('id', $request->sub_type)->first();

        $data['first_name'] = $request['first_name'];
        $data['email'] = $request['email'];
        $data['last_name'] = $request['last_name'];
        $data['is_disabled'] = $request['is_disabled'];
        $data['country'] = $request['country'];
        $data['company'] = $request['company'];
        $data['phone'] = $request['phone'];
        $data['sub_type'] = $request['sub_type'];
        $data['sub_name'] = $sub_name->name;
        try{
            $user->update($data);
            return "User Updated";
        }catch( \Exception $e){
            return $e;
        }
//        $user = User::where('email', $request['email'])->firstOrFail();
    }

    public function getArtists() {
        $query = DB::table('users')
        ->select(
            DB::raw('users.id as id'),
            DB::raw('users.username as username'),
            DB::raw('users.first_name as first_name'),
            DB::raw('users.last_name as last_name'),
            DB::raw('media.file_name as file_name'),
            DB::raw('media.id as model_id')
        )->leftJoin('media', function ($join) {
            $join->on('users.id', '=', 'media.model_id')
            ->where('media.model_type', '=','App\\Applications\\User\\Model\\User')
            ->where('media.collection_name', '=', 'user_avatars');
        })->orderByRaw('
            CASE 
                WHEN users.sub_type = 3 THEN 1
                WHEN users.sub_type = 2 THEN 2
                WHEN users.sub_type = 1 THEN 3
                ELSE 4
            END
        ')
        ->orderByRaw('RAND()');

        $query->whereNull('users.deleted_at');
        $query->where('users.is_artist',1);
        $query->where('users.is_disabled',0);

        return $query->get();
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
//        dd($this->guard());
        $obj = Auth::user();
        $obj['roles_array'] = Auth::user()->roles_array();
        $permissions = Auth::user()->permissions_array();
        $obj['permissions_array'] = $permissions;
//       return response()->json($obj);
        return $request->user();
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard(): \Illuminate\Contracts\Auth\Guard
    {
        return Auth::guard('web');
    }


    public function updateProfile(Request $request)
    {
        $sub_name = SubTypes::where('id', $request->sub_type)->first();

        $request_array = $request->all();
        $user = Auth::user();
        $data['first_name'] = $request_array['first_name'];
        $data['last_name'] = $request_array['last_name'];
        $data['email'] = $request_array['email'];
        $data['sub_type'] = $sub_name->name;
        //$data['company'] = $request_array['company'];//No field to edit this
//        $data['phone'] = $request_array['phone'];//No field to edit this
        // if (array_key_exists('country_id', $request_array)) $data['country_id'] = $request_array['country_id'];
        $user->update($data);

        // $this->userDAL->editUser($user, $data);
    }

}
