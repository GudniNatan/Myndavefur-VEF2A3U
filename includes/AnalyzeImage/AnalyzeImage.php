<?php
	/**
	* Guðni Natan Gunnarsson
	*/
	class AnalyzeImage
	{
		private $ImageURL;

		function __construct($imageURL)
		{
			if(!empty($imageURL)){

				$this->ImageURL = $imageURL;
			}
			else{
				throw new Exception("No URL specified");
			}
		}
		public function Analyze(){
			$imageURL = $this->ImageURL;
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
			   
			   return $response->getBody();
			}
			catch (HttpException $ex)
			{
			   return false;
			}
		}
	}