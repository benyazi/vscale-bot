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
	protected $signature = 'vscale:notify';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check users balance and sent notification';

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
			$this->info("User : " . $user->username);
			$existMessage = false;
			$message = 'You have limited balances on:' . PHP_EOL;
			foreach ($user->keys()->get() as $apiKey) {
				$this->info("Key : " . $apiKey->api_key);
				$api = new Api($apiKey->api_key,Api::METHOD_BILLING_BALANCE);
				if (empty($apiKey->alias)) {
					$name = "....".substr($apiKey->api_key, -5);
				} else {
					$name = $apiKey->alias;
				}
				$result = json_decode($api->request()->getBody(), true);
				$this->info("API result : " . print_r($result, true));
				if( (int) $result["balance"] < (int) $user->informator_limit) {
					$existMessage = true;
					$message .= sprintf('*%s* - *%s* RUB' . PHP_EOL,
						$name,
						number_format(($result["balance"]/100),2)
					);
				}
			}
			$this->info('Message: ' . $message);
			if($existMessage) {
				$telegram_token = config('telegram.bot_token');
				$telegram = new TelegramApi($telegram_token);
				$response = $telegram->sendMessage([
					'chat_id' => $user->chat_id,
					'text' => $message,
					'parse_mode' => 'Markdown'
				]);
				$this->info("Send message result : " . print_r($response, true));
			}
		}
	}
}