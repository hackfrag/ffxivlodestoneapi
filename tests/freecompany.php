<h2>TEST FREE COMPANY</h2>
<p>
   Free Company Name: OrderoftheBlueGarter<br>
   Free Company ID: 9233786610993070080<br>
</p>

<h2>Parser Information</h2>
<?php
   // example of how to use basic selector to retrieve HTML contents
   include('../vendors/simplehtml/simple_html_dom.php');
   
   //Custom User Agent
   $custom_User_Agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1468.0 Safari/537.36";
   ini_set('user_agent', $custom_User_Agent);

   /* example
    
      echo $html->find('',0)->plaintext;
      echo "<br>";
      
      echo $html->find('',0);
      echo "<br>";
   */
   
   $page = "http://na.beta.finalfantasyxiv.com/lodestone/freecompany/9233786610993070080/member/";
   
   getFreeCompany($page);
   
   function getFreeCompany($page) {
      // get DOM from URL or file
      $html = file_get_html($page);
      
      //Linkshell Name
      echo $html->find('div.base_footer div.base_body div.area_body div.area_header div.area_footer div.ic_freecompany_box img',0);
      echo "<br>";
      
      $full_name = $html->find('div.base_footer div.base_body div.area_body div.area_header div.area_footer div.ic_freecompany_box div',0)->plaintext;
      $name = $html->find('div.base_footer div.base_body div.area_body div.area_header div.area_footer div.ic_freecompany_box div span a',0)->plaintext;
      $server = $html->find('div.base_footer div.base_body div.area_body div.area_header div.area_footer div.ic_freecompany_box div span',1)->plaintext;   
      $free_company = str_replace(array($name,$server),'',$full_name);
      
      echo trim($free_company);
      echo "<br>";
      
      echo $name;
      echo "<br>";
      
      echo $server;
      echo "<br>";
      
      //Linkshell Size
      echo str_replace(array("Members ([","] Total)"), "", $html->find('div.area_footer div.clearfix div.select_index_left h3',0)->plaintext);
      echo "<br>";
      
      echo "<h3>MEMBERS</h3>";
      
      getMembers($html);
      
   }
   
   function getMembers($html,$next=null) {   //Members
      if($next){
         $html->clear();
         unset($html);
         
         $html = file_get_html($next);         
      }
      
      foreach($html->find('div.base_footer div.base_body div.base_inner div.area_inner_header div.area_inner_footer div.area_inner_body div.table_black_border_bottom table tbody tr') as $member_row) {
         //Member Thumbnail
         echo $member_row->find('th div img',0);
         echo "<br>";
         
         //Member Name
         $link = $member_row->find('td div.player_name_area h4.player_name_gold a',0)->attr["href"];
         $name = $member_row->find('td div.player_name_area h4.player_name_gold a',0)->plaintext;
         $server = $member_row->find('td div.player_name_area h4.player_name_gold span',0)->plaintext;
         
         echo "<a href='http://na.beta.finalfantasyxiv.com".$link."'>".$name."</a>";
         echo "<br>";
         echo $server;
         echo "<br>";
         
         //Member Class
         echo $member_row->find('td div.col2box div.col2box_left img',0);
         echo $member_row->find('td div.col2box div.col2box_left',0)->plaintext;
         echo "<br>";
         
         echo $member_row->find('td div.player_name_area div.fc_member_status img',0);
         echo $member_row->find('td div.player_name_area div.fc_member_status',0)->plaintext;
         echo "<br>";
         echo "<br>";   
      }
      
      getNext($html);      
   }
   
   function getNext($html) {
      if($next = $html->find('div.base_footer div.base_body div.base_inner div.mb10 div.pager div.pagination ul li.next a',0)->href){
         getMembers($html, $next);
      }
   }