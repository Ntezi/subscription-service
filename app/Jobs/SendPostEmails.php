<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPostEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * Send emails to all subscribers about new posts.
     */
    public function handle()
    {
        $unsentPosts = Post::with('website.subscribers')
            ->where('email_sent', false)
            ->get();

        // Keep track of posts that need their email_sent status updated
        $postsToUpdate = [];

        foreach ($unsentPosts as $post) {
            $subscribers = $post->website->subscribers;

            // Only proceed if there are subscribers
            if ($subscribers->isEmpty()) {
                continue;
            }

            foreach ($subscribers as $subscriber) {
                try {
                    Mail::send('emails.post_notification', ['post' => $post], function ($message) use ($subscriber, $post) {
                        $message->to($subscriber->email)
                            ->subject("New post available: " . $post->title);
                    });
                } catch (Exception $e) {
                    Log::error("Failed to send email for post {$post->id} to subscriber {$subscriber->email}: {$e->getMessage()}");
                }
            }

            // Mark this post to update as emailed
            $postsToUpdate[] = $post->id;
        }

        // Bulk update the posts to set email_sent to true
        Post::whereIn('id', $postsToUpdate)->update(['email_sent' => true]);
    }
}
