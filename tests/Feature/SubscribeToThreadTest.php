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

        $this->assertCount(1, $thread->subscriptions);

    }

    /** @test */
    public function a_user_can_unsubscribe_from_thread(){
        $this->signIn();

        // Given a thread
        $thread = create(Thread::class);

        $thread->subscribe();

        // and a signed in user subscribes to a thread
        $this->delete($thread->path() . '/subscribe');

        $this->assertCount(0, $thread->subscriptions);
    }

}
