<?php
/**
 * Created by PhpStorm.
 * User: luoming
 * Date: 2017/11/27
 * Time: 14:43
 */

namespace App\Api\Controllers;

use League\Fractal\TransformerAbstract;
use App\Post;

class PostTransformer extends TransformerAbstract
{
    public function transform(Post $post)
    {
//        return [
//            'title' => $post['title'],
//            'content' => $post['content'],
//        ];
        return array_except($post->toArray(), [
            'created_at', 'updated_at'
        ]);
    }
}