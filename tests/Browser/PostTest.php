<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShowPostsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function create_and_view_a_post()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/posts/create')
                    ->type('title', 'My first post')
                    ->keys('#cke_1_contents .cke_wysiwyg_div', 'Hello world!')
                    ->click('#create_post')
                    ->assertSee('Post successfully created!')
                    ->visit('/')
                    ->clickLink('My first post')
                    ->assertPathIs('/posts/my-first-post');
        });
    }

    /** @test */
    public function create_and_view_a_post_with_an_image()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/posts/create')
                    ->type('title', 'My first post')
                    ->keys('#cke_1_contents .cke_wysiwyg_div', 'Hello world!')
                    ->attach('image', storage_path('samples/photo.jpg'))
                    ->click('#create_post')
                    ->assertSee('Post successfully created!')
                    ->visit('/')
                    ->clickLink('My first post')
                    ->assertPathIs('/posts/my-first-post');

            $this->assertNotNull($browser->element('#post_image img'));
        });
    }

    /** @test */
    public function update_a_post()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/posts/create')
                    ->type('title', 'My first post')
                    ->keys('#cke_1_contents .cke_wysiwyg_div', 'Hello world!')
                    ->attach('image', storage_path('samples/photo.jpg'))
                    ->click('#create_post')
                    ->clickLink('My first post')
                    ->type('title', 'Small update')
                    ->keys('#cke_1_contents .cke_wysiwyg_div', 'Something else')
                    ->check('delete_image')
                    ->click('#update_post')
                    ->assertSee('Post successfully updated!')
                    ->visit('/posts/my-first-post')
                    ->assertSee('Small update')
                    ->assertSee('Something else');

            $this->assertNull($browser->element('#post_image img'));
        });
    }

    /** @test */
    public function delete_and_restore_a_post()
    {
        $this->browse(function ($browser) {

            // Assert post is deleted
            $browser->visit('/admin/posts/create')
                    ->type('title', 'My first post')
                    ->keys('#cke_1_contents .cke_wysiwyg_div', 'Hello world!')
                    ->attach('image', storage_path('samples/photo.jpg'))
                    ->click('#create_post')
                    ->clickLink('My first post')
                    ->click('#delete_post')
                    ->assertSee('Post successfully deleted!')
                    ->visit('/')
                    ->assertDontSee('My first post')
                    ->visit('/posts/my-first-post')
                    ->assertSee('Sorry, the page you are looking for could not be found.');

            // Assert post is restored
            $browser->visit('/admin')
                    ->clickLink('My first post')
                    ->click('#restore_post')
                    ->assertSee('Post successfully restored!')
                    ->visit('/')
                    ->clickLink('My first post')
                    ->assertSee('My first post')
                    ->assertSee('Hello world!');

            $this->assertNotNull($browser->element('#post_image img'));
        });
    }

    /** @test */
    public function permanently_delete_a_post()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/posts/create')
                    ->type('title', 'My first post')
                    ->keys('#cke_1_contents .cke_wysiwyg_div', 'Hello world!')
                    ->attach('image', storage_path('samples/photo.jpg'))
                    ->click('#create_post')
                    ->clickLink('My first post')
                    ->click('#delete_post')
                    ->clickLink('My first post')
                    ->click('#permanently_delete_post')
                    ->assertSee('Post permanently deleted!');
        });
    }
}
