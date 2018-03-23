<?php

namespace Tests\Browser;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShowPostTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_shows_post_title_and_body()
    {
        Post::create([
            'title' => 'Foo',
            'body'  => '<p>Content.</p>'
        ]);

        $this->browse(function ($browser) {
            $browser->visit('/posts/1')
                    ->assertSee('Foo')
                    ->assertSee('Content.')
                    ->assertDontSee('<p>');
        });
    }
}
