<h2>TEST LINKSHELL</h2>
<p>
   Linkshell ID: 20829148276588545<br>
</p>

<h2>Linkshell Information</h2>

<?php
   include('../Lodestone.class.php');
   
   $lodestone = new Lodestone('na');
   
   if($lodestone instanceof Lodestone){
      echo "Lodestone Loaded<br>";
   }
   
   $linkshell = $lodestone->getLinkshell('20829148276588545');
   
   if($linkshell instanceof Linkshell){
      echo "Linkshell Loaded<br>";
   }
   
   echo $linkshell->getName()."<br>";
   echo $linkshell->getSize()."<br>";
   
   $counter = 0;
   foreach($linkshell->getMembers() as $member){
      $counter++;
      echo $counter.") ";
      echo $member["name"]." - ".$member["rank"]."<br>";
      echo $member["icon"]."<br>";
      echo $member["server"]."<br>";
      echo $member["link"]."<br>";
      echo $member["id"]."<br>";
      
      if(is_array($member["GC"])){
         echo $member["GC"]["icon"]." ".$member["GC"]["name"]."<br>";
         echo $member["GC"]["rank"]."<br>";
      }
      
      if(is_array($member["FC"])){
         echo $member["FC"]["icon"]." ".$member["FC"]["name"]."<br>";
      }
      
      if(is_array($member["class"])){
         echo $member["class"]["icon"]." ".$member["class"]["lvl"]."<br>";
      }
      
      echo "<br>";
   }