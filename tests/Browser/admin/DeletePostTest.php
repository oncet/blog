<?php

namespace Tests\Browser\Admin;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeletePostTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_deletes_and_restores_a_post()
    {
        factory('App\Models\Post')->create([
            'title' => 'Foo',
            'slug'  => 'foo'
        ]);

        $this->browse(function ($browser) {

            $browser->visit('/admin/posts/foo/edit')
                    ->click('#delete_post')
                    ->assertSee('Post successfully deleted!')
                    ->clickLink('Foo')
                    ->click('#restore_post');
        });
    }

    /** @test */
    public function it_permanently_deletes_a_post()
    {
        factory('App\Models\Post')->create([
            'title' => 'Foo',
            'slug'  => 'foo'
        ]);

        $this->browse(function ($browser) {

            $browser->visit('/admin/posts/foo/edit')
                    ->click('#delete_post')
                    ->assertSee('Post successfully deleted!')
                    ->clickLink('Foo')
                    ->click('#permanently_delete_post')
                    ->assertSee('Post permanently deleted!');
        });
    }
}