<?php
 session_start(); 
 $uploadOK=0; //indikator ispravnosti uploadovanja
  $ime_formata=$_POST['format'];//promenljva u koju se smesta izabrani format u html formularu
  if(!empty($_FILES['uploaded_file']))//procedura uploadovanja
  {
    $path = "/var/www/html/";
    $filename = $path . basename($_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $filename)) {
    $uploadOK=1;
    } else{
       $uploadOK=0;
    }
  }
  
  if(file_exists('knjige.xml')) unlink('knjige.xml');//obrisemo trenutni fajl da bismo kreirali novi imenovan knjige.xml.
  chmod($filename,0755);
  rename($filename, 'knjige.xml');//preimenujemo uploadovan fajl u knjige.xml
  ini_set('memory_limit', '1024M');//postavljamo memorisjko ogranicenje za robusnije xml fajlove
 $xml = simplexml_load_file("knjige.xml") or die("Ne mogu da otvorim knjige.xml za parsiranje.");//pokusavamo da rasclanimo xml fajl
  
$buffer="";//inicijalizujemo bafer u koji cemo pisati

$hdr="<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n"; 
$buffer.=$hdr;//najpre smestamo zaglavlje xml dokumenta u bafer

$tag1b="<zapisi>\n"; $buffer.=$tag1b;


  foreach ($xml->children() as $notices){
    $tag2b="<zapis>\n"; $buffer.=$tag2b;

     foreach($notices->children() as $filds){
       $fild=$filds['c'];

         foreach($filds->children() as $subfilds){
             $subfild=$subfilds['c'];
             $subfild1=$subfilds;
        
             $tag_b="<p" . $fild . $subfild .">";

             $tag_e="</p" . $fild . $subfild . ">\n";
             $text= "  " . $tag_b . $subfild1 . $tag_e; 
            $buffer.=$text;//smestamo spojene f(polja) i s(potpolja) sa vrednostima potpolja u bafer 
         }
      }
      $tag2e="</zapis>\n";
      $buffer.=$tag2e;//zatvaramo otvorene tagove za nivo pojedincacnog zapisa
     
  }      
$tag1e="</zapisi>\n";$buffer.=$tag1e;//zatvaramo otvoreni tag za skup svih zapisa. 


$_SESSION["MyVar"]=$buffer; //dodelimo \$\_SESSION promenljivi vrednost bafera

//u zavisnosti od izabranog formata pozivamo odgovarajuci skript.
  switch($ime_formata){
   case 1:  
     if ($uploadOK==1){
 
     include('bibliography.php');
     }
     else { echo "Neuspesan pokusaj       uploadovanja!";}
     break;
   case 2:
     if ($uploadOK==1){
 
     include('reportISBD.php');
     }
     else { echo "Neuspesan pokusaj       uploadovanja!";}  
     break;
   case 3:
     if ($uploadOK==1){
 
        include('dublincoretxt.php');
      }
      else { echo "Neuspesan pokusaj       uploadovanja!";}
      break;
    case 4:
      if($uploadOK==1){
	include('tabela.php');
      }
      else { echo "Neuspesan pokusaj uploadovanja!";}
      break;
  }
  
?>
