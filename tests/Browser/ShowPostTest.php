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
            'body'  => '<p>Content.</p>'
        ]);

        $this->browse(function ($browser) use($post) {
            $browser->visit('/posts/1')
                    ->assertSeeIn('h1', 'Foo')
                    ->assertSeeIn('p', $post->created_at)
                    ->assertDontSee('<p>')
                    ->assertSee('Content.');
        });
    }
}
