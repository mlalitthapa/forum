<?php

namespace Tests\Feature;

use App\Models\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{

    use DatabaseMigrations;
    
    /** @test */
    function guests_cannot_favorite_anything(){
        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_favorite_any_reply(){

        $this->signIn();

        $reply = create(Reply::class);

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);

    }

    /** @test */
    function an_authenticated_user_can_favorite_a_reply_only_once(){
        $this->signIn();

        $reply = create(Reply::class);

        $this->post('replies/' . $reply->id . '/favorites');
        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }
    
}
