<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"Skaynav","UID"=>"jalban","PWD"=>"ja.1234","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["RutTrabajador"])&&isset($_GET["Fecha"])&&isset($_GET["Hora"])&&isset($_GET["Latitud"])&&isset($_GET["Longitud"])&&isset($_GET["IdEstacion"])&&
    isset($_GET["Id"])&&isset($_GET["VersionApp"])){
        

        $RutTrabajador=$_GET["RutTrabajador"];
        $Fecha=$_GET["Fecha"];
        $Hora=$_GET["Hora"];
        $Latitud=$_GET["Latitud"];
        $Longitud=$_GET["Longitud"];
        $IdEstacion=$_GET["IdEstacion"];
        $Id=$_GET["Id"];    
        $VersionApp=$_GET["VersionApp"];
      
        
        $dni= str_replace ( "  " , "%20" , $RutTrabajador);
     
        		
        $consulta="INSERT INTO Marcacion_Android(RutTrabajador,Fecha,Hora,Latitud,Longitud,IdEstacion,Id,VersionApp)
        VALUES('{$dni}','{$Fecha}','{$Hora}','{$Latitud}','{$Longitud}','{$IdEstacion}','{$Id}','{$VersionApp}')";
        
           	
        $resultado=sqlsrv_query($conexion,$consulta);
        
		 if($resultado){
            $resulta["id"]='REGISTRA';
            $json[]=$resulta;
            echo json_encode($json);
        }
        else{
            $resulta["id"]='NO REGISTRA';
            $json[]=$resulta;
            echo json_encode($json);
        }
		

	}else{
		$resultar["message"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	echo "CONEXION FALLIDA";
}
	
?>

