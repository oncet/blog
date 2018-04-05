<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShowPostsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_shows_posts_title_and_summary()
    {

        factory('App\Models\Post')->create([
            'title' => 'Foo',
            'slug'  => 'foo',
            'body'  => '<p>Hello world!</p>'
        ]);

        $this->browse(function ($browser) {
            $browser->visit('/posts')
                    ->assertSeeIn('.post h2', 'Foo')
                    ->assertSeeIn('.post .summary', 'Hello world!')
                    ->assertSourceHas('/posts/foo');
        });
    }

    /** @test */
    public function is_shows_post_image()
    {
        $post = factory('App\Models\Post')->create(['slug'  => 'foo']);

        $image = factory('App\Models\Image')->create(['file' => 'foo.jpg']);

        $post->images()->save($image);

        $this->browse(function ($browser) {
            $browser->visit('/posts')
                    ->assertSourceHas('images/large/foo.jpg');
        });
    }

    /** @test */
    public function title_links_to_post()
    {
        factory('App\Models\Post')->create([
            'title' => 'Foo',
            'slug'  => 'foo'
        ]);

        $this->browse(function ($browser) {
            $browser->visit('/posts')
                    ->assertSeeLink('Foo')
                    ->assertSourceHas(env('APP_URL') . '/posts/foo');
        });
    }

    /** @test */
    public function image_links_to_post()
    {
        $post = factory('App\Models\Post')->create(['slug'  => 'foo']);

        $image = factory('App\Models\Image')->create(['file' => 'foo.jpg']);

        $post->images()->save($image);

        $this->browse(function ($browser) {
            $browser->visit('/posts')
                    ->assertSourceHas('images/large/foo.jpg')
                    ->assertSourceHas('<a href="' . env('APP_URL') . '/posts/foo"><img');
        });
    }
}
