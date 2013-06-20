<?php
/**
 * Master class for the FFXIV:ARR Lodestone API
 * @author Jurmarcus Allen <methylenebl@gmail.com>
 * @copyright Copyright (c) 2013, Jurmarcus Allen <Methylene>, https://github.com/MethyleneBL/ffxivlodestoneapi
 * @version 3.5.1
 */
require_once('./vendors/simplehtml/simple_html_dom.php');
require_once('FFXIVConnect.class.php');
require_once('Character.class.php');
require_once('Linkshell.class.php');
require_once('FreeCompany.class.php');

class Lodestone {
   private $region;
   private $utf8;
   private $userAgent;
   
   /**
    * Contruct the Lodestone API
    * @param String $region Can be NA/EU etc.
    * @return void
    */
   function __construct($region) {
      $this->region = strtolower($region);
      $this->utf8 = TRUE;
      $this->userAgent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1468.0 Safari/537.36";
   }
   
   /**
    * Switch the region.
    * @param String $newRegion Can be NA/EU etc.
    * @return void
    */
   public function setRegion($newRegion){
      $this->region = strtolower($newRegion);
   }

   public function setUserAgent($newUserAgent){
      $this->userAgent = $newUserAgent;
   }

   /**
    * Turn on/off UTF8
    * @param $enabled
    * @return void
    */
   public function setUTF8($enabled=TRUE){
      $this->utf8 = $enabled;
   }

   /**
    * Retrieve a Character from Lodestone - Returns a character object
    * @param String $character_id Lodestone ID of the Character
    * @return object $character The character object from the character class.
    */
   public function getCharacter($characterID) {
      $character = new Character($this->region, $this->userAgent, $this->utf8, $characterID);
      return $character;
   }
   
   /**
    * Retrieve a Linkshell from Lodestone - Returns a linkshell object
    * @param String $linkshell_id Lodestone ID of the Linkshell
    * @return object $linkshell The linkshell object from the linkshell class.
    */
   public function getLinkshell($linkshellID) {
      $linkshell = new Linkshell($this->region, $this->userAgent, $this->utf8, $linkshellID);
      return $linkshell;
   }
   
   /**
    * Retrieve a Free Company from Lodestone - Returns a freecompany object
    * @param String $freecompany_id Lodestone ID of the Character
    * @return object $freecompany The freecompany object from the freecompany class.
    */
   public function getFreeCompany($freecompanyID) {
      $freecompany = new FreeCompany($this->region, $this->userAgent, $this->utf8, $freecompanyID);
      return $freecompany;
   }
}