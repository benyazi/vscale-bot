<?php

namespace App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class RemovekeyCommand extends BaseCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "removekey";

    /**
     * @var string Command Description
     */
    protected $description = "Remove exist api-key from key's list";

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
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $message = 'You remove key '.$apiKey;
        $key = $this->user->keys()->where('api_key', $apiKey)->get()->first();
        if($key) {
            $key->remove();
        } else {
            $message = 'Key <'.$apiKey.'> not found.';
        }
        $this->replyWithMessage(['text' => $message]);
    }
}