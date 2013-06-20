<?php

class FFXIVConnect {
   private $regions = array(
                        'na'=>'na.beta.finalfantasyxiv.com',
                        'eu'=>'eu.beta.finalfantasyxiv.com');
   private $characterbaseURL = '/lodestone/character/';
   private $linkshellbaseURL = '/lodestone/linkshell/';
   private $freecompanybaseURL = '/lodestone/freecompany/';
   private $utf8;
   private $userAgent;
   
   function __construct($userAgent, $UTF8){
      $this->userAgent = $userAgent;
      $this->utf8 = $UTF8;
   }
   
   public function getCharacter($lodestoneID, $region) {
      ini_set('user_agent', $this->userAgent);
      $url = 'http://'.$this->regions[$region].$this->characterbaseURL.$lodestoneID.'/';
      return file_get_html($url);
   }   
   
   public function getLinkshell($lodestoneID, $region, $next=null) {
      ini_set('user_agent', $this->userAgent);
      if($next){
         $url = 'http://'.$this->regions[$region].$this->linkshellbaseURL.$lodestoneID.'/';   
         $extra = str_replace($url,"", $next);
         $url = $url.$extra;
      } else {
         $url = 'http://'.$this->regions[$region].$this->linkshellbaseURL.$lodestoneID.'/';   
      }
      return file_get_html($url);
   }
   
   public function getFreeCompany($lodestoneID, $region, $next=null) {
      ini_set('user_agent', $this->userAgent);
      if($next){
         $url = 'http://'.$this->regions[$region].$this->freecompanybaseURL.$lodestoneID.'/member/';
         $extra = str_replace($url,"", $next);
         $url = $url.$extra;
      } else {
         $url = 'http://'.$this->regions[$region].$this->freecompanybaseURL.$lodestoneID.'/member/';   
      }
      return file_get_html($url);
   }
}