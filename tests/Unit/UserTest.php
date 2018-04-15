<?php

namespace Tests\Unit;

use App\User;
use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanFetchTheirMostRecentReply()
    {
        $user = create(User::class);

        $reply = create(Reply::class, [
            'user_id' => $user->id,
            ]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    public function testAUserCanDetermineTheirAvatarPath()
    {
        $user = create(User::class);

        $this->assertEquals('/images/avatars/default.png', $user->avatar_path);

        $user->avatar_path = 'avatars/me.jpg';

        $this->assertEquals('/storage/avatars/me.jpg', $user->avatar_path);
    }
}
