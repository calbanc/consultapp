<?PHP



    if (isset($_POST['nombre']) && isset($_POST['imagen'])){

     
      $pdf=$_POST["imagen"];
      $nombrepdf=$_POST["nombre"];
    
      
      $ruta_imagen = "imagenes/$nombrepdf.jpg";
      file_put_contents($ruta_imagen,base64_decode($pdf));
      $bytesArchivo=file_get_contents($ruta_imagen);
    
      if($bytesArchivo){
       echo 'REGISTRADO';
      }else{
          echo 'NO REGISTRADO';
      }
    
    }else{
        $resultar["message"]='Ws no Retorna';
        $json[]=$resultar;
        echo json_encode($json);
    }   
  ?>