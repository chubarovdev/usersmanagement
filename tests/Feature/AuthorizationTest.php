<?php

namespace Tests\Feature;


use App\Helpers\Tester;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use DatabaseMigrations;

    protected $email;
    protected $password;

    protected function setUp(): void
    {
        parent::setUp();

        $faker = Factory::create();
        $this->email = $faker->email;
        $this->password = $faker->password(9);
    }

    /**
     * Проверка системы регистрации
     * @test
     */
    public function registration()
    {
        $this->get('/registration')->assertStatus(200);

        $response = $this->post('/registration', ['email' => $this->email, 'password' => $this->password]);

        $response->assertRedirect('/login');

        $this->assertDatabaseHas('users', ['email' => $this->email]);

    }

    /**
     * Проверка системы авторизации
     * @test
     */
    public function login()
    {
        $user = Tester::createUser($this->email, $this->password);

        $this->get('/login')->assertStatus(200);

        $response = $this->post('/login', ['email' => $this->email, 'password' => $this->password]);

        $response->assertRedirect('/');

        $this->assertAuthenticated();

    }
}
