<?php

namespace App\Jobs;

use App\Mail\SendSubscribersEmail;
use App\Models\UserMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = UserMail::with('user', 'post')->where('email_sent', '<>', 1);
        if ($data) {
            foreach ($data as $user_mail){
                $subscriber_email = $user_mail->user->email;
                $mailer_data = [
                    'name' => $user_mail->user->name,
                    'post_title' => $user_mail->post->title,
                ];
                $email = new SendSubscribersEmail($mailer_data);
                Mail::to($subscriber_email)->send($email);
            }
        }

    }
}
