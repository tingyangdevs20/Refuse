<?php

namespace App\Console\Commands;

use App\Model\Emails;
use Illuminate\Console\Command;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;

class SyncGmailThreads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncgmail:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync All Gmail Threads.';

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
        $all_emails = Emails::where('is_campaign', 0)->whereNotNull('gmail_thread_id')->whereNotNull('to')->get();

        foreach ($all_emails as $key => $email) {
            $gmails = LaravelGmail::message()
                        ->from($email->to)
                        ->all()
                        ->where('threadId', $email->gmail_thread_id);

            foreach ($gmails as $key => $mail) {
                $reply_exist = $email->replies()->where('gmail_mail_id', $mail->id)->first();

                if (!$reply_exist) {
                    $mail = $mail->load();
                    $email->replies()->create([
                        'gmail_mail_id' => $mail->id,
                        'to' => $email->from,
                        'from' => $email->to,
                        'reply' => $mail->getPlainTextBody(),
                        'system_reply' => 0,
                        'is_unread' => 1,
                        'created_at' => $mail->getDate()->setTimezone(now()->timezoneName),
                    ]);
                }
            }
        }

    }
}
