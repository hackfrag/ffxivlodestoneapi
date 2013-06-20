<?php

class Linkshell {
   private $lodestoneID;
   private $region;
   private $userAgent;
   private $utf8;
   private $linkshellData;
   
   //Linkshell Information
   private $name;
   private $size;
   private $members;
   
   function __construct($region, $userAgent, $UTF8, $lodestoneID) {      
      $this->lodestoneID = $lodestoneID;
      $this->region = strtolower($region);
      $this->userAgent = $userAgent;
      $this->utf8 = $UTF8;
      
      $ffxivConnect = new FFXIVConnect($this->userAgent, $this->utf8);
      $this->linkshellData = $ffxivConnect->getLinkshell($this->lodestoneID, $this->region);
      if ($this->linkshellData !=FALSE){
         $html = $this->linkshellData;
         
         $this->name    = $html->find('div.area_footer h2.player_name_brown',0)->plaintext;
         $this->size    = str_replace(array("Members ([","] Total)"), "", $html->find('div.area_footer div.clearfix div.select_index_left h3',0)->plaintext);
         $this->buildMembers();
      } else {
         return FALSE;
      }
      return TRUE;
   }
   
   private function buildMembers(){
      $html = $this->linkshellData;
      $old_members = $this->members;
      
      $members = array();
      foreach($html->find('div.base_footer div.base_body div.base_inner div.area_inner_header div.area_inner_footer div.area_inner_body div.table_black_border_bottom table tbody tr') as $member_row) {
         $member = array();
         
         $link = $member_row->find('td div.player_name_area h4.player_name_gold a',0)->attr["href"];
         
         if($member_row->find('td div.col3box div.col3box_center div',1)->plaintext != ""){
            $GC = explode("/", $member_row->find('td div.col3box div.col3box_center div',1)->plaintext);   
         }
         
         if($rank = $member_row->find('td div.player_name_area span.ic_master',0)->class == "ic_master"){
            $rank = "Master";
         } elseif($rank = $member_row->find('td div.player_name_area span.ic_leader',0)->class == "ic_leader"){
            $rank = "Leader";
         } else {
            $rank = "Member";
         }
         
         $member["rank"]            = $rank;
         $member["id"]              = str_replace("/","",str_replace("/lodestone/character","",$link));
         $member["icon"]            = $member_row->find('th div img',0);
         $member["name"]            = $member_row->find('td div.player_name_area h4.player_name_gold a',0)->plaintext;
         $member["link"]            = $link;
         $member["server"]          = str_replace(array("(",")"), "", $member_row->find('td div.player_name_area h4.player_name_gold span',0)->plaintext);
         
         $member["GC"]["icon"]      = $member_row->find('td div.col3box div.col3box_center div img',0);
         $member["GC"]["name"]      = $GC[0];
         $member["GC"]["rank"]      = $GC[1];
         
         $member["FC"]["icon"]      = $member_row->find('td div.col3box div.col3box_right div img',0);
         $member["FC"]["name"]      = $member_row->find('td div.col3box div.col3box_right div',1)->plaintext;
         
         $member["class"]["icon"]   = $member_row->find('td div.col3box div.col3box_left div img',0);
         $member["class"]["level"]  = $member_row->find('td div.col3box div.col3box_left div',1)->plaintext;
         
         $members[] = $member;
      }
      
      $this->members = array_merge($old_members, $members);
      $this->getNext();
   }
   
   
   private function getNext() {
      if($next = $this->linkshellData->find('div.base_footer div.base_body div.base_inner div.mb10 div.pager div.pagination ul li.next a',0)->href) {
         $ffxivConnect = new FFXIVConnect($this->userAgent, $this->utf8);
         $this->linkshellData = $ffxivConnect->getLinkshell($this->lodestoneID, $this->region, $next);
         $this->buildMembers();
      }
      return FALSE;
   }
   
   public function getName(){
      return $this->name;
   }
   
   public function getSize(){
      return $this->size;
   }
   
   public function getMembers(){
      return $this->members;
   }   
}