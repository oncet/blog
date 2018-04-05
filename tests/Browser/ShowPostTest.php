<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShowPostTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_shows_post_title_body_and_date()
    {
        factory('App\Models\Post')->create([
            'title' => 'Foo',
            'slug'  => 'foo',
            'body'  => '<p>Content.</p>'
        ]);

        $this->browse(function ($browser) {
            $browser->visit('/posts/foo')
                    ->assertSeeIn('h1', 'Foo')
                    ->assertSeeIn('p', ' ago')
                    ->assertDontSee('<p>')
                    ->assertSee('Content.');
        });
    }

    /** @test */
    public function it_shows_post_image()
    {
        $post = factory('App\Models\Post')->create(['slug'  => 'foo']);

        $image = factory('App\Models\Image')->create(['file' => 'foo.jpg']);

        $post->images()->save($image);

        $this->browse(function ($browser) {
            $browser->visit('/posts/foo')
                    ->assertSourceHas('images/large/foo.jpg');
        });
    }

    /** @test */
    public function source_contains_bootstrap()
    {
        factory('App\Models\Post')->create(['slug' => 'foo']);

        $this->browse(function ($browser) {
            $browser->visit('/posts/foo')
                    ->assertSourceHas('maxcdn.bootstrapcdn.com/bootstrap');
        });
    }
}
