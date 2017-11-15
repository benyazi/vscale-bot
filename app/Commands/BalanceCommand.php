<?php

namespace App\Commands;

use App\Vscale\Api;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class BalanceCommand extends BaseCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "balance";

    /**
     * @var string Command Description
     */
    protected $description = "Balance Command to get you balance info";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $this->replyWithMessage(['text' => 'Balance to your accounts:']);
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $response = '';
        $tariffs = false;
        foreach ($this->user->keys()->get() as $key) {
            if(!$tariffs) {
                $tariffs = $this->getRequestApi($key->api_key,Api::METHOD_BILLING_PRICES);;
            }
            $balance = $this->getRequestApi($key->api_key,Api::METHOD_BILLING_BALANCE);
            if (empty($key->alias)) {
                $name = "....".substr($key->api_key, -5);
            } else {
                $name = $key->alias;
            }
            $servers = $this->getRequestApi($key->api_key,Api::METHOD_SCARLETS);;
            $totalCost = 0;
            if(empty($servers)) {
                continue;
            }
            foreach ($servers as $server) {
                $rplan = $server["rplan"];
                $totalCost += $tariffs["default"][$rplan]["hour"];
            }
            $hours = 0;
            if($totalCost) {
                $hours = $balance["balance"]/$totalCost;
            }
            $days = number_format(($hours/24),2);
            if($balance["balance"]<10000) {
                $name = '*'.$name.'*';
            }
            $response .= sprintf('*%s* - *%s* RUB - Servers count: %d - Enough for *%s days*' . PHP_EOL,
                $name,
                number_format(($balance["balance"]/100),2),
                count($servers),
                $days
            );
        }
        $this->replyWithMessage(['text' => $response, 'parse_mode' => 'Markdown']);
    }

    private function getRequestApi($token, $method) {
        $api = new Api($token,$method);
        return json_decode($api->request()->getBody(), true);
    }
}