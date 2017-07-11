<?PHP
    /*
    MIT License
    
    Copyright (c) 2017 Tim Jones
    
    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.
    
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.
    */
    
    require_once('variables.php');

    function trendEmoji($trendVal)
    {
        if($trendVal > 0)
        {
            return ":" . $GLOBALS['emoji_up'] . ":";
        }
        elseif($trendVal < 0)
        {
            return ":" . $GLOBALS['emoji_down'] . ":";
        }
        else
        {
            return ":" . $GLOBALS['emoji_flat'] . ":";
        }
    }

    // ----- Get Data from APIs ----- //

    //CoinMarketCap
    $url_cmc = "https://api.coinmarketcap.com/v1/ticker/" . $token_api_name . "/?convert=ETH";
    $url_cmc_fiat_1 = "https://api.coinmarketcap.com/v1/ticker/" . $token_api_name . "/?convert=" . $fiat_1;
    $url_cmc_fiat_2 = "https://api.coinmarketcap.com/v1/ticker/" . $token_api_name . "/?convert=" . $fiat_2;
    $url_cmc_fiat_3 = "https://api.coinmarketcap.com/v1/ticker/" . $token_api_name . "/?convert=" . $fiat_3;

    //open connection
    $ch_cmc = curl_init();

    curl_setopt($ch_cmc,CURLOPT_URL, $url_cmc);
    curl_setopt($ch_cmc,CURLOPT_RETURNTRANSFER, true);
    $result_cmc = curl_exec($ch_cmc);

    curl_setopt($ch_cmc,CURLOPT_URL, $url_cmc_fiat_1);
    curl_setopt($ch_cmc,CURLOPT_RETURNTRANSFER, true);
    $result_cmc_fiat_1 = curl_exec($ch_cmc);

    curl_setopt($ch_cmc,CURLOPT_URL, $url_cmc_fiat_2);
    curl_setopt($ch_cmc,CURLOPT_RETURNTRANSFER, true);
    $result_cmc_fiat_2 = curl_exec($ch_cmc);

    curl_setopt($ch_cmc,CURLOPT_URL, $url_cmc_fiat_3);
    curl_setopt($ch_cmc,CURLOPT_RETURNTRANSFER, true);
    $result_cmc_fiat_3 = curl_exec($ch_cmc);

    //close connection
    curl_close($ch_cmc);

    $array_cmc = json_decode($result_cmc, true);
    $array_cmc_fiat_1 = json_decode($result_cmc_fiat_1, true);
    $array_cmc_fiat_2 = json_decode($result_cmc_fiat_2, true);
    $array_cmc_fiat_3 = json_decode($result_cmc_fiat_3, true);

    if($array_cmc[0]["percent_change_1h"] > 0)
    {
        $color = $colour_up;
    }
    elseif($array_cmc[0]["percent_change_1h"] < 0)
    {
        $color = $colour_down;
    }
    else
    {
        $color = $colour_flat;
    }

    if($array_cmc[0]["percent_change_24h"] > 0)
    {
        $color24 = $colour_up;
    }
    elseif($array_cmc[0]["percent_change_24h"] < 0)
    {
        $color24 = $colour_down;
    }
    else
    {
        $color24 = $colour_flat;
    }

    // ----- Create Payload ----- //

    $payload = array('attachments' => array(array(	'fallback' => "Latest $token_symbol details from <http://coinmarketcap.com/assets/$token_api_name/|CoinMarketCap>",
							'pretext' => "Latest $token_symbol details from <http://coinmarketcap.com/assets/$token_api_name/|CoinMarketCap>",
							'color' => $color,
							'fields' => array(	array(	'title' => 'USD Price',
											'value' => '$' . round($array_cmc[0]["price_usd"],4) . ' (' . sprintf("%+.2f",$array_cmc[0]["percent_change_1h"]) . '%) ' . trendEmoji($array_cmc[0]["percent_change_1h"]),
											'short' => true),
										array(	'title' => 'ETH Price',
											'value' => round($array_cmc[0]["price_eth"],6),
											'short' => true),
										array(	'title' => 'Market Cap',
											'value' => '$' . number_format($array_cmc[0]["market_cap_usd"], 0, '.', ','),
											'short' => true),
										array(	'title' => 'Market Cap',
											'value' => number_format($array_cmc[0]["market_cap_eth"], 0, '.', ','),
											'short' => true),
										array(	'title' => '24hr Volume',
											'value' => '$' . number_format($array_cmc[0]["24h_volume_usd"], 0, '.', ','),
											'short' => true),
										array(	'title' => '24hr Volume',
											'value' => number_format($array_cmc[0]["24h_volume_eth"], 0, '.', ','),
											'short' => true),
										array(	'title' => '24hr Change',
											'value' => sprintf("%+.2f",$array_cmc[0]["percent_change_24h"]) . '% ' . trendEmoji($array_cmc[0]["percent_change_24h"]),
											'short' => true),
										array(	'title' => '7 Day Change',
											'value' => sprintf("%+.2f",$array_cmc[0]["percent_change_7d"]) . '% ' . trendEmoji($array_cmc[0]["percent_change_7d"]),
											'short' => true),
										array(	'title' => "$fiat_1 Price",
											'value' => $fiat_1_prefix . round($array_cmc_fiat_1[0]["price_" . strtolower($fiat_1)],4),
											'short' => true),
										array(	'title' => "$fiat_2 Price",
											'value' => $fiat_2_prefix . round($array_cmc_fiat_2[0]["price_" . strtolower($fiat_2)],4),
											'short' => true),
										array(	'title' => "$fiat_3 Price",
											'value' => $fiat_3_prefix . round($array_cmc_fiat_3[0]["price_" . strtolower($fiat_3)],4),
											'short' => true),
										array(	'title' => 'BTC Price',
											'value' => round($array_cmc[0]["price_btc"],6),
											'short' => true)), )) );

    $jsonpayload = json_encode($payload, JSON_PRETTY_PRINT);

    if($_GET['mode'] == "live")
    { // Output result directly
        //
        echo "Live mode<br>\n<br>\n";
        echo '$_SERVER["SCRIPT_NAME"]: ' . $_SERVER['SCRIPT_NAME'] . "<br>\n<br>\n";
        echo "<pre>";
        echo $jsonpayload;
        echo "</pre>\n<br>\n<br>";
    }
    else
    { // Post to Slack
	
        //open connection
        $ch_slack = curl_init();
	
        //set the url, POST data
        if($_SERVER["SCRIPT_NAME"] == $script_name_dev)
        {
            curl_setopt($ch_slack,CURLOPT_URL, $url_slack_dev);
        }
        else
        {
            curl_setopt($ch_slack,CURLOPT_URL, $url_slack);
        }
        curl_setopt($ch_slack,CURLOPT_POSTFIELDS, $jsonpayload);
	
        //execute post
        $result_slack = curl_exec($ch_slack);
	
        //close connection
        curl_close($ch_slack);
    }
?>
