<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestsCannotFavoriteAnyReply()
    {
        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('login');
    }

    public function testAnAuthenticatedUserCanFavoriteAnyReply()
    {
        $this->signIn();

        $reply = create('App\Reply');
        $this->post('replies/' . $reply->id . '/favorites');
        $this->assertCount(1, $reply->favorites);
    }

    public function testAnAuthenticatedUserCanUnfavoriteAReply()
    {
        $this->signIn();

        $reply = create('App\Reply');
        $reply->favorite();
        // $this->post('replies/' . $reply->id . '/favorites');
        // $this->assertCount(1, $reply->favorites);
        $this->delete('replies/' . $reply->id . '/favorites');
        $this->assertCount(0, $reply->favorites);
    }

    public function testAnAuthenticatedUsedMayOnlyFavoriteAReplyOnce()
    {
        $this->signIn();

        $reply = create('App\Reply');

        try {
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
