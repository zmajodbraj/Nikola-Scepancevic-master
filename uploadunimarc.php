<?php
  $uploadOK=1; //indikator ispravnosti uploadovanja
  $ime_formata=$_POST['format'];//promenljva u koju se smesta izabrani format u html formularu
  if(!empty($_FILES['uploaded_file']))//procedura uploadovanja
  {
    $path = "/var/www/html/";
    $path = $path . basename($_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
    $uploadOK=1;
    } else{
       $uploadOK=0;
    }
  }

  if(file_exists('knjige.xml')) unlink('knjige.xml'); //obrisemo trenutni fajl da bismo kreirali novi imenovan knjige.xml.
  chmod($path,0755);
  rename($path, 'knjige.xml');//preimenujemo uploadovan fajl u knjige.xml. 
  ini_set('memory_limit', '1024M');//za robusnije xml fajlove postavimo memorijsko ogranicenje
  $xml = simplexml_load_file("knjige.xml") or die("Ne mogu da otvorim knjige.xml za parsiranje.");//prvi prolaz kroz parser, spajanje etiketa sa f(polja) i s(potpolja) oznakama
if(file_exists('knjige3.xml')) unlink('knjige3.xml');

$myfile=fopen("knjige3.xml", "w") or die("Ne mogu da otvorim fajl knjige3.xml za pisanje.");//otvaranje fajla za smestaanje spojenih polja i potpolja. 

$hdr="<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n"; //standardno zaglavlje xml fajla, upisuje se u fajl...
fwrite($myfile, $hdr);

$tag1b="<zapisi>\n";
fwrite($myfile, $tag1b);


  foreach ($xml->children() as $notices){
    $tag2b="<zapis>\n"; 
    fwrite($myfile, $tag2b);

     foreach($notices->children() as $filds){
       $fild=$filds['c'];

         foreach($filds->children() as $subfilds){
             $subfild=$subfilds['c'];
             $subfild1=$subfilds;
        
             $tag_b="<p" . $fild . $subfild .">";

             $tag_e="</p" . $fild . $subfild . ">\n";
             $text= "  " . $tag_b . $subfild1 . $tag_e; 
             fwrite($myfile, $text);
         }
      }
      $tag2e="</zapis>\n";

      fwrite($myfile,$tag2e);
     
  }      
$tag1e="</zapisi>\n";
fwrite($myfile, $tag1e);
fclose($myfile);
//U zavisnosti od izabranog formata izvrsava se odgovarajuca procedura 
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
