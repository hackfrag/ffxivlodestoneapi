<h2>TEST CHARACTER</h2>
<p>
   Character ID: 1559402<br>
</p>

<h2>Class Information</h2>

<?php
   include('../Lodestone.class.php');
   
   $lodestone = new Lodestone('na');
   
   if($lodestone instanceof Lodestone){
      echo "Lodestone Loaded<br>";
   }
   
   $character = $lodestone->getCharacter('1559402');
   
   if($character instanceof Character){
      echo "Player Character Loaded<br>";
   }
   
   echo $character->getThumbnail()."<br>";
   echo $character->getPicture()."<br>";
   echo $character->getName()."<br>";
   echo $character->getServer()."<br>";
   echo $character->getMainLvL()."<br>";
   echo $character->getRace()."<br>";
   echo $character->getNameDay()."<br>";
   echo $character->getGuardian()."<br>";
   echo $character->getCityState()."<br>";
   echo $character->getGrandCompany()."<br>";
   echo $character->getGCRank()."<br>";
   echo $character->getFreeCompany()."<br>";
   
   foreach($character->getStats() as $key => $value) {
      print($key." - ".$value."<br>");
   }
   
   foreach($character->getAttributes() as $key => $value){
      print($key." - ".$value."<br>");
   }
   
   foreach($character->getElements() as $key => $value){
      print($key." - ".$value."<br>");
   }
   
   foreach($character->getProperties() as $key => $value){
      print($key." - ".$value."<br>");
   }
   
   foreach($character->getClasses() as $key => $class){
      print($class["icon"]." ".$key." - Level: ".$class["lvl"]." Experience: ".$class["exp"]);
      print("<br>");
   }
   
   foreach($character->getGear() as $item){
      print($item["icon"]." ".$item["name"]." ".$item["data"]);
      print("<br>");
   }