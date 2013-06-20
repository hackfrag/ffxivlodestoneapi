<h2>TEST CHARACTER</h2>
<p>
   Character Name: Methylene Beta<br>
   Character ID: 1559402<br>
</p>

<h2>Parser Information</h2>
<?php
   // example of how to use basic selector to retrieve HTML contents
   include('../vendors/simplehtml/simple_html_dom.php');
   
   //Custom User Agent
   $custom_User_Agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1468.0 Safari/537.36";
   ini_set('user_agent', $custom_User_Agent);
   
   // get DOM from URL or file
   $html = file_get_html('http://na.beta.finalfantasyxiv.com/lodestone/character/1559402/');
   
   // Dump contents (without tags) from HTML
   //echo $html->plaintext;

   //Master Character
   //print_r($html->find('div[id="character"]'));
   
   /*example
   echo $html->find('',0)->plaintext;
   echo "<br>";
   
   echo $html->find('',0);
   echo "<br>";
   */
   
   //Character Icon
   echo $html->find('div.area_footer div.thumb_cont_black_40 img',0);
   echo "<br>";
   
   //Character Full
   echo $html->find('div.param_right_area div#chara_img_area div.img_area img',0);
   echo "<br>";
   
   $full_name = $html->find('div.area_footer h2.player_name_brown',0)->plaintext;
   $server = $html->find('div.area_footer h2.player_name_brown span',0)->plaintext;
   $name = str_replace(array($server),'',$full_name);
   
   //Character Name  
   echo $name;
   echo "<br>";
   
   //Character Server  
   echo $server;
   echo "<br>";
   
   //Character Level
   echo $html->find('div#param_class_info_area div#class_info div.level',0)->plaintext;
   echo "<br>";
   
   //Character Race
   echo ($html->find('div.area_footer div.chara_profile_title',0)->plaintext);
   echo "<br>";
   
   //Nameday
   echo $html->find('ul.chara_profile_list li strong',0)->plaintext;
   echo "<br>";
   
   //Guardian
   echo $html->find('ul.chara_profile_list li strong',1)->plaintext;
   echo "<br>";
   
   //Starting City-State
   echo $html->find('ul.chara_profile_list li strong',2)->plaintext;
   echo "<br>";
   
   //Grand Company
   echo $html->find('ul.chara_profile_list li strong',3)->plaintext;
   echo "<br>";
   
   //Free Company
   echo $html->find('ul.chara_profile_list li strong',4)->plaintext;
   echo "<br>";
   
   //Stats
   foreach($html->find('div#param_power_area ul#power_gauge li') as $stat) {
      echo $stat->class;
      echo " : ";
      echo $stat->plaintext;
   }
   
   //Attributes
   foreach($html->find('div.param_left_area_inner div.param_left_area_inner_l ul.param_list_attributes li') as $stat) {
      echo $stat->class;
      echo " : ";
      echo $stat->plaintext;
      echo "<br>";
   }
   
   //Elements
   foreach($html->find('div.param_left_area_inner div.param_left_area_inner_r ul.param_list_elemental li') as $stat) {
      $value = $stat->find('span.val',0)->plaintext;
      echo $value;
      echo trim(str_replace("clearfix","",$stat->class));
      
      echo "<br>";
   }
   
   //Properties
   foreach($html->find('div.param_left_area_inner ul.param_list li') as $stat) {
      echo $stat->find('span.left',0)->plaintext;
      echo $stat->find('span.right',0)->plaintext;
      echo "<br>";
   }
   
   //Classes
   foreach($html->find('div.base_inner div table.class_list tbody tr') as $class) {
      echo $class->find('td img',0);
      echo $class->find('td',0)->plaintext;
      echo " - level ";
      echo $class->find('td',1)->plaintext;
      echo " - ";
      echo $class->find('td',2)->plaintext;
      echo "<br>";
      if($class->find('td',3)->innertext != ""){
         echo $class->find('td img',1);
         echo $class->find('td',3)->plaintext;
         echo " - level ";
         echo $class->find('td',4)->plaintext;
         echo " - ";
         echo $class->find('td',5)->plaintext;
         echo "<br>";
      }
   }
   
   //Gear
   foreach($html->find('div.param_right_area div#chara_img_area div.icon_area div.ic_reflection_box') as $gear) {
      echo $gear->find('img.ic_reflection',0);
      echo "<br>";
      foreach($gear->find('div.item_detail_box div.popup_w412_header_gold div.popup_w412_footer_gold div.popup_w412_body_gold') as $gear_details){
         echo $gear_details->find('div div.name_area h2.item_name',0)->plaintext;
         echo "<br>";
         echo $gear_details->find('div div.name_area div.item_element span.rare',0)->plaintext;
         echo "<br>";
         echo $gear_details->find('div div.name_area div.item_element span.ex_bind',0)->plaintext;
         echo "<br>";
         echo $gear_details->find('div.popup_w412_body_inner div div.ability_name',0)->plaintext;
         echo $gear_details->find('div.popup_w412_body_inner div div.ability',0)->plaintext;
         echo "<br>";
         echo $gear_details->find('div.popup_w412_body_inner div div.ability_name',1)->plaintext;
         echo $gear_details->find('div.popup_w412_body_inner div div.ability',1)->plaintext;
         echo "<br>";
         echo $gear_details->find('div.area_header_w400_gold div.area_footer_w400_gold div.area_body_w400_gold div',0)->plaintext;
         echo "<br>";
         
         foreach($gear_details->find('div.popup_w412_body_inner div.class') as $class){
            echo $class;
         }
         
         foreach($gear_details->find('div.popup_w412_body_inner div.list_1col ul.basic_bonus li') as $stat){
            echo $stat->plaintext;
            echo "<br>";
         }
         
         echo $gear_details->find('div.popup_w412_body_inner h3',0)->plaintext;
         echo "<br>";
         
         echo $gear_details->find('div.popup_w412_body_inner h3',1)->plaintext;
         echo "<br>";
         
         echo $gear_details->find('div.popup_w412_body_inner ul.list_1col li.set_bonus',0)->plaintext;
         echo "<br>";
         
         echo $gear_details->find('div.popup_w412_body_inner h3',2)->plaintext;
         echo "<br>";
         
         foreach($gear_details->find('div.popup_w412_body_inner ul.list_1col li') as $info){
            echo $info->find('div',0)->plaintext;
            echo $info->find('div',1)->plaintext;
            echo "<br>";
         }
         echo "<br>";
      }
   } 
   