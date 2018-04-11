<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreatePostTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function create_a_post()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/posts/create')
                    ->type('title', 'Foo')
                    ->keys('#cke_1_contents .cke_wysiwyg_div', 'Hello world!')
                    ->click('.btn-primary')
                    ->assertSee('Post successfully created!')
                    ->visit('/posts/foo')
                    ->assertSourceHas('<p>Hello world!</p>');
        });
    }
}
