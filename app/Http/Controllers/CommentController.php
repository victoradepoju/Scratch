<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @group Comment Management
 *
 * APIs to manage the post resource.
**/
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Gets a list of comments.
     *
     * @queryParam page_size int Size per page. Defaults to 20. Example: 20
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\CommentResource
     * @apiResourceModel App\Models\Comment
     */
    public function index(\Illuminate\Http\Request $request): ResourceCollection
    {
        $pageSize = $request->page_size ?? 20;
        $comments = Comment::query()->paginate($pageSize);

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created comment in storage.
     * @bodyParam body json required Body of the comment. Example: {This is my first comment}
     * @bodyParam user_id int required ID of the user. Example: 1
     * @bodyParam post_id int required ID of the post. Example: 2
     * @apiResource App\Http\Resources\CommentResource
     * @apiResourceModel App\Models\Comment
     */
    public function store(\Illuminate\Http\Request $request): CommentResource

    {
        $comment = Comment::query()->create([
            'body' => $request->body,
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
        ]);

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @urlParam id int required User ID
     * @apiResource App\Http\Resources\CommentResource
     * @apiResourceModel App\Models\Comment
     */
    public function show(Comment $comment): CommentResource
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified comment in storage.
     *
     * @bodyParam body json Body of the comment.
     * @bodyParam user_id int ID of the user. Example: 1
     * @bodyParam post_id int ID of the post. Example: 2
     * @apiResource App\Http\Resources\CommentResource
     * @apiResourceModel App\Models\Comment
     */
    public function update(\Illuminate\Http\Request $request, Comment $comment): CommentResource | JsonResponse
    {
        $updated = $comment->update($request->only('body'));

        if(!$updated){
            return new JsonResponse([
                'errors' => 'Could not update comment'
            ]);
        }

        return new CommentResource($comment);
    }

    /**
     * Remove the specified user from storage.
     *
     * @response 200 {
    "data": "deleted"
     * }
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $deleted = $comment->forceDelete();

        if(!$deleted){
            return new JsonResponse([
                'errors' => 'Could not delete comment'
            ]);
        }

        return new JsonResponse([
            'data' => 'deleted'
        ]);
    }
}
