<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Telegram\Bot\Laravel\Facades\Telegram;

class UpdateTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update telegram data';

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
     * @return mixed
     */
    public function handle()
    {
        $webhookUrl = Config::get("telegram.webhook_url");
        $this->info('Start setuping setting');
        $this->info('Remove webhooks');
        $response = Telegram::removeWebhook();
        var_dump($response);
        $this->info('Set webhooks');
        $response = Telegram::setWebhook(['url' => $webhookUrl]);
        var_dump($response);
    }
}