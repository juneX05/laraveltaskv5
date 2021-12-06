<?php

namespace App\Console\Commands;

use App\Jobs\NotifySubscribers;
use App\Models\Post;
use App\Notifications\NewPost;
use Illuminate\Console\Command;

class NotifySubscribersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribers:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify subscribers about new posts.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $posts = Post::getNotifiablePosts();
        if ($posts->count() === 0) {
            $this->info('There are no posts to notify.');
            return 0;
        }
        foreach ($posts as $post) {
            foreach ($post->website->subscriptions as $subscription) {
                $subscription->notify(new NewPost($post));
                $subscription->notifiedPosts()->attach($post->id);
            }
        }
        return 0;
    }
}
