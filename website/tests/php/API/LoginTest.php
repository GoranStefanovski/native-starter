<?php

namespace tests\php\API;

use App\Applications\User\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Util\Errors;
use App\Util\Utils;
use Tests\TestCase;

class LoginTest extends TestCase
{
//    use RefreshDatabase;

//    /** @test */
//    public function login_existing_user(){
//
////        $this->expectOutputString('foo');
////
////        $this->assertEquals(2,2,'true');
////        $user = User::where([
////            'first_name' => 'admin',
////            'email' => 'admin@example.test',
////            'password' => bcrypt('password')
////        ]);
//
//        $user = User::where('email', 'admin@example.com')->first();
//
//        $response = $this->post('/api/guest/user/login', [
//            'email' => $user->email,
//            'password' => 'password',
////            'device_name' => 'iphone'
//        ]);
//
//        $response->assertSuccessful();
//        $this->assertNotEmpty($response->getContent());
//        $this->assertDatabaseHas('personal_access_tokens',[
//            'name' => 'iphone',
//            'tokenable_type' => User::class,
//            'tokenable_id' => $user->id
//        ]);
//    }

    /** @test */
    public function get_logged_user_from_token(){

        $user = User::create([
            'first_name' => 'TESTTEST',
            'email' => 'test@test.test',
            'password' => bcrypt('password')
        ]);

        $token = $user->createToken('iphone')->plainTextToken;

//        $user = User::where('email', 'admin@example.com')->first();

        $response = $this->get('/api/usersanct/user', [
                'Authorization' => 'Bearer ' . $token
//            'email' => $user->email,
//            'password' => 'password',
//            'device_name' => 'iphone'
        ]);

       $response->assertSuccessful();
//       echo json_encode($response);
       $response->assertJson(function ($json){
           $json->where('email','test@test.test')
               ->missing('password')
               ->etc();
       });
    }


}
