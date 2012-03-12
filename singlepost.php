<?php
require_once ('config.php');

if (isset($_SESSION['access_token'])){
	$access_token = unserialize($_SESSION['access_token']);

	$url = $_POST['url'];
	$folder = $_POST['folder'];


	//post the bookmark
	$access_token_req = new OAuthRequest("POST", $oauth_access_token_endpoint);		
	$req = $access_token_req->from_consumer_and_token($consumer, $access_token, "POST", "https://www.readability.com/api/rest/v1/bookmarks/");

	switch($folder){
		case "Starred":
			$req->set_parameter('favorite',1,false);
			break;

		case "Archive":
			$req->set_parameter('archive',1,false);
			break;
	}
	$req->set_parameter('url',$url,false);
	$req->set_parameter('Content-Type','application/x-www-form-urlencoded');
	$req->sign_request($sig_method,$consumer,$access_token);
	$response = $resty->post('https://www.readability.com/api/rest/v1/bookmarks/', $req->to_postdata());
	print_r($response['status']);
}

?>

