<?php

namespace Tests\Browser\Admin;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

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
}
