<?php

namespace App\Listeners;

use App\User;
use App\Events\ThreadReceivedANewReply;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  ThreadReceivedANewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedANewReply $event)
    {
        $users = User::whereIn('name', $event->reply->mentionedUsers())->get()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWereMentioned($event->reply));
            });
    }
}
