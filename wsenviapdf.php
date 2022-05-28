<?php


$json=array();

	
if (isset($_POST['nombrepdf']) && isset($_POST['pdf'])){

     
  $pdf=$_POST["pdf"];
  $nombrepdf=$_POST["nombrepdf"];

  
  $ruta_imagen = 'smb://192.168.2.214/share/TemporalSDT/Reportes/Fotos/'.$nombrepdf.'.jpg';


  
  
  
  $bytesArchivo=file_get_contents($ruta_imagen);

    if($bytesArchivo){
        echo 'retorna' ;
    }else{
        echo 'no retorna';
    }
  

}else{
    echo 'falta';
}   
?>

