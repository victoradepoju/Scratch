<?php

namespace Tests\Unit;

use App\Exceptions\GeneralJsonException;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create()
    {
        // Goal: test if create() will actually create a record in the DB

        // env
        $repository = $this->app->make(CommentRepository::class);
        // source of truth
        $payload = [
            'body' => [],
            'user_id' => 2,
            'post_id' => 2,
        ];
        $result = $repository->create($payload);

        $this->assertSame($payload['user_id'], $result->user_id,'Comment created does not have the same user_id');
    }

    public function test_update()
    {
        // Goal: make sure that we can update a comment using the update method

        // env
        $repository = $this->app->make(CommentRepository::class);

        $payload1 = [
            'body' => [],
            'user_id' => 2,
            'post_id' => 2,
        ];
        $result1 = $repository->create($payload1);

        // source of truth
        $payload2 = [
            'body' => ['trying this'],
        ];

        // compare the results
        $result2 = $repository->update($result1, $payload2);

        $this->assertSame($payload2['body'], $result2->body, 'Comment updated does not have the same body');
    }

    public function test_delete_will_throw_exception_when_delete_comment_that_doesnt_exist()
    {
        // env
        $repository = $this->app->make(CommentRepository::class);

        $payload1 = [
            'body' => [],
            'user_id' => 2,
            'post_id' => 2,
        ];
        $result1 = $repository->create($payload1);

        // compare
        $repository->delete($result1);

        $this->expectException(GeneralJsonException::class);

        $repository->delete($result1);
    }

    public function test_delete()
    {
        // Goal: test if delete() is working

        // env
        $repository = $this->app->make(CommentRepository::class);

        $payload1 = [
            'body' => [],
            'user_id' => 2,
            'post_id' => 2,
        ];
        $result1 = $repository->create($payload1);

        // compare
        $repository->delete($result1);

        // verify if it is deleted
        $found = Comment::query()->find($result1->id);
        $this->assertSame(null, $found, 'Post is not deleted');
    }
}
