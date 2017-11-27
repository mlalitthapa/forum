<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    function unauthenticated_users_cannot_add_replies()
    {
        $this->withExceptionHandling()
            ->post('threads/channel/1/replies', [])
            ->assertRedirect('login');
    }

    /** @test */
    function an_authenticated_user_may_participate_in_thread()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class);
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /** @test */
    function a_reply_requires_a_body(){

        $this->withExceptionHandling()
            ->signIn();

        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');

    }
    
    /** @test */
    function unauthorized_users_cannot_delete_replies(){

        $this->withExceptionHandling();
        $reply = create(Reply::class);

        $this->delete('/replies/' . $reply->id)
            ->assertRedirect('login');

        $this->signIn()
            ->delete('/replies/' . $reply->id)
            ->assertStatus(403);

    }

    /** @test */
    function authorized_users_can_delete_replies(){

        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete("/replies/$reply->id")->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);

    }

    /** @test */
    function authorized_users_can_update_replies(){
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $updatedReply = 'This reply is updated';
        $this->patch('/replies/' . $reply->id, [
            'body' => $updatedReply
        ]);

        $this->assertDatabaseHas('replies', [
            'id' => $reply->id,
            'body' => $updatedReply
        ]);
    }

    /** @test */
    function unauthorized_users_cannot_update_replies(){

        $this->withExceptionHandling();
        $reply = create(Reply::class);

        $this->patch('/replies/' . $reply->id)
            ->assertRedirect('login');

        $this->signIn()
            ->patch('/replies/' . $reply->id)
            ->assertStatus(403);

    }
    
}
