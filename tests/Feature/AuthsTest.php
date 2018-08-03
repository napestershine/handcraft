<?php

namespace Tests\Feature;

use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class AuthsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_user_can_register(): void {
        $data = [
            'name' => 'Xiao',
            'phone' => '9876523212',
            'email' => 'h1u@gmail.com',
            'password' => app('hash')->make('secret')
        ];
        $response = $this->json('POST', '/api/v1/auth/register', $data);
        $response->assertResponseStatus(200);
    }

    /**
     * @test
     */
    public function a_user_can_login(): void {
        $data = [
            'email' => 'h1u@gmail.com',
            'password' => app('hash')->make('secret')
        ];
        $response = $this->json('POST', '/api/v1/auth/login', $data);
        $response->assertResponseStatus(200);
    }
}
