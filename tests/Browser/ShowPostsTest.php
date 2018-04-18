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
            $browser->visit('/')
                    ->assertSeeIn('.post h2', 'Foo')
                    ->assertSeeIn('.post .summary', 'Hello world!')
                    ->assertDontSee('<p>')
                    ->assertSourceHas('/posts/foo');
        });
    }

    /** @test */
    public function is_shows_post_image()
    {
        $post = factory('App\Models\Post')->create([
            'slug'  => 'foo',
            'image_file' => 'foo.jpg'
        ]);

        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->assertSourceHas('<img src="' . config('app.url') . '/images/xl/foo.jpg"');
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
            $browser->visit('/')
                    ->assertSeeLink('Foo')
                    ->assertSourceHas(config('app.url') . '/posts/foo')
                    ->clickLink('Foo')
                    ->assertSeeIn('h2', 'Foo');
        });
    }

    /** @test */
    public function image_links_to_post()
    {
        $post = factory('App\Models\Post')->create([
            'title' => 'Foo',
            'slug'  => 'foo',
            'image_file' => 'foo.jpg'
        ]);

        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->assertSourceHas('images/xl/foo.jpg')
                    ->assertSourceHas('<a href="' . config('app.url') . '/posts/foo"><img')
                    ->click('a[href="' . config('app.url') . '/posts/foo"]')
                    ->assertSeeIn('h2', 'Foo');
        });
    }

    /** @test */
    public function it_has_navbar()
    {
        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->assertSeeLink(config('app.name'))
                    ->assertSeeIn('.navbar-brand', config('app.name'))
                    ->clickLink(config('app.name'))
                    ->assertPathIs('/');
        });
    }

    /** @test */
    public function it_has_pagination()
    {
        factory('App\Models\Post', 10)->create();

        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->assertSeeIn('.pagination .page-item.active', 1)
                    ->assertSeeLink('2');
        });
    }
}
