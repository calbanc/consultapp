<?PHP

$hostname_localhost="192.168.2.210";



if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
    $clave=$_GET["clave"];
  
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    

		$conexion = sqlsrv_connect($hostname_localhost,$info);
		ini_set('mssql.charset', 'UTF-8');
		if($conexion){
			$json=array();
			if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["OPTION"]))	{
				
				$COD_EMP=$_GET["COD_EMP"];
				$COD_TEM=$_GET["COD_TEM"];
				$OPTION=$_GET["OPTION"];
				$IDTRABAJADOR=$_GET["IDTRABAJADOR"];
				
				if($OPTION==5){
					$consulta="TRANS_RENDICIONES_CHOFERES @COD_EMP='{$COD_EMP}',@COD_TEM='{$COD_TEM}', @IDTRABAJADOR='{$IDTRABAJADOR}',  @OPTION='{$OPTION}'";
				}


				
				
				$resultado=sqlsrv_query($conexion,$consulta);
				
				while($registro =sqlsrv_fetch_array($resultado)){
					$json[]=$registro;
				}

				
				echo json_encode($json);
				

			}else{
				$resultar["message"]='Faltan parametros';
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