<?php

namespace Tests\Browser\Admin;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreatePostTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function create_a_basic_post()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/posts/create')
                    ->type('title', 'Foo')
                    ->keys('#cke_1_contents .cke_wysiwyg_div', 'Hello world!')
                    ->click('.btn-primary')
                    ->assertSee('Post successfully created!')
                    ->visit('/posts/foo')
                    ->assertSourceMissing(config('app.url') . '/images/xl/')
                    ->assertSourceHas('<p>Hello world!</p>');
        });
    }

    /** @test */
    public function create_a_post_with_one_image()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/posts/create')
                    ->type('title', 'Foo')
                    ->keys('#cke_1_contents .cke_wysiwyg_div', 'Hello world!')
                    ->attach('image', storage_path('samples/photo.jpg'))
                    ->click('.btn-primary')
                    ->assertSee('Post successfully created!')
                    ->visit('/posts/foo')
                    ->assertSourceHas(config('app.url') . '/images/xl/' . Post::first()->image_file)
                    ->assertSourceHas('<p>Hello world!</p>');
        });
    }

    /** @test */
    public function it_contains_link_to_frontend()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/posts')
                    ->clickLink(config('app.name'))
                    ->assertPathIs('/');
        });
    }
}
