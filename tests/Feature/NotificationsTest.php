<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{

    use DatabaseMigrations;

    function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_thread_receives_a_new_reply_that_is_not_by_current_user()
    {

        $thread = create(Thread::class)->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $replyBody = 'Reply body';
        //each time a new reply is added to that thread
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => $replyBody
        ]);

        // a notification is prepared for the subscribers of that thread
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => $replyBody
        ]);

        // a notification is prepared for the subscribers of that thread
        $this->assertCount(1, auth()->user()->fresh()->notifications);

    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {

        create(DatabaseNotification::class);

        $this->assertCount(
            1,
            $this->getJson("/profile/" . auth()->user()->name . "/notifications")->json()
        );

    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {

        create(DatabaseNotification::class);

        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $this->delete("/profile/" . $user->name . "/notifications/{$user->unreadNotifications->first()->id}");
        $this->assertCount(0, $user->fresh()->unreadNotifications);

    }

}
