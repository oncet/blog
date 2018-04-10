<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreatePostTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function create_a_post()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/posts/create')
                    ->type('title', 'Foo')
                    ->type('body', '<p>Hello worl!</p>')
                    ->click('.btn-primary')
                    ->assertSee('Post successfully created!');
        });
    }
}
