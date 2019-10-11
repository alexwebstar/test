<?php

use Illuminate\Database\Seeder;
use App\Models\Comment as modelComment;

class Comment extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $name = 'user name';
        $message = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';

        $deep1 = modelComment::create([
            'name' => $name,
            'comment' => $message,
        ]);

        modelComment::create([
            'name' => $name,
            'comment' => $message,
        ]);

        modelComment::create([
            'name' => $name,
            'comment' => $message,
        ]);

        $deep2 = modelComment::create([
            'parent_id' => $deep1->id,
            'name' => $name,
            'comment' => $message,
        ]);

        modelComment::create([
            'parent_id' => $deep1->id,
            'name' => $name,
            'comment' => $message,
        ]);

        modelComment::create([
            'parent_id' => $deep2->id,
            'name' => $name,
            'comment' => $message,
        ]);

    }
}
