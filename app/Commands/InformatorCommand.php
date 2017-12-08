<?php

namespace App\Commands;

use App\Vscale\Api;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class InformatorCommand extends BaseCommand
{
	const LIMIT_DEFAULT = 30000;
    /**
     * @var string Command Name
     */
    protected $name = "informator";

    /**
     * @var string Command Description
     */
    protected $description = "Informator Command to configurate auto notification";

    /**
     * @inheritdoc
     */
    public function handle($argument)
    {
		$action = trim($argument);
		$this->replyWithChatAction(['action' => Actions::TYPING]);
		switch ($action) {
			case 'enabled':
				$this->enabledAutoInformation();
				$this->replyWithMessage(['text' => 'Enabled low balance notification', 'parse_mode' => 'Markdown']);
				break;
			case 'disabled':
				$this->disabledAutoInformation();
				$this->replyWithMessage(['text' => 'Disabled low balance notification', 'parse_mode' => 'Markdown']);
				break;
			default:
				break;
		}
    }

    private function enabledAutoInformation() {
		$this->user->informator_enabled = true;
		$this->user->save();
    }

    private function disabledAutoInformation() {
		$this->user->informator_enabled = false;
		$this->user->save();
    }

    private function settingAutoInformation() {

    }
}