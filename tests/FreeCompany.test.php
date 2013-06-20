<h2>TEST FREE COMPANY</h2>
<p>
   Free Company ID: 9233786610993070080<br>
</p>

<h2>Free Company Information</h2>

<?php
   include('../Lodestone.class.php');
   
   $lodestone = new Lodestone('na');
   
   if($lodestone instanceof Lodestone){
      echo "Lodestone Loaded<br>";
   }
      
   $freecompany = $lodestone->getFreeCompany('9233786610993070080');
   
   if($freecompany instanceof FreeCompany){
      echo "Free Company Loaded<br>";
   }
   
   echo $freecompany->getIcon()."<br>";
   echo $freecompany->getName()."<br>";
   echo $freecompany->getSize()."<br>";
   echo $freecompany->getServer()."<br>";
   echo $freecompany->getGrandCompany()."<br>";
   
   $counter = 0;
   foreach($freecompany->getMembers(true) as $member){
      $counter++;
      echo $counter.") ";
      echo $member["name"]."<br>";
      echo $member["icon"]."<br>";
      
      if(is_array($member["class"])){
         echo $member["class"]["icon"]." ".$member["class"]["lvl"]."<br>";
      }
      
      echo $member["rank"]["icon"].$member["rank"]["rank"]."<br>";
      echo $member["server"]."<br>";
      echo $member["link"]."<br>";
      echo $member["id"]."<br>";
      
      echo "<br>";
   }