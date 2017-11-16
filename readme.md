## Unofficial Vscale.io telegram bot

This is simple telegram bot on Laravel framework. Bot work with [vscale.io](https://vscale.io/) - russian hosting provider.

## Install and configurate


``git clone https://github.com/benyazi/vscale-bot``

``cd ./vscale-bot``

``composer install``

``php artistan key:generate``

#### Configurate .env file. Setup DB credentials and setup bot parameters:

TELEGRAM_BOT_TOKEN - Token from your bot

TELEGRAM_WEBHOOK_URL - Url to webhook controller (HTTPS required). Sample https://site.url/telegram/webhook

And migrate database structure

``php artistan key:generate``

## Using bot

You may a try bot on telegram - [@vscale_unof_bot](https://t.me/vscale_unof_bot)

####Commands
* /start - start using bot
* /keys - view your api key's list
* /addkey APIKEY - add new key to list
* /alias APIKEY ALIAS - add alias to api key (for readability and convenience)
* /removekey APIKEY - remove key from list
* /balance - view current balance in your accounts

## License

Open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
