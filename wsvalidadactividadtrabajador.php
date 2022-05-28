<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["Llave"])){
        

        $Llave=$_GET["Llave"];
      

      		
		
        $consulta="SELECT Llave FROM ActividadTrabajadorAndroid WHERE Llave='{$Llave}'";
		
        
		
		$resultado=sqlsrv_query($conexion,$consulta);
		if($registross=sqlsrv_fetch_array($resultado)){
			$data=array('id'=>'REGISTRADO'); 
			$json[]=$data;
			echo json_encode($json);

		}else{
			$data=array('id'=>'NO REGISTRADO'); 
			$json[]=$data;
			echo json_encode($json);
		}

		

		
		echo json_encode($json);
		

	}else{
		$resultar["id"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	echo "CONEXION FALLIDA";
}
	
?>






