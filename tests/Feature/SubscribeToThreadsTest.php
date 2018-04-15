<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreads extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanSubscribeToThreads()
    {
        // Given we have a user...
        $this->signIn();

        // And a thread...
        $thread = create(Thread::class);

        // And the user subscribes to the thread...
        $this->post($thread->path() . '/subscriptions');

        $this->assertCount(1, $thread->subscriptions);
    }

    public function testAUserCanUnsubscribeFromThreads()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $thread->subscribe();

        $this->delete($thread->path() . '/subscriptions');

        $this->assertCount(0, $thread->subscriptions);
    }
}
