<?php

class Character {
   
   private $lodestoneID;
   private $region;
   private $userAgent;
   private $utf8;
   private $characterData;
   
   //Character Information
   private $name;
   private $server;
   private $main_lvl;
   private $race;
   private $nameday;
   private $guardian;
   private $cityState;
   private $grandCompany;
   private $gcRank;
   private $freeCompany;
   private $stats;
   private $attributes;
   private $elements;
   private $properties;
   private $classes;
   private $gear;
   private $thumbnail;
   private $picture;
   
   function __construct($region, $userAgent, $UTF8, $lodestoneID) {      
      $this->lodestoneID = $lodestoneID;
      $this->region = strtolower($region);
      $this->userAgent = $userAgent;
      $this->utf8 = $UTF8;
      
      $ffxivConnect = new FFXIVConnect($this->userAgent, $this->utf8);
      $this->characterData = $ffxivConnect->getCharacter($this->lodestoneID, $this->region);
      if ($this->characterData !=FALSE){
         $html = $this->characterData;
         
         //Character Name
         $full_name = $html->find('div.area_footer h2.player_name_brown',0)->plaintext;
         $server = $html->find('div.area_footer h2.player_name_brown span',0)->plaintext;
         $name = str_replace(array($server),'',$full_name);
         
         //Stats
         $stats = array();
         foreach($html->find('div#param_power_area ul#power_gauge li') as $stat) {
            $stats[strtolower($stat->class)] = $stat->plaintext;
         }
         
         //Attributes
         $attributes = array();
         foreach($html->find('div.param_left_area_inner div.param_left_area_inner_l ul.param_list_attributes li') as $attribute) {
            $attributes[strtolower($attribute->class)] = $attribute->plaintext;
         }
         
         //Elements
         $elements = array();
         foreach($html->find('div.param_left_area_inner div.param_left_area_inner_r ul.param_list_elemental li') as $element) {
            $value = $element->find('span.val',0)->plaintext;
            
            $elements[strtolower(trim(str_replace("clearfix","",$element->class)))] = $value;
         }
         
         //Properties
         $properties = array();
         foreach($html->find('div.param_left_area_inner ul.param_list li') as $property) {
            $properties[strtolower($property->find('span.left',0)->plaintext)] = $property->find('span.right',0)->plaintext;
         }
         
         //Classes
         $classes = array();
         
         foreach($html->find('div.base_inner div table.class_list tbody tr') as $class) {
            $classes[strtolower($class->find('td',0)->plaintext)] = array("icon" => $class->find('td img',0),
                                                                          "lvl"  => $class->find('td',1)->plaintext,
                                                                          "exp"  => $class->find('td',2)->plaintext);
            if($class->find('td',3)->innertext != ""){
               $classes[strtolower($class->find('td',0)->plaintext)] = array("icon" => $class->find('td img',1),
                                                                             "lvl"  => $class->find('td',4)->plaintext,
                                                                             "exp"  => $class->find('td',5)->plaintext);
            }
         }
         
         //Gear
         $gear = array();
         foreach($html->find('div.param_right_area div#chara_img_area div.icon_area div.ic_reflection_box') as $item) {
            foreach($item->find('div.item_detail_box div.popup_w412_header_gold div.popup_w412_footer_gold div.popup_w412_body_gold') as $gear_details){
               $gear[] = array("icon"   =>$item->find('img.ic_reflection',0),
                               "name"   =>$gear_details->find('div div.name_area h2.item_name',0)->plaintext,
                               "data"   =>$gear_details,
                        );
            }
         }
         
         if($html->find('ul.chara_profile_list li strong',3)->plaintext!= ""){
            $GC = explode("/", $html->find('ul.chara_profile_list li strong',3)->plaintext);   
         }
         
         $this->name          = $name;
         $this->server        = str_replace(array("(",")"), "", $server);
         $this->main_lvl      = $html->find('div#param_class_info_area div#class_info div.level',0)->plaintext;
         $this->race          = $html->find('div.area_footer div.chara_profile_title',0)->plaintext;
         $this->nameday       = $html->find('ul.chara_profile_list li strong',0)->plaintext;
         $this->guardian      = $html->find('ul.chara_profile_list li strong',1)->plaintext;
         $this->cityState     = $html->find('ul.chara_profile_list li strong',2)->plaintext;
         
         $this->grandCompany  = $GC[0];
         $this->gcRank        = $GC[1];
         $this->freeCompany   = $html->find('ul.chara_profile_list li strong',4)->plaintext;
         $this->thumbnail     = $html->find('div.area_footer div.thumb_cont_black_40 img',0);
         $this->picture       = $html->find('div.param_right_area div#chara_img_area div.img_area img',0);
         $this->stats         = $stats;
         $this->attributes    = $attributes;
         $this->elements      = $elements;
         $this->properties    = $properties;
         $this->classes       = $classes;         
         $this->gear          = $gear;
      } else {
         return FALSE;
      }
      return TRUE;
   }
   
   public function getThumbnail(){
      return $this->thumbnail;
   }
   public function getPicture(){
      return $this->picture;
   }
   
   public function getName(){
      return $this->name;
   }
   
   public function getServer(){
      return $this->server;
   }
   
   public function getMainLvL(){
      return $this->main_lvl;
   }
   
   public function getRace(){
      return $this->race;
   }
   
   public function getNameDay(){
      return $this->nameday;
   }
   
   public function getGuardian(){
      return $this->guardian;
   }
   
   public function getCityState(){
      return $this->cityState;
   }
   
   public function getGrandCompany(){
      return $this->grandCompany;
   }
   
   public function getGCRank(){
      return $this->gcRank;
   }
   
   public function getFreeCompany(){
      return $this->freeCompany;
   }
   
   public function getStats(){
      return $this->stats;
   }
   
   public function getAttributes(){
      return $this->attributes;
   }
   
   public function getElements(){
      return $this->elements;
   }
   
   public function getProperties(){
      return $this->properties;
   }
   
   public function getClasses(){
      return $this->classes;
   }
   
   public function getGear(){
      return $this->gear;
   }   
}
