<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guests_cannot_create_new_threads()
    {
        $this->withExceptionHandling();

        $this->post('/threads', [])
            ->assertRedirect('login');

        $this->get('threads/create')
            ->assertRedirect('login');
    }

    /** @test */
    function an_authenticated_user_can_create_new_threads()
    {
        $this->signIn();

        $thread = make(Thread::class);
        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /**
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function publishThread($overrides = [])
    {
        $this->withExceptionHandling()
            ->signIn();

        $thread = make(Thread::class, $overrides);
        return $this->post('/threads', $thread->toArray());
    }

    /** @test */
    function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_a_valid_channel()
    {
        factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

}
