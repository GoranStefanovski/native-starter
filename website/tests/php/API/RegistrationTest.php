<?php

namespace tests\php\API;

use App\Applications\User\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Util\Errors;
use App\Util\Utils;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
//    use RefreshDatabase;

    /** @test */
    public function register_new_user(){
        $response = $this->post('api/guest/user/register',[
            'name' => "TestRegister",
            'email' => 'register@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'device_name' => 'iphone'
        ]);

        $response->assertSuccessful();
        $this->assertNotEmpty($response->getContent());
        $this->assertDatabaseHas('users',['email'=>'register@test.com']);
        $this->assertDatabaseHas('personal_access_tokens',[
            'name' => 'REGISTERED TestRegister',
            'tokenable_type' => User::class,
//            'tokenable_id' => $user->id
        ]);
    }


}
