<?php

namespace Tests\Unit;

use App\Models\Thread;
use App\Notifications\ThreadWasUpdated;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ThreadTest extends TestCase
{

    use DatabaseMigrations;

    private $thread;

    /** @test */
    public function a_thread_has_many_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    function a_thread_has_a_string_uri()
    {
        $thread = create(Thread::class);
        $this->assertEquals(
            "/threads/{$thread->channel->slug}/$thread->id",
            $thread->path()
        );
    }

    /** @test */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Reply Body',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn()
            ->thread
            ->subscribe()
            ->addReply([
                'body' => 'Reply Body',
                'user_id' => 999
            ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Models\Thread');
        $this->assertInstanceOf('App\Models\Channel', $thread->channel);
    }

    /** @test */
    public function a_thread_can_be_subscribed_to()
    {

        $thread = create(Thread::class);

        $thread->subscribe($userId = 1);

        $this->assertEquals(
            1,
            $thread->subscriptions()
                ->where('user_id', $userId)
                ->count()
        );
    }

    /** @test */
    public function a_thread_can_be_unsubscribe_from()
    {

        $thread = create(Thread::class);

        $thread->subscribe($userId = 1);
        $thread->unsubscribe($userId = 1);

        $this->assertCount(
            0,
            $thread->subscriptions
        );

    }

    /** @test */
    public function it_knows_if_authenticated_user_is_subscribed()
    {

        $this->signIn();

        $thread = create(Thread::class);

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);

    }
    
    /** @test */
    public function a_user_can_check_if_authenticated_user_has_new_replies(){
        $this->signIn();

        $user = auth()->user();

        $this->assertTrue($this->thread->hasUpdatesFor($user));

        $user->read($this->thread);

        $this->assertFalse($this->thread->hasUpdatesFor($user));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }

}
