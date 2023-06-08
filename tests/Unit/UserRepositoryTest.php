<?php

namespace Tests\Unit;


use App\Exceptions\GeneralJsonException;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create()
    {
        // Goal: test if create() will actually create a record in the DB

        // env
        $repository = $this->app->make(UserRepository::class);

        // source of truth
        $payload = [
            'name' => 'victorsstest',
            'email' => 'victorstesst@gmail.com',
            'password' => 'victortest',
            'password_confirm' => 'victortest'
        ];

        // compare
        $result = $repository->create($payload);

        $this->assertSame($payload['name'], $result->name, 'User created does not have the same name');
    }

    public function test_update()
    {
        // Goal: make sure that we can update a user using the update method

        // env
        $repository = $this->app->make(UserRepository::class);

        $payload1 = [
            'name' => 'anothervictorsstest',
            'email' => 'anothervictorsstest@gmail.com',
            'password' => 'victortest',
            'password_confirm' => 'victortest'
        ];
        $result1 = $repository->create($payload1);

        // source of truth
        $payload2 = [
            'name' => 'newanothervictorsstest',
        ];

        $result2 = $repository->update($result1, $payload2);

        $this->assertSame($payload2['name'], $result2->name, 'User updated does not have the same name');

    }

    public function test_delete_will_throw_exception_when_delete_user_that_doesnt_exist()
    {
        // env
        $repository = $this->app->make(UserRepository::class);

        $payload1 = [
            'name' => 'anothervictorssstest',
            'email' => 'anothervictorssstest@gmail.com',
            'password' => 'victortest',
            'password_confirm' => 'victortest'
        ];
        $result1 = $repository->create($payload1);

        $repository->delete($result1);

        $this->expectException(GeneralJsonException::class);

        $repository->delete($result1);
    }

    public function test_delete()
    {
        // Goal: test if delete() is working

        // env
        $repository = $this->app->make(UserRepository::class);

        $payload1 = [
            'name' => 'anothervictorsssstest',
            'email' => 'anothervictorsssstest@gmail.com',
            'password' => 'victortest',
            'password_confirm' => 'victortest'
        ];
        $result1 = $repository->create($payload1);

        $repository->delete($result1);

        $found = User::query()->find($result1->id);

        $this->assertSame(null, $found, 'User is not deleted');

    }
}
