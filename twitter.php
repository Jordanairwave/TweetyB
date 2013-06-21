<?php
$oauth_hash = '';
$oauth_hash .= 'count=1'; //Number of Tweets you want
$oauth_hash .= '&';
$oauth_hash .= 'oauth_consumer_key=YOUR_CONSUMER_KEY';
$oauth_hash .= '&';
$oauth_hash .= 'oauth_nonce=' . time() . '&';
$oauth_hash .= 'oauth_signature_method=HMAC-SHA1&';
$oauth_hash .= 'oauth_timestamp=' . time() . '&';
$oauth_hash .= 'oauth_token=YOUR_ACCESS_TOKEN';
$oauth_hash .= '&';
$oauth_hash .= 'oauth_version=1.0';
$oauth_hash .= '&';
$oauth_hash .= 'screen_name=SCREEN_NAME';

$base = '';
$base .= 'GET';
$base .= '&';
$base .= rawurlencode('https://api.twitter.com/1.1/statuses/user_timeline.json');
$base .= '&';
$base .= rawurlencode($oauth_hash);

$key = '';
$key .= rawurlencode('YOUR_CONSUMER_SECRET');
$key .= '&';
$key .= rawurlencode('YOUR_ACCESS_TOKEN_SECRET');

$signature = base64_encode(hash_hmac('sha1', $base, $key, true));
$signature = rawurlencode($signature);

$oauth_header = '';
$oauth_header .= 'count="1", ';  //Number of Tweets you want
$oauth_header .= 'oauth_consumer_key="YOUR_CONSUMER_KEY", ';
$oauth_header .= 'oauth_nonce="' . time() . '", ';
$oauth_header .= 'oauth_signature="' . $signature . '", ';
$oauth_header .= 'oauth_signature_method="HMAC-SHA1", ';
$oauth_header .= 'oauth_timestamp="' . time() . '", ';
$oauth_header .= 'oauth_token="YOUR_ACCESS_TOKEN", ';
$oauth_header .= 'oauth_version="1.0", ';
$oauth_header .= 'screen_name="SCREEN_NAME"';

$curl_header = array("Authorization: Oauth {$oauth_header}", 'Expect:');

$curl_request = curl_init();
curl_setopt($curl_request, CURLOPT_HTTPHEADER, $curl_header);
curl_setopt($curl_request, CURLOPT_HEADER, false);
curl_setopt($curl_request, CURLOPT_URL, 'https://api.twitter.com/1.1/statuses/user_timeline.json?count=1&screen_name=SCREEN_NAME'); //Number of Tweets you want and screenname
curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($curl_request);
$response = json_decode($response);

curl_close($curl_request);



function linkable($text = ''){
    $text = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $text));
    $data = '';
    foreach( explode(' ', $text) as $str){
        if (preg_match('#^http?#i', trim($str)) || preg_match('#^www.?#i', trim($str))) {
            $data .= '<a href="'.$str.'">'.$str.'</a> ';
        } else {
            $data .= $str .' ';
        }
    }
    return trim($data);
}

function twitter_time($a) { 
    //get current timestampt 
    $b = strtotime("now"); 
    //get timestamp when tweet created 
    $c = strtotime($a); 
    //get difference 
    $d = $b - $c; 
    //calculate different time values 
    $minute = 60; 
    $hour = $minute * 60; 
    $day = $hour * 24; 
    $week = $day * 7; 
    
    if(is_numeric($d) && $d > 0) { 
        //if less then 3 seconds 
        if($d < 3) return "right now"; 
        //if less then minute 
        if($d < $minute) return floor($d) . " seconds ago"; 
        //if less then 2 minutes 
        if($d < $minute * 2) return "about 1 minute ago"; 
        //if less then hour 
        if($d < $hour) return floor($d / $minute) . " minutes ago"; 
        //if less then 2 hours 
        if($d < $hour * 2) return "about 1 hour ago"; 
        //if less then day 
        if($d < $day) return floor($d / $hour) . " hours ago"; 
        //if more then day, but less then 2 days 
        if($d > $day && $d < $day * 2) return "yesterday"; 
        //if less then year 
        if($d < $day * 365) return floor($d / $day) . " days ago"; 
        //else return more than a year 
        return "over a year ago"; 
    } 
}

?>