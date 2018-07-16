<?php 


/*********************************************************
   Author: 		Renjith VR
   Version: 	1.0
   Date:		16-Jul-2018    
   FileName: 	question_2.php
   Description:	Class to fetch news titles from a subreddit API.
**********************************************************/



/*
*
* Retrieve News from a Subreddit API.
* To get good news our customers I prefer to apply Sentiment Analysis. I had a plan to make an electron application for Ubuntu. It was a new reader application. It will daily fetch the news from different resources. There would be text-speech to read the news. So there was an option to read the only good news. I have started learning Electron, but due to the office work, I didn't get time to implement it. So for grabbing good news, I wanted to use sentiment analysis.

*Sentiment analysis seeks to solve this problem by using natural language processing to recognize keywords within a document and thus classify the emotional status of the piece.

*http://www.memetracker.org is used Sentiment Analysis.
*
*Basic sentiment analysis algorithms use natural language processing (NLP) to classify documents as positive, neutral, or negative.

*For for this quick task, I prefer https://github.com/JWHennessey/phpInsight

*To reduce requests, From my experience 

1) Move JavaScript files from head section to footer section.
2) Reduce the number of files(css, js, images, videos). We can use CDN too.
3) Minify/Compress JavaScript and CSS files and combine CSS & JS files together for common functionalities.
4) Optimize image size.
5) Make asynchronous calls.
6) If you have APIs, create very simple APIs. Don't create complicated APIs by making complex requests.
7) Code optimizations, remove unwanted lines. Try reduce number of lines from scripts.
8) Database query optimization, If you are using RDMS, you have optimize the query.
9) Cache static and dynamic content. Also we can use some server side caching too.
10) Load balancing.
11) Optimize SSL/TLS (Session caching, Session tickets or IDs , OCSP stapling).
12) Implement HTTP/2 or SPDY.
13) Tune server OS for performance



*/

require_once __DIR__ . "/../autoload.php";

Class News
{
	protected $apiurl;
	protected $titleset;
	protected $goodtitles;

	function __construct()
	{
		$this->apiurl = "https://www.reddit.com/r/UpliftingNews/.json";
		$this->titleset = array();
	}


	/** 
	 * Process Curl Operations
	 * 
	 * @author   Renjith VR
	 * @access   public 
	 * @param    string
	 * @return   Object array
	 */

	public function process_curl($url)
	{
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

		$data = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		return $data;
	}

	/** 
	 * Get titles from the given Subreddit url
	 * 
	 * @author   Renjith VR
	 * @access   public 
	 * @param    null
	 * @return   array
	 */

	public function get_titles()
	{
		$getresponse_data = $this->process_curl($this->apiurl);

		$decodedresponse_data = json_decode($getresponse_data, TRUE);

		if($decodedresponse_data)
		{
			foreach ($decodedresponse_data["data']['children"] as $key => $value)
			{
				$this->titleset[] = $value["data"]["title"];
			}
		}

		return $this->titleset;
	}

	/** 
	 * Get good news titles from the given Subreddit url
	 * 
	 * @author   Renjith VR
	 * @access   public 
	 * @param    null
	 * @return   array
	 */

	//It has three dominant classes, Positive(pos), Neutral(neu) and Negative(neg) with corresponding scores. We are checkng for the positive results.

	public function get_good_news_titles()
	{
		$sentiment = new \PHPInsight\Sentiment();
		$titles = $this->get_titles();

		foreach ($titles as $title)
		{
			// sentiment anaysis calculations:
			$scores = $sentiment->score($title);
			$class = $sentiment->categorise($title);

			if($class == 'pos')
			{
				$this->$goodtitles[] = $title;
			}
		}

		return $this->$goodtitles;
	}

}



$getnews = new News();
$news = $getnews->get_good_news_titles();

print_r($news);
 ?>