<?php

namespace App\Commands;

use App\Models\UserKeys;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class AliasCommand extends BaseCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "alias";

    /**
     * @var string Command Description
     */
    protected $description = "<apiKey> <alias> Add short Alias to exist Api Key";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $argArray = explode(" ",$arguments);
        $apiKey = trim($argArray[0]);
        $alias = trim($argArray[1]);
        if(empty($apiKey) || empty($alias)) {
            $this->replyWithMessage(['text' => "Parameters not be empty, use /alias <apiKey> <alias>"]);
            return;
        }
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $message = 'You adding new alias to key '.$apiKey;
        $key = $this->user->keys()->where('api_key', $apiKey)->get()->first();
        if(empty($key)) {
            $this->replyWithMessage(['text' => "This ApiKey not exist, before use /addkey <apiKey>"]);
            return;
        }
        $key->alias = $alias;
        if($key->save()) {
            $message .= PHP_EOL."You alias added successfully";
        } else {
            $message .= PHP_EOL."You alias not added, check your parameters";
        }
        $this->replyWithMessage(['text' => $message]);
    }
}