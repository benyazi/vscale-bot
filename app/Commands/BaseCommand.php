<?php

namespace App\Commands;

use App\Models\BotUsers;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class BaseCommand extends Command
{
    protected $user;

    public function make($telegram, $arguments, $update)
    {
        $chat = $update->getMessage()->getChat();
        $user = BotUsers::query()->where('chat_id',$chat->getId())->get()->first();
        if(empty($user)) {
            $user = new BotUsers();
            $user->setAttribute('chat_id',$chat->getId());
        }
        $user->setAttribute('username',$chat->getUsername());
        $user->setAttribute('first_name',$chat->getFirstName());
        $user->setAttribute('last_name',$chat->getLastName());
        $user->save();
        $this->user = $user;
        return parent::make($telegram, $arguments, $update);
    }

    public function handle($arguments)
    {
        parent::handle($arguments);
    }
}