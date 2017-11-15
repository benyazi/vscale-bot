<?php

namespace App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class KeysCommand extends BaseCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "keys";

    /**
     * @var string Command Description
     */
    protected $description = "View key's list";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $message = 'Your key\'s list: '.PHP_EOL;
        $count = 1;
        foreach ($this->user->keys()->get() as $key) {
            $title = $key->api_key;
            if(!empty($key->alias)) {
                $title = $key->alias.' - '.$key->api_key;
            }
            $message .= $count.') *'.$title.'*'.PHP_EOL;
            $count++;
        }
        $this->replyWithMessage(['text' => $message, 'parse_mode' => 'Markdown']);
    }
}