<?php

namespace App\Repositories;

use App\Events\Models\Post\PostCreated;
use App\Events\Models\Post\PostDeleted;
use App\Events\Models\Post\PostUpdated;
use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $created = Post::query()->create([
                'title' => data_get($attributes, 'title', 'Untitled'),
                'body' => data_get($attributes, 'body'),
//                'user_ids' => data_get($attributes, 'user_ids')
            ]);
//            if(!$created){
//                throw new GeneralJsonException('Failed to create post.');
//            }
            throw_if(!$created, GeneralJsonException::class, 'Failed to create.');
            event(new PostCreated($created));
            if($userIds = data_get($attributes, 'user_ids')){
                $created->users()->sync($userIds);
            }

            return $created;
        });
    }

    /**
     * @param Post $post
     * @param $attributes
     * @return mixed
     */
    public function update($post, $attributes)
    {
        return DB::transaction(function() use($post, $attributes){
            $updated = $post->update([
                'title' => data_get($attributes, 'title', $post->title),
                'body' => data_get($attributes, 'body', $post->body),
            ]);

//            if(!$updated){
//                throw new \Exception('Failed to update post');
//            }
            throw_if(!$updated, GeneralJsonException::class, 'Failed to update post.');
            event(new PostUpdated($post));
            if($userIds = data_get($attributes, 'user_ids')){
                $post->users()->sync($userIds);
            }

            return $post;
        });

    }

    /**
     * @param Post $post
     * @return mixed
     */
    public function delete($post)
    {
        return DB::transaction(function () use ($post){
            $deleted = $post->forceDelete();
//            if(!$deleted){
//                throw new \Exception('cannot delete post.');
//            }
            throw_if(!$deleted, GeneralJsonException::class, 'cannot delete post.');
            event(new PostDeleted($post));

            return $deleted;
        });

    }
}
