<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Rules\IntegerArray;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @group Post Management
 *
 * APIs to manage the post resource.
 **/

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     *
     * Gets a list of posts.
     *
     * @queryParam page_size int Size per page. Defaults to 20. Example: 20
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     */
    public function index(\Illuminate\Http\Request $request): ResourceCollection
    {
        $pageSize = $request->page_size ?? 20;
        $posts = Post::query()
//            ->where('id', '=', '1')
            ->paginate($pageSize);

//        return new JsonResponse([
//            'data' => $posts
//        ]);
        return PostResource::collection($posts); // collection because we are getting more than one post
    }

    /**
     * Store a newly created post in storage.
     * @bodyParam title string required Title of the post. Example: Amazing Post
     * @bodyParam body string[] required Body of the post. Example: ["This post is super beautiful"]
     * @bodyParam user_ids int[] required The author ids of the post. Example: [1, 2]
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     */
    public function store(StorePostRequest $request, PostRepository $repository): PostResource
    {
        $payload = $request->only([
            'title',
            'body',
            'user_ids'
        ]);

//        $validator = Validator::make($payload, [
//            'title' => 'string|required',
//            'body' => ['string', 'required'],
//            'user_ids' => [
//                'array',
//                'required',
//                new IntegerArray(),
//            ],
//        ], [
//            'body.required' => "Please enter a value for body.",
//            'title.string' => "HEYYYYYsss use a string",
//        ], [
//            'user_ids' => 'USERR IDDD'
//        ]);
//
//        $validator->validate();

        $created = $repository->create($payload);

        return new PostResource($created);
    }

    /**
     * Display the specified post.
     *
     * @urlParam id int required User ID
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     */
    public function show(Post $post): PostResource
    {

        return new PostResource($post);
//        return new JsonResponse([
//            'data' => $post
//        ]);
    }

    /**
     * Update the specified post in storage.
     * @bodyParam title string required Title of the post. Example: Amazing Post
     * @bodyParam body string[] required Body of the post. Example: ["This post is super beautiful"]
     * @bodyParam user_ids int[] required The author ids of the post. Example: [1, 2]
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     */
    public function update(\Illuminate\Http\Request $request, Post $post, PostRepository $repository): PostResource | JsonResponse
    {
            $post = $repository->update($post, $request->only([
                'title',
                'body',
                'user_ids',
            ]));
            return new PostResource($post);

    }

    /**
     * Remove the specified post from storage.
     *
     * @response 200 {
    "data": "deleted"
     * }
     */
    public function destroy(Post $post, PostRepository $repository): JsonResponse
    {
        $post = $repository->delete($post);
            return new JsonResponse([
                'data' => 'deleted'
            ]);
    }
}
