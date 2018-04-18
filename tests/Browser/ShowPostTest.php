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
        $post = factory('App\Models\Post')->create([
            'title' => 'Foo',
            'slug'  => 'foo',
            'body'  => '<p>Content.</p>'
        ]);

        $this->browse(function ($browser) use($post) {
            $browser->visit('/posts/foo')
                    ->assertSeeIn('h2', 'Foo')
                    ->assertSourceHas($post->created_at->toDateTimeString())
                    ->assertDontSee('<p>')
                    ->assertSee('Content.');
        });
    }

    /** @test */
    public function it_shows_post_image()
    {
        factory('App\Models\Post')->create([
            'slug'  => 'foo',
            'image_file' => 'foo.jpg'
        ]);

        $this->browse(function ($browser) {
            $browser->visit('/posts/foo')
                    ->assertSourceHas(config('app.url') . '/images/xl/foo.jpg');
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

    /** @test */
    public function titles_contains_site_name()
    {
        factory('App\Models\Post')->create(['slug' => 'foo']);

        $this->browse(function ($browser) {
            $browser->visit('/posts/foo')
                    ->assertTitleContains(config('app.name'));
        });
    }
}
