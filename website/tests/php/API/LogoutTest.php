<?php

namespace tests\php\API;

use App\Applications\User\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Util\Errors;
use App\Util\Utils;
use Tests\TestCase;

class LogoutTest extends TestCase
{
//    use RefreshDatabase;

    /** @test */
    public function log_out_user(){

      $user = User::create([
          'first_name' => 'LogOutUser',
          'email' => 'log@out.test',
          'password' => bcrypt('password')
      ]);

      $token = $user->createToken('LOGGEDOUT')->plainTextToken;

      $response = $this->post('/api/usersanct/logout',[],[
          'Authorization' => 'Bearer ' . $token
      ]);

      $response->assertSuccessful();

      $this->assertDatabaseMissing('personal_access_tokens',[
          'name' => 'LOGGEDOUT'
      ]);


    }


}
