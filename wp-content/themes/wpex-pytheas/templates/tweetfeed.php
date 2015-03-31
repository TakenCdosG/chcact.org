<?php

require_once('TwitterAPIExchange.php');
 
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "130830626-AYTTVSCtfKRSEJDuepR3mpNMkp4jBmnx5JrFTBig",
    'oauth_access_token_secret' => "DkeBBScTyQNceEDPBhMDVEiwEuzZhlN0Kqfiw7CIcWIif",
    'consumer_key' => "IbOGP1sx6KNBgyHBnhQ",
    'consumer_secret' => "F4sAWUcu4gSWFNW1cpcgGXP0QjSuC5zTvaC0JVmtkwE"
);

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
if (isset($_GET['user']))  {$user = $_GET['user'];}  else {$user  = "CTHealthCenters";}
if (isset($_GET['count'])) {$user = $_GET['count'];} else {$count = 2;}
$getfield = "?screen_name=$user&count=$count";
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
/*echo "<pre>";
print_r($string);
echo "</pre>";*/
foreach($string as $items)
    {
        if ($items['retweeted_status']==""){
            echo "<strong>". $items['user']['name']."</strong> @".$items['user']['screen_name']."<br />";
            echo $items['text']."<br/>";
        }
        else
        {
            echo "<strong>".$items['retweeted_status']['user']['name']."</strong> @".$items['retweeted_status']['user']['screen_name']."<br/>";       
            echo $items['retweeted_status']['text']."<br />";
            echo "Retweeted by ".$items['user']['screen_name']."<br />";
        }
        echo "<br />";
        
    }
?>
