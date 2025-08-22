<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;


class LocalWeather
{
	 public function __construct()
	 {
	 	$xml = Storage::get('meteo/wx.xml');
	    $wxObject = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
	    $wxJson = json_encode($wxObject);
	    $wxArray = json_decode($wxJson, TRUE);
	    $fullArray = $wxArray['channel'] ?? [];
	    $items = $fullArray['item'] ?? [];
	    foreach ($fullArray as $k => $v) {
	    	if (!is_array($v)) {
	    		$this->$k = $v;
	    	}
	    }
	    $this->current = (object) ($items[0] ?? []);
	    $this->daily = (object) ($items[1] ?? []);
	    $this->monthly = (object) ($items[2] ?? []);
	    $this->yearly = (object) ($items[3] ?? []);

	    $this->current->description = $this->parseDescription($this->current->description);
	    $this->daily->description = $this->parseDescription($this->daily->description);
	    $this->monthly->description = $this->parseDescription($this->monthly->description);
	    $this->yearly->description = $this->parseDescription($this->yearly->description);

	 }

	 public $title;
	 public $link;
	 public $description;
	 public $language;
	 public $pubDate;
	 public $lastBuildDate;
	 public $docs;
	 public $generator;
	 public $ttl;
	 public $current;
	 public $daily;
	 public $monthly;
	 public $yearly;

	 protected function parseDescription($description) {
		$cleanedString = trim(preg_replace('/\s\s+/',"",$description));
		$cleanedArray = explode(';', $cleanedString);
		$resultArray = [];
		foreach($cleanedArray as $item) {
			$key_value = explode(': ', trim($item));
			if(!empty($key_value[0]) && !empty($key_value[1])) {
				$resultArray[trim($key_value[0])] = trim($key_value[1]);
			}
		}
		return (object) $resultArray;	
	 }
}