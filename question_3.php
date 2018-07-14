<?php 

/*********************************************************
   Author: 		Renjith VR
   Version: 	1.0
   Date:		13-Jul-2018    
   FileName: 	question_3.php
   Description:	Class to extract keywords from files.
**********************************************************/



/**
* Class to read file and extract words.
*/

class ExtractKeywords
{
	private $post_content_1;
	private $post_content_2;
	private $stopwords;
	protected $words_set;
	public $words_set_1;
	public $stopwords_set;
	public $top_words_set;

	function __construct()
	{
		$this->post_content_1 = 'post1.md';
		$this->post_content_2 = 'post2.md';
		$this->stopwords = 'stopwords.txt';
		$this->words_set = array();
		$this->words_set_1 = array();
		$this->stopwords_set = array();
		$this->top_words_set = array();
	}


	/** 
	 * Extract Keywords common function
	 * 
	 * @author   Renjith VR
	 * @acces    public 
	 * @param    string
	 * @return   array
	 */
	

	public function getwords_fromfile($file)
	{
		$file_contentset = file_get_contents($file);
		$contentset_words = preg_split('/[\s]+/', $file_contentset, -1, PREG_SPLIT_NO_EMPTY);

		return $contentset_words;
	}


	/** 
	 * Extract Keywords with stopwords
	 * 
	 * @author   Renjith VR
	 * @acces    public 
	 * @param    null
	 * @return   array
	 */

	public function extract_with_stopwords()
	{
		$this->words_set = $this->getwords_fromfile($this->post_content_1);
		$this->words_set_1 = $this->getwords_fromfile($this->post_content_2);
		$this->stopwords_set = $this->getwords_fromfile($this->stopwords);

		foreach ($this->words_set_1 as $key => $value)
		{
			$this->words_set[] = $value;
		}

		foreach ($this->words_set as $wkey => $wvalue)
		{
			foreach ($this->stopwords_set as $skey => $svalue)
			{
				if(strtolower($wvalue) == strtolower($svalue))
				{
					unset($this->words_set[$wkey]);
				}
			}
		}

		$count_values = array_count_values($this->words_set);
		arsort($count_values); 
   
		$this->top_words_set = array_slice($count_values, 0, 10);

		return $this->top_words_set;
	}

	/** 
	 * Extract Keywords with title words. 
	 * Extract words after working with stop words.
	 * 
	 * @author   Renjith VR
	 * @acces    public 
	 * @param    null
	 * @return   array
	 */

	public function extract_with_titlewords()
	{
		$words = $this->extract_with_stopwords();

		print_r($this->words_set);

	}
	

	
}


$words = new ExtractKeywords();
$e_words = $words->extract_with_titlewords();

// print_r($e_words);
 ?>