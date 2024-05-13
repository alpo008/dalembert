<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AirmaxClient;
use Illuminate\Support\Facades\Mail;
use App\Mail\AirmaxReminder;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending reminders';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //TODO
        $to = 'example@gmail.com';
        $cc = 'example@mail.ru';
        $airmaxClient = AirmaxClient::find(1);
        Mail::to($to)->cc($cc)->send(new AirmaxReminder($airmaxClient));
        return Command::SUCCESS;
    }
}
