<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use App\Model\Contact;

class MailToContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MailTo:Contacts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $contacts = Contact::where('is_email',1)->get();
        if(count($contacts) > 0){
            foreach($contacts as $cont){
                //return $cont->name;
                if($cont->email1 != ''){
                    $email = $cont->email1;
                }elseif($cont->email2){
                    $email = $cont->email2;
                }
                //return $email;
                if($email != ''){
                    $data = ['message' => 'Hi this is test mail on schedule','subject' => 'test email', 'name' =>'', 'unsub_link' =>''];
                    Mail::to($email)->send(new TestEmail($data));
                }

            }
        }
    }
}
