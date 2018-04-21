<?php

namespace Tests\Browser\Admin;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShowPostsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_shows_post_id_and_title()
    {
        factory('App\Models\Post')->create(['title' => 'Foo']);

        $this->browse(function ($browser) {
            $browser->visit('/admin/posts')
                    ->assertSee('1')
                    ->assertSee('Foo');
        });
    }

    /** @test */
    public function it_shows_posts_in_desc_order()
    {
        factory('App\Models\Post', 2)->create();

        $this->browse(function ($browser) {
            $browser->visit('/admin/posts')
                    ->assertSeeIn('tr.odd td', '2');
        });
    }

    /** @test */
    public function it_shows_post_created_at()
    {
        $post = factory('App\Models\Post')->create();

        $this->browse(function ($browser) use($post) {
            $browser->visit('/admin/posts')
                    ->assertSee($post->created_at->toDateTimeString());
        });
    }

    /** @test */
    public function post_title_links_to_edit_form()
    {
        factory('App\Models\Post')->create([
            'title' => 'Foo',
            'slug' => 'foo'
        ]);

        $this->browse(function ($browser) {
            $browser->visit('/admin/posts')
                    ->clickLink('Foo')
                    ->assertPathIs('/admin/posts/foo/edit');
        });
    }

    /** @test */
    public function it_has_link_to_create_post()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/posts')
                    ->clickLink('Create post')
                    ->assertPathIs('/admin/posts/create');
        });
    }

    /** @test */
    public function it_has_link_to_posts_list()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/posts')
                    ->clickLink('View posts')
                    ->assertPathIs('/admin/posts');
        });
    }
}