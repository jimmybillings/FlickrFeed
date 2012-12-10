<?php

class Flickr
{
 
 private $feed = "http://api.flickr.com/services/feeds/photos_public.gne?id=YOUR_FLICKR_ID&lang=en-us&format=json&nojsoncallback=1";
 private $count;
 public $photoData = array();
 
 public function __construct($number=1) 
 {		
   $this->count = $number;
   $this->loadPhotos($this->count);
 }
 
 private static function fetchUrl($url)
 {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 20);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  $retData = curl_exec($ch);
  curl_close($ch);
 
  return $retData;
 }	
 
 private function loadPhotos($num) 
 {			
  //get track album cover and info	
  $result = self::fetchUrl($this->feed);
  $data = json_decode($result);
 
  for ($i = 0; $i < $num; $i++) {
   $this->photoData['media'][$i] = $data->items[$i]->media->m;
   $this->photoData['link'][$i] = $data->items[$i]->link;
   $this->photoData['title'][$i] = $data->items[$i]->title;
  }
 }
 
 public function getPhotos() 
 { 
  return $this->photoData; 
 }
}