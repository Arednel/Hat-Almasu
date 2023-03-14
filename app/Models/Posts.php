<?php

namespace App\Models;

use PDO;

class Posts
{
    public static function all()
    {
        return
            array(
                array(
                    'id' => '1',
                    'title' => 'post one',
                    'text' => 'something'
                ),
                array(
                    'id' => '2',
                    'title' => 'post two',
                    'text' => 'something'
                )
            );
    }

    public static function find($id)
    {
        $postsAll = self::all();

        foreach ($postsAll as $post) {
            if ($post['id'] == $id) {
                return $post;
            }
        }
    }
}
