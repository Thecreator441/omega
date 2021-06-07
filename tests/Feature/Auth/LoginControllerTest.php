<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogin()
    {
        Session::start();
        $response = $this->call('POST', 'login', [
            'name' => 'name',
            'password' => 'password',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('omega.login', $response->original->name());
    }
}
