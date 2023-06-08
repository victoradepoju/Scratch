<?php

namespace Tests\Unit;


use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create()
    {
        // 1. Define the goal
        // test if create() will actually create a record in the DB

        // 2. Replicate the env/restriction
        $repository = $this->app->make(PostRepository::class);

        // 3. Define the source of truth
        $payload = [
            'title' => 'heyaa',
            'body' => [],
        ];

        // 4. Compare the result
        $result = $repository->create($payload);

        $this->assertSame($payload['title'], $result->title, 'Post created does not have the same title.');
    }

    public function test_update()
    {
        // Goal: make sure that we can update a post using the update method.

        // 2. Replicate the env/restriction
        $repository = $this->app->make(PostRepository::class);

        $payload1 = [
            'title' => 'heyaa',
            'body' => [],
        ];

        $result1 = $repository->create($payload1);

        // 3. Define the source of truth
        $payload2 = [
            'title' => 'heyaa',
        ];

        // 4. Compare the result
        $result2 = $repository->update($result1, $payload2);

        $this->assertSame($payload2['title'], $result2->title, 'Post updated does not have the same title.');

    }

    public function test_delete_will_throw_exception_when_delete_post_that_doesnt_exist()
    {
        // env
        $repository = $this->app->make(PostRepository::class);

        $payload1 = [
            'title' => 'heyaa',
            'body' => [],
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
        $repository = $this->app->make(PostRepository::class);

        $payload1 = [
            'title' => 'heyaa',
            'body' => [],
        ];
        $result1 = $repository->create($payload1);

        // compare
        $repository->delete($result1);

        // verify if it is deleted
        $found = Post::query()->find($result1->id);

        $this->assertSame(null, $found, 'Post is not deleted');
    }
}
