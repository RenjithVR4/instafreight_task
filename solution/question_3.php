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
* For SEO, it would conisder UPPERCASE, Propercase, CamelCase and lowercase words are same.
*/

header('Content-type: text/plain; charset=ISO-8859-1');

class ExtractKeywords
{
	private $post_content_1;
	private $post_content_2;
	private $stopwords;
	protected $words_set;
	protected $title_words_set;
	public $words_set_1;
	public $title_set_1;
	public $stopwords_set;
	public $top_words_set;

	function __construct()
	{
		$this->post_content_1 = '../post1.md';
		$this->post_content_2 = '../post2.md';
		$this->stopwords = '../stopwords.txt';
		$this->words_set = array();
		$this->words_set_1 = array();
		$this->stopwords_set = array();
		$this->top_words_set = array();
	}


	/** 
	 * Extract Keywords common function
	 * 
	 * @author   Renjith VR
	 * @access   public 
	 * @param    string, boolean
	 * @return   array
	 */
	

	public function getwords_fromfile($file, $get_titleonly=FALSE)
	{
		$file_contentset = file_get_contents($file);

		if($get_titleonly)
		{
			preg_match_all("/^#(.*)$/m",$file_contentset,$matches);

			$titles = $matches[0];

			foreach ($titles as $key => $value)
			{
				$value = strtolower(str_replace('#', '', $value));
				$contentset_words[] = preg_split('/[\s]+/', $value, -1, PREG_SPLIT_NO_EMPTY);
			}
		}
		else
		{
			$contentset_words = preg_split('/[\s]+/', strtolower($file_contentset), -1, PREG_SPLIT_NO_EMPTY);
		}
		

		return $contentset_words;
	}


	/** 
	 * Extract Keywords with stopwords
	 * 
	 * @author   Renjith VR
	 * @access   public 
	 * @param    boolean
	 * @return   array
	 */

	public function extract_top_used_words($stopwords=FALSE, $titlewords=FALSE)
	{

		$this->words_set = $this->getwords_fromfile($this->post_content_1);
		$this->words_set_1 = $this->getwords_fromfile($this->post_content_2);
		$this->stopwords_set = $this->getwords_fromfile($this->stopwords);

		foreach ($this->words_set_1 as $key => $value)
		{
			$this->words_set[] = $value;
		}


		if($stopwords)
		{
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
		}



		$count_values = array_count_values($this->words_set);
		arsort($count_values); 

		if($titlewords)
		{
			$this->title_words_set = $this->getwords_fromfile($this->post_content_1, TRUE);
			$this->title_set_1 = $this->getwords_fromfile($this->post_content_2, TRUE);

			foreach ($this->title_set_1 as $key => $value)
			{
				$this->title_words_set[] = $value;
			}

			foreach ($this->title_words_set as $key => $value)
			{
				foreach($value as $k => $val)
				{
					$title_words[] = $val; 
				}
			}
			
			foreach ($this->words_set as $wkey => $wvalue)
			{
				if(in_array($wvalue, $title_words))
				{
					foreach ($count_values as $ckey => $cvalue)
					{
						if($ckey == $wvalue)
						{
							$count_values[$ckey] = $cvalue + 1;
						}	
					}
				}
			}
		}


		$this->top_words_set = array_slice($count_values, 0, 10);
		return $this->top_words_set;

		
	}

	
}

//Extract the top 10 most used words. 
//Always work with German Alphabets.

//extract stopwords only
$stopwords = TRUE;

//count title words with double
$titlewords = TRUE;

$extractWordsObject = new ExtractKeywords();
$extract_words = $extractWordsObject->extract_top_used_words($stopwords, $titlewords);

print_r($extract_words);
 ?>