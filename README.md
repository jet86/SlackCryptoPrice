# SlackCryptoPrice
Crypto Price Bot for Slack, which posts price and market cap updates from [CoinMarketCap](http://coinmarketcap.com/) at regular intervals.
Originally built for the [Golem](https://golem.network/) Slack.


Example Screenshot:

![Example Screenshot](https://github.com/jet86/SlackCryptoPrice/raw/master/SlackCryptoPriceExample.png "Example Screenshot")


## Requirements
- A web server with PHP 5 and cURL installed
## Installation and Configuration
### Slack Configuration
1. In Slack, create a new [incoming webhook integration](https://my.slack.com/services/new/incoming-webhook/) and choose the chanel, label, name and icon that you want the bot to use.
2. Optionally, create a second [incoming webhook integration](https://my.slack.com/services/new/incoming-webhook/) to be used for testing any code changes you want to make to the bot (you will probably want this second webhook to post to a private group rather than a public channel).
3. Add the 3 png files as [custom emoji](https://my.slack.com/customize/emoji). Alternatively, you can use your own emoji and edit the required variables in `variables.php`.
### Web Server Configuration
1. Download the files (or do a git pull) to a directory on your webserver
2. Edit `variables.php` with the settings you require. At a minimum you will need to set the following:
* `$url_slack` - the webhook URL created above
* `$url_slack_dev` - the optional second webhook URL created above
* `$script_name`- the location of index.php on your webserver
* `$script_name_dev`- the location of dev.php on your webserver
* `$token_symbol` - the 3 or 4 letter token symbol
* `$token_api_name` - the `id` (not name) of the token used by the [CoinMarketCap API](http://coinmarketcap.com/api/)
3. Create a cron job or scheduled task to run index.php at the required interval.
## Troubleshooting
* running `index.php?mode=live` in a web browser will output the result to the browser, rather than posting it to the Slack channel
* `dev.php` is an exact copy of `index.php`. It exists so that you can edit and test the code without it affecting the scheduled posts when `index.php` is run by cron or scheduled tasks.
* If you come across any bugs, please create a new issue.
* If you have any improvements or bug fixes, feel free to submit a pull request.
* This project is licensed under the MIT license, and you are free to use it acording to the license. However, if you do wish to make a donation, you can send ETH or any ethereum based tokens to 0x3D4e1756810fa293e9Fd9B351c15A3689929F32e
