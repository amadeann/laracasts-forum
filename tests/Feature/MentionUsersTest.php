<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersMentionedInAReplyAreNotified()
    {
        // Given we have a signed in user JohnDOe
        $john = create(User::class, ['name' => 'JohnDoe']);

        $this->signIn($john);
        // And another user JaneDoe
        $jane = create(User::class, ['name' => 'JaneDoe']);

        // If we have a thread
        $thread = create(Thread::class);
        // And JohnDoe @mentions JaneDoe
        $reply = make(Reply::class, [
            'body' => '@JaneDoe look at this. Also, @FrankDoe',
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        // Then JaneDoe should be notified
        $this->assertCount(1, $jane->notifications);
    }

    public function testItCanFetchAllMentionedUsersStartingWithTHeGivenCharacters()
    {
        create(User::class, ['name' => 'johndoe']);
        create(User::class, ['name' => 'johndoe2']);
        create(User::class, ['name' => 'janedoe']);

        $results = $this->json('GET', '/api/users', ['name' => 'john']);

        $this->assertCount(2, $results->json());
    }
}
