	<?php
	chdir('./includes/');
	$imageURL = "http://tsuts.tskoli.is/2t/1803982879/vef2a3u/myndavefur/img/large/1092054380_6040129664.jpg";
	// This sample uses the HTTP_Request2 package. (for more information: http://pear.php.net/package/HTTP_Request2)
	require_once 'HTTP/Request2.php';
	$headers = array(
	   'Content-Type' => 'application/json',
	);
	
	$query_params = array(
	   // Specify your subscription key
	   'subscription-key' => 'f2967b0e51bc4c848838814ae877780e',
	   // Specify values for optional parameters, as needed
	   'visualFeatures' => 'Categories, Description',
	);
	
	$request = new Http_Request2('https://api.projectoxford.ai/vision/v1/analyses');
	$request->setMethod(HTTP_Request2::METHOD_POST);
	// Basic Authorization Sample
	// $request-setAuth('{username}', '{password}');
	$request->setHeader($headers);
	
	$url = $request->getUrl();
	$url->setQueryVariables($query_params);
	$request->setBody("{'Url':'{$imageURL}'}");
	
	try
	{
	   $response = $request->send();
	   
	   echo $response->getBody();
	}
	catch (HttpException $ex)
	{
	   echo $ex;
	}
	
	?>