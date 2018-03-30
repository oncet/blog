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
}
