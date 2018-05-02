<?php

namespace Tests\Unit;

use App\Thread;
use Tests\TestCase;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    public function testAThreadHasAPath()
    {
        $thread = create('App\Thread');

        $this->assertEquals(
            "/threads/{$thread->channel->slug}/{$thread->slug}",
            $thread->path()
        );
    }

    public function testItHasACreator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    public function testItHasReplies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function testItCanAddAReply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function testAThreadNotifiesAllRegisteredSubscribedWhenAReplyIsAdded()
    {
        Notification::fake();

        $this->signIn()
            ->thread
            ->subscribe()
            ->addReply([
                'body' => 'Foobar',
                'user_id' => 999
            ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    public function testAThreadBelongsToAChannel()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    public function testAThreadCanBeSubscribedTo()
    {
        // Given we have a thread

        $thread = create(Thread::class);

        // And an authenticated user

        // $this->signIn();

        // When the user subscribes to the thread
        $thread->subscribe($userId = 1);

        // Then we should be able to fetch all the threads that the user has subscrubed to.
        $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id', $userId)->count()
        );
    }

    public function testAThreadCanBeUnsubscribedFrom()
    {
        $thread = create(Thread::class);

        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

        $this->assertCount(0, $thread->subscriptions);
    }

    public function testItKnowsIfTheAuthenticatedUsedIsSubscribedToIt()
    {
        $thread = create(Thread::class);

        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }

    public function testAThreadCanCheckIfTheAuthenticatedUserHasReadAllReplies()
    {
        $this->signIn();

        $thread = create(Thread::class);

        tap(auth()->user(), function ($user) use ($thread) {
            $this->assertTrue($thread->hasUpdatesFor($user));

            // Simulate that the user visited the thread

            $user->read($thread);

            $this->assertFalse($thread->hasUpdatesFor($user));
        });
    }

    public function testAThreadsBodyIsSanitizedAutomatically()
    {
        $thread = make(Thread::class, ['body' => '<script>alert("bad")</script><p>This is okay</p>']);

        $this->assertEquals('<p>This is okay</p>', $thread->body);
    }
}
