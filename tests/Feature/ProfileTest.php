<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProfileTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    function a_user_has_a_profile()
    {
        $user = create(User::class);

        $this->get('/profile/' . $user->name)
            ->assertSee($user->name);
    }

    /** @test */
    function profiles_display_all_threads_created_by_associated_user(){

        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->get('/profile/' . auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }
}
