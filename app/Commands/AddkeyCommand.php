<?php

namespace App\Commands;

use App\Models\UserKeys;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class AddkeyCommand extends BaseCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "addkey";

    /**
     * @var string Command Description
     */
    protected $description = "<apiKey> Add New Api Key to key list";

    /**
     * @inheritdoc
     */
    public function handle($argument)
    {
        $apiKey = trim($argument);
        if(empty($apiKey)) {
            $this->replyWithMessage(['text' => "ApiKey not be empty"]);
            return;
        }
        $message = 'You add new key '.$apiKey;
        $key = $this->user->keys()->where('api_key', $apiKey)->get()->first();
        if(empty($key)) {
            $key = new UserKeys(['api_key' => $apiKey]);
            $this->user->keys()->save($key);
        }
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage(['text' => $message]);
    }
}