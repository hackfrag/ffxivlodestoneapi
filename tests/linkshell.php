<h2>TEST LINKSHELL</h2>
<p>
   Linkshell Name: Blue Garter<br>
   Linkshell ID: 20829148276588545<br>
</p>

<h2>Parser Information</h2>
<?php
   // example of how to use basic selector to retrieve HTML contents
   include('../vendors/simplehtml/simple_html_dom.php');
   
   //Custom User Agent
   $custom_User_Agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1468.0 Safari/537.36";
   ini_set('user_agent', $custom_User_Agent);
   
   // get DOM from URL or file
   $html = file_get_html('http://na.beta.finalfantasyxiv.com/lodestone/linkshell/20829148276588545/');
   
   /* example
    
      echo $html->find('',0)->plaintext;
      echo "<br>";
      
      echo $html->find('',0);
      echo "<br>";
   */
   
   //Linkshell Name  
   echo $html->find('div.area_footer h2.player_name_brown',0)->plaintext;
   echo "<br>";
   
   //Linkshell Size
   echo $html->find('div.area_footer div.clearfix div.select_index_left h3',0)->plaintext;
   echo "<br>";
   
   echo "<h3>MEMBERS</h3>";
   
   //Members   
   foreach($html->find('div.base_footer div.base_body div.base_inner div.area_inner_header div.area_inner_footer div.area_inner_body div.table_black_border_bottom table tbody tr') as $member_row) {
      //Member Thumbnail
      echo $member_row->find('th div img',0);
      echo "<br>";
      
      //Member Name
      $link = $member_row->find('td div.player_name_area h4.player_name_gold a',0)->attr["href"];
      $name = $member_row->find('td div.player_name_area h4.player_name_gold a',0)->plaintext;
      $server = $member_row->find('td div.player_name_area h4.player_name_gold span',0)->plaintext;
      
      echo str_replace("/","",str_replace("/lodestone/character","",$link));
      echo "<br>";
      echo "<a href='http://na.beta.finalfantasyxiv.com".$link."'>".$name."</a>";
      echo "<br>";
      echo $server;
      echo "<br>";
      
      //Member Class
      echo $member_row->find('td div.col3box div.col3box_left div img',0);
      echo $member_row->find('td div.col3box div.col3box_left div',1)->plaintext;
      echo "<br>";
      
      //Member Grand Company
      echo $member_row->find('td div.col3box div.col3box_center div img',0);
      echo $member_row->find('td div.col3box div.col3box_center div',1)->plaintext;
      echo "<br>";
      
      //Member Free Company
      echo $member_row->find('td div.col3box div.col3box_right div img',0);
      echo $member_row->find('td div.col3box div.col3box_right div',1)->plaintext;
      echo "<br>";
      
      echo $member_row->find('td div.player_name_area span.ic_master',0)->class;
      echo $member_row->find('td div.player_name_area span.ic_leader',0)->class;
      echo "<br>";
      echo "<br>";
   }