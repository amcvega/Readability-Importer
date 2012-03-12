<?php

require_once ("config.php");


//Get a Request Token
$request = OAuthRequest::from_consumer_and_token($consumer, NULL, "GET", $request_token_endpoint);
$request->sign_request($sig_method, $consumer, NULL);
$response = $resty->get($request->to_url());


//assemble the callback URL and send us there
parse_str($response['body'],$tokens);
$oauth_token = $tokens['oauth_token'];
$oauth_token_secret = $tokens['oauth_token_secret'];

$callback_url = "$base_url/callback.php?key=$key&token=$oauth_token&token_secret=$oauth_token_secret&endpoint="
                    . urlencode($authorize_endpoint);

$auth_url = $authorize_endpoint . "?oauth_token=$oauth_token&oauth_callback=".urlencode($callback_url);

Header("Location: $auth_url");

?>