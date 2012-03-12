<?php

require_once ("config.php");

//We were passed these through the callback.
$token = $_REQUEST['token'];
$token_secret = $_REQUEST['token_secret'];

$auth_token = new OAuthConsumer($token, $token_secret);
$access_token_req = new OAuthRequest("GET", $oauth_access_token_endpoint);
$access_token_req = $access_token_req->from_consumer_and_token($consumer, $auth_token, "GET", $oauth_access_token_endpoint);
$access_token_req->set_parameter('oauth_verifier',$_REQUEST['oauth_verifier']);
$access_token_req->sign_request($sig_method, $consumer, $auth_token);
$response = $resty->get($access_token_req->to_url());
parse_str($response['body'],$access_tokens);

$access_token = new OAuthConsumer($access_tokens['oauth_token'], $access_tokens['oauth_token_secret']);

$_SESSION['access_token'] = serialize($access_token);


?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Import to Readability</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/libs/modernizr-2.5.3.min.js"></script>
</head>
<body>
	<div id="container">
	    <div role="main">
			<p>Log on to your Instapaper account, and look for Export CSV on the right side. Click Download CSV.</p>
			<p>Upload that file here.</p>
			<form enctype="multipart/form-data" action="upload.php" method="POST">
				<input type="file" name="uploadfile" />
				<input type="submit" value="Upload" />
			</form>
		</div>
	</div>
</body>
</html>