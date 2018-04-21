<?php

namespace Tests\Browser\Admin;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdatePostTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_shows_form_default_values()
    {
        factory('App\Models\Post')->create([
            'title' => 'Foo',
            'slug'  => 'foo',
            'body'  => '<p>Hello world!</p>',
            'image_alt'  => 'Some image',
            'image_file' => 'image.jpg'
        ]);

        $this->browse(function ($browser) {

            $browser->visit('/admin/posts/foo/edit');

            $this->assertEquals('Foo', $browser->value('#title'));

            $this->assertEquals('Hello world!', $browser->text('#cke_1_contents .cke_wysiwyg_div'));

            $this->assertEquals('Some image', $browser->value('#image_alt'));

            $browser->assertSourceHas(config('app.url') . '/images/l/image.jpg');
        });
    }

    /** @test */
    public function it_updates_a_post()
    {
        factory('App\Models\Post')->create([
            'title' => 'Foo',
            'slug'  => 'foo',
            'body'  => '<p>world!</p>',
            'image_alt'  => 'Some image',
            'image_file' => 'image.jpg'
        ]);

        $this->browse(function ($browser) {

            $browser->visit('/admin/posts/foo/edit')
                    ->type('title', 'Bar')
                    ->type('image_alt', 'Something else')
                    ->keys('#cke_1_contents .cke_wysiwyg_div', 'Hello ')
                    ->click('.btn-primary')
                    ->assertSee('Bar')
                    ->clickLink('Bar');

            $this->assertEquals('Bar', $browser->value('#title'));

            $this->assertEquals('Hello world!', $browser->text('#cke_1_contents .cke_wysiwyg_div'));

            $this->assertEquals('Something else', $browser->value('#image_alt'));
        });
    }

    /** @test */
    public function it_deletes_post_image()
    {
        $post = factory('App\Models\Post')->create([
            'title' => 'Foo',
            'slug'  => 'foo'
        ]);

        $this->browse(function ($browser) use($post) {

            $browser->visit('/admin/posts/foo/edit')
                    ->check('delete_image')
                    ->click('.btn-primary')
                    ->clickLink('Foo')
                    ->assertSourceMissing(config('app.url') . '/images/l/' . $post->image_file);
        });
    }

    /** @test */
    public function it_replaces_post_image()
    {
        factory('App\Models\Post')->create([
            'title' => 'Foo',
            'slug'  => 'foo'
        ]);

        $this->browse(function ($browser) {

            $browser->visit('/admin/posts/foo/edit')
                    ->attach('image', storage_path('samples/photo.jpg'))
                    ->click('.btn-primary')
                    ->clickLink('Foo')
                    ->assertSourceHas(config('app.url') . '/images/l/' . Post::first()->image_file);
        });
    }

    /** @test */
    public function it_has_view_post_link()
    {
        factory('App\Models\Post')->create(['slug'  => 'foo']);

        $this->browse(function ($browser) {

            $browser->visit('/admin/posts/foo/edit')
                    ->click('h3 .btn')
                    ->assertPathIs('/posts/foo');
        });
    }
}