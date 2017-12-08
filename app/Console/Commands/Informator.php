<?php

namespace App\Console\Commands;

use App\Models\BotUsers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Vscale\Api;
use Telegram\Bot\Actions;
use Telegram\Bot\Api as TelegramApi;

class Informator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'informator:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check users balance';

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
		$users = BotUsers::query()
			->where('informator_enabled', true)
			->get();
		foreach ($users as $user) {
			$message = '';
			foreach ($user->keys()->get() as $apiKey) {
				$api = new Api($apiKey->api_key,Api::METHOD_BILLING_BALANCE);
				if (empty($apiKey->alias)) {
					$name = "....".substr($apiKey->api_key, -5);
				} else {
					$name = $apiKey->alias;
				}
				$result = json_decode($api->request()->getBody(), true);
				if($result["balance"] < $user->informator_limit) {
					$message .= sprintf('*%s* - *%s* RUB' . PHP_EOL,
						$name,
						number_format(($result["balance"]/100),2)
					);
				}
				if(!empty($message)) {
					$telegram = new TelegramApi(env('TELEGRAM_BOT_TOKEN'));
					$telegram->sendMessage([
						'chat_id' => $user->chat_id,
						'text' => $message,
						'parse_mode' => 'Markdown'
					]);
				}
			}
		}
    }
}