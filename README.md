# SlackCryptoPrice
Crypto Price Bot for Slack, which posts price and market cap updates from [CoinMarketCap](http://coinmarketcap.com/) at regular intervals.
## Requirements
- A web server with PHP 5 and cURL installed
## Installation and Configuration
### Slack Configuration
### Web Server Configuration
1. Download the files (or do a git pull) to a directory on your webserver
2. Edit variables.php with the settings you require. At a minimum you will need to set the following:
* `$url_slack`
* `$url_slack_dev`
* `$script_name`
* `$script_name_dev`
* `$token_symbol`
* `$token_api_name`
3. Create a cron job or scheduled task to run index.php at the required interval.
## Troubleshooting
