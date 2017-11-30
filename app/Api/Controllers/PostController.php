<?php
/**
 * Created by PhpStorm.
 * User: luoming
 * Date: 2017/11/27
 * Time: 14:15
 */

namespace App\Api\Controllers;


use App\Post;

class PostController extends BaseController
{
    public function index()
    {
        $post =  Post::all();

        return $this->collection($post, new PostTransformer());
    }

    public function show($id)
    {
        $post = Post::find($id);
        if(! $post){
            return $this->response->errorNotFound('post not found123');
        }
        return $this->item($post,new PostTransformer());
    }
}