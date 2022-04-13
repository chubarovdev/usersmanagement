<?php

namespace Tests\Feature;

use App\Helpers\Tester;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    use DatabaseMigrations;

    protected $email;
    protected $password;
    protected $firstUser;
    protected $secondUser;


    protected function setUp(): void
    {
        parent::setUp();

        $faker = Factory::create();
        $this->email = $faker->email;
        $this->password = $faker->password(9);

        $this->firstUser = Tester::createUser($this->email, $this->password);

        $this->secondUser = Tester::createUser('second' . $this->email, $this->password);

    }

    /**
     * Проверка прав доступа гостя
     * @test
     * @return void
     */
    public function guest()
    {
        $this->get('/login')->assertStatus(200); // доступ только неавторизированные

        $this->get('/user/' . $this->firstUser->id . '/security')->assertStatus(302); // доступ только владелец профиля или админ

        $this->get('/admin/new_user')->assertStatus(302); // доступ только админ
    }

    /**
     * Проверка прав доступа авторизированного пользователя
     * @test
     */

    public function user()
    {
        Tester::authorizeUser($this->firstUser->email, $this->password);

        $this->get('/login')->assertStatus(302);

        $this->get('/user/' . $this->secondUser->id . '/security')->assertStatus(404);

        $this->get('/user/' . $this->firstUser->id . '/security')->assertStatus(200);

        $this->get('/admin/new_user')->assertStatus(404);

    }

    /**
     *  Проверка прав доступа для администратора
     * @test
     */

    public function admin()
    {
        $this->firstUser->role = 'admin';
        $this->firstUser->save();

        Tester::authorizeUser($this->firstUser->email, $this->password);

        $this->get('/login')->assertStatus(302);

        $this->get('/user/' . $this->secondUser->id . '/security')->assertStatus(200);

        $this->get('/user/' . $this->firstUser->id . '/security')->assertStatus(200);

        $this->get('/admin/new_user')->assertStatus(200);
    }
}
