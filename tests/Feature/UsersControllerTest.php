<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->count(10)->create();

        $this->user = User::find(10);

        $this->actingAs($this->user);

        $this->faker = Factory::create();
    }

    /**
     * Проверка загрузки главной страницы
     * @test
     * @return void
     */
    public function index()
    {
        $this
            ->get('/')
            ->assertOk()
            ->assertSee($this->user->email);
    }

    /**
     * Проверка загрузки страницы профиля
     * @test
     */
    public function profile()
    {
        $this
            ->get("/user/{$this->user->id}")
            ->assertOk()
            ->assertSee($this->user->email);
    }

    /**
     * Проверка загрузки страницы редактирования главной информации о пользователе
     * @test
     */
    public function mainInfo()
    {
        $this
            ->get("/user/{$this->user->id}/edit")
            ->assertOk()
            ->assertSee($this->user->name);
    }

    /**
     * Проверка отображения страницы сохранения главной информации о пользователе
     * @test
     */
    public function storeMainInfo()
    {
        $this
            ->post("/user/{$this->user->id}/edit", ['name' => $this->user->name . 'test'])
            ->assertStatus(302)
            ->assertSessionHasNoErrors();

        $this->get("/user/{$this->user->id}/edit")->assertSee('успешно обновлены');
    }

    /**
     * Проверка отображения страницы редактирования e-mail и пароля пользователя
     * @test
     */
    public function security()
    {
        $this
            ->get("/user/{$this->user->id}/security")
            ->assertOk()
            ->assertSee($this->user->email);
    }

    /**
     * Проверка отображения страницы об успешном редактировании e-mail и пароля
     * @test
     */
    public function storeSecurity()
    {
        $this->post("/user/{$this->user->id}/security", [
            'email' => 'test' . $this->user->email,
            'password' => $this->user->password . 'test',
            'passwordRepeat' => $this->user->password . 'test'
            ]);

        $this
            ->get("/user/{$this->user->id}/security")
            ->assertOk()
            ->assertSessionHasNoErrors()
            ->assertSee(['Пароль успешно', 'E-mail успешно']);
    }

    /**
     * Проверка отображение страницы редактирования аватара пользователя
     * @test
     */
    public function avatar()
    {
        $this->get("/user/{$this->user->id}/avatar")->assertStatus(200);
    }

    /**
     * Проверка отображения страницы сохранения аватара пользователя
     * @test
     */
    public function storeAvatar()
    {
        $this
            ->post("/user/{$this->user->id}/avatar", ['avatar' => UploadedFile::fake()->image('avatar.jpg')])
            ->assertSessionHasNoErrors()
            ->assertRedirect("/");
    }

    /**
     * Проверка отображение страницы редактирования статуса пользователя
     * @test
     */
    public function status()
    {
        $this->get("/user/{$this->user->id}/status")->assertOk();
    }

    /**
     * Проверка сохранения статуса пользователя
     * @test
     */
    public function storeStatus()
    {
        $this
            ->post("/user/{$this->user->id}/status", ['status' => 3])
            ->assertSessionHasNoErrors()
            ->assertStatus(302);

        $this->get("/user/{$this->user->id}/status")->assertSee('Статус успешно обновлен!');

        $this->post("/user/{$this->user->id}/status", ['status' => 4])->assertSessionHasErrors();
    }

    /**
     * Проверка удаления пользователя
     * @test
     */
    public function deleteProfile()
    {
        $this->get("/user/{$this->user->id}/delete")->assertRedirect('/logout');

        $this->get("/user/{$this->user->id}")->assertNotFound();
    }
}
