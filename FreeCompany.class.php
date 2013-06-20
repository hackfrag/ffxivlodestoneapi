<?php

class FreeCompany {
   private $lodestoneID;
   private $region;
   private $userAgent;
   private $utf8;
   private $freeCompanyData;
   
   //Free Company Information
   private $icon;
   private $name;
   private $grandCompany;
   private $server;
   private $size;
   private $members;
   
   function __construct($region, $userAgent, $UTF8, $lodestoneID) {      
      $this->lodestoneID = $lodestoneID;
      $this->region = strtolower($region);
      $this->userAgent = $userAgent;
      $this->utf8 = $UTF8;
      
      $ffxivConnect = new FFXIVConnect($this->userAgent, $this->utf8);
      $this->freeCompanyData = $ffxivConnect->getFreeCompany($this->lodestoneID, $this->region);
      if ($this->freeCompanyData !=FALSE){
         $html = $this->freeCompanyData;
         
         $full_name = $html->find('div.base_footer div.base_body div.area_body div.area_header div.area_footer div.ic_freecompany_box div',0)->plaintext;
         $name = $html->find('div.base_footer div.base_body div.area_body div.area_header div.area_footer div.ic_freecompany_box div span a',0)->plaintext;
         $server = $html->find('div.base_footer div.base_body div.area_body div.area_header div.area_footer div.ic_freecompany_box div span',1)->plaintext;   
         $grandCompany = str_replace(array($name,$server),'',$full_name);
         
         $this->icon          = $html->find('div.base_footer div.base_body div.area_body div.area_header div.area_footer div.ic_freecompany_box img',0);
         $this->name          = $name;
         $this->grandCompany  = trim($grandCompany);
         $this->server        = str_replace(array("(",")"), "", $server);
         $this->size          = str_replace(array("Members ([","] Total)"), "", $html->find('div.area_footer div.clearfix div.select_index_left h3',0)->plaintext);
         
         $this->buildMembers();
         
      } else {
         return FALSE;
      }
      return TRUE;
   }
   
   private function buildMembers(){
      $html = $this->freeCompanyData;
      $old_members = $this->members;
      $members = array();

      foreach($html->find('div.base_footer div.base_body div.base_inner div.area_inner_header div.area_inner_footer div.area_inner_body div.table_black_border_bottom table tbody tr') as $member_row) {
         $member = array();
         $link = $member_row->find('td div.player_name_area h4.player_name_gold a',0)->attr["href"];
         
         $member["link"]            = $link;
         $member["id"]              = str_replace("/","",str_replace("/lodestone/character","",$link));
         $member["icon"]            = $member_row->find('th div img',0);
         $member["name"]            = $member_row->find('td div.player_name_area h4.player_name_gold a',0)->plaintext;
         $member["server"]          = str_replace(array("(",")"), "", $member_row->find('td div.player_name_area h4.player_name_gold span',0)->plaintext);
         $member["rankSort"]        = $member_row->find('td div.player_name_area div.fc_member_status',0)->plaintext;
         $member["lvlSort"]         = $member_row->find('td div.col2box div.col2box_left',0)->plaintext;
         
         $member["class"]["icon"]   = $member_row->find('td div.col2box div.col2box_left img',0);
         $member["class"]["lvl"]  = $member_row->find('td div.col2box div.col2box_left',0)->plaintext;
         
         $member["rank"]["icon"]    = $member_row->find('td div.player_name_area div.fc_member_status img',0);
         $member["rank"]["rank"]    = $member_row->find('td div.player_name_area div.fc_member_status',0)->plaintext;
         
         $members[] = $member;
      }
      
      if(is_array($old_members)){
         $this->members = array_merge($old_members, $members);   
      } else {
         $this->members = $members;
      }
      
      $this->getNext();
   }
   
   private function orderMembers() {
      $members = $this->members;
      $lvl = array();
      
      foreach($members as $key => $row){
         $lvl[$key] = $row['lvlSort'];
      }
      array_multisort($lvl, SORT_DESC, $members);
      
      $this->members = $members;
   }
   
   private function getNext() {
      if($next = $this->freeCompanyData->find('div.base_footer div.base_body div.base_inner div.mb10 div.pager div.pagination ul li.next a',0)) {
         $ffxivConnect = new FFXIVConnect($this->userAgent, $this->utf8);
         $this->freeCompanyData = $ffxivConnect->getFreeCompany($this->lodestoneID, $this->region, $next->href);
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
   
   public function getMembers($sort=null){
      if($sort){
         $this->orderMembers();
      }
      return $this->members;
   }
   
   public function getIcon(){
      return $this->icon;
   }   
   
   public function getGrandCompany(){
      return $this->grandCompany;
   }
   
   public function getServer(){
      return $this->server;
   }
}
