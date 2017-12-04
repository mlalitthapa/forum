<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NotificationsTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function a_notification_is_prepared_when_a_thread_receives_a_new_reply_that_is_not_by_current_user()
    {

        $this->signIn();

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
        $this->signIn();

        $thread = create(Thread::class)->subscribe();

        $user = auth()->user();

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'Reply Body'
        ]);

        $response = $this->getJson("/profile/" . $user->name . "/notifications")->json();

        $this->assertCount(1, $response);

    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {

        $this->signIn();

        $thread = create(Thread::class)->subscribe();

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'Reply Body'
        ]);

        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;

        $this->delete("/profile/" . $user->name . "/notifications/{$notificationId}");
        $this->assertCount(0, $user->fresh()->unreadNotifications);

    }

}
