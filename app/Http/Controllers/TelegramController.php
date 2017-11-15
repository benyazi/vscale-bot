<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function getHello() {
        $response = Telegram::getMe();
        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();
        var_dump($botId);
        var_dump($firstName);
        var_dump($username);
    }
    public function getUpdate() {
        $response = Telegram::getUpdates();
        var_dump($response);
    }
}