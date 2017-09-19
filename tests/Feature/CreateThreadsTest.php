<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guests_cannot_create_new_threads()
    {
        $this->expectException(AuthenticationException::class);
        $thread = factory(Thread::class)->make();
        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    function an_authenticated_user_can_new_create_threads()
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->make();
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
