<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscribeToThreadTest extends TestCase
{

    use DatabaseMigrations;
    
    /** @test */
    public function a_user_can_subscribe_to_threads(){

        $this->signIn();

        // Given a thread
        $thread = create(Thread::class);

        // and a signed in user subscribes to a thread
        $this->post($thread->path() . '/subscribe');

        // each time a new reply is added to that thread
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Reply body'
        ]);

        // a notification is prepared for the subscribers of that thread

    }

}
