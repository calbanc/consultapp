<?PHP


$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["IDFOTO"])&&isset($_GET["FECHA_TERMINO"])&&isset($_GET["OBSERVACION"])&&isset($_GET["MEDIDA"])){
        
	
		$IDFOTO=$_GET["IDFOTO"];
        $FECHA_TERMINO=$_GET["FECHA_TERMINO"];
		$OBSERVACION=$_GET["OBSERVACION"];
		$MEDIDA=$_GET["MEDIDA"];
		
		
				
        $consulta="UPDATE HALLAZGOS_ANDROID SET ESTADO='1' , FECHA_TERMINO='{$FECHA_TERMINO}' , OBSERVACION='{$OBSERVACION}' ,MEDIDA_IMPLEMENTADA='{$MEDIDA}' WHERE IDFOTO='{$IDFOTO}'";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		if($resultado){
			$resultar["RESULTADO"]=$IDFOTO;
			$json[]=$resultar;
			echo json_encode($json);
		}else{
			$resultar["RESULTADO"]='NO ACTUALIZA';
			$json[]=$resultar;
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
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
}
	 
?>