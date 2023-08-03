<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\base\BaseTest;

class AuthTest extends BaseTest
{
    use RefreshDatabase, WithFaker;


    public function test_register_with_goods_credentials(): void
    {
        $password = "Password--1416";
        $data = [
            'email' => $this->faker->unique()->safeEmail(),
            'name' => $this->faker->name(),
            'password' => $password,
            'password_confirmation' => $password
        ];
        $response = $this->postJson('/api/register', $data);
        expect($response->getStatusCode())->toBe(201)
            ->and($response->json())->toHaveKeys(['user', 'access_token']);
    }

    public function test_register_with_bad_password() {

        $password = [
            "password",
            "pass",
            "password123",
        ];
        foreach ($password as $passwordTest) {

            $data = [
                'email' => $this->faker->unique()->safeEmail(),
                'name' => $this->faker->name(),
                'password' => $passwordTest,
                'password_confirmation' => $passwordTest
            ];

            $response = $this->postJson('/api/register', $data);

            expect($response->getStatusCode())->toBe(422)
                ->and($response->json())->toHaveKeys(['errors']);
        }
    }

    public function test_register_with_bad_confirm_password() {
        $password = "Password--1416";
        $data = [
            'email' => $this->faker->unique()->safeEmail(),
            'name' => $this->faker->name(),
            'password' => $password,
            'password_confirmation' => $password . '1'
        ];
        $response = $this->postJson('/api/register', $data);

        expect($response->getStatusCode())->toBe(422)
            ->and($response->json())->toHaveKeys(['errors']);
    }

    public function test_register_with_bad_email() {

        $password = "Password--1416";
        $data = [
            'email' => 'bad email',
            'name' => $this->faker->name(),
            'password' => $password,
            'password_confirmation' => $password
        ];
        $response = $this->postJson('/api/register', $data);
        expect($response->getStatusCode())->toBe(422)
            ->and($response->json())->toHaveKeys(['errors']);
    }

    /**
     * A basic feature test example.
     */
    public function test_login_with_goods_credentials(): void
    {
        $password = "Password--1416";
        $data = [
            'email' => $this->faker->unique()->safeEmail(),
            'name' => $this->faker->name(),
            'password' => $password,
            'password_confirmation' => $password
        ];
        $response = $this->postJson('/api/register', $data);

        $loginUserResponse = $this->postJson('/api/login', [
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        expect($loginUserResponse)->assertStatus(200);
    }
}
