<?php
	session_start();
	require_once ("libs/OAuth/OAuth.php");
	require_once ("libs/Resty/Resty.php");
	$resty = new Resty();

	$key = '';//<your app's API key>
	$secret = '';//<your app's secret>

	$base_url = "http://example.com";//<url where this is uploaded for callback purposes>

	$request_token_endpoint = 'https://www.readability.com/api/rest/v1/oauth/request_token/';
	$oauth_access_token_endpoint = 'https://www.readability.com/api/rest/v1/oauth/access_token/';
	$authorize_endpoint = 'https://www.readability.com/api/rest/v1/oauth/authorize/';

	$consumer = new OAuthConsumer($key, $secret, NULL);
	$sig_method = new OAuthSignatureMethod_HMAC_SHA1();	
?>