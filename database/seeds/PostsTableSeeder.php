<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = factory(App\Models\Post::class)->create([
            'title' => 'Foo',
            'slug'  => 'foo'
        ]);

        $image = factory(App\Models\Image::class)->create();

        $post->images()->save($image);
    }
}
