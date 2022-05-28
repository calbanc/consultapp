<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){
    $usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
$info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IDEMPRESA"])){
        

       $COD_EMP=$_GET["IDEMPRESA"];

        if(strlen($COD_EMP)<=2){
            $empresa="SELECT COD_EMP FROM EMPRESAS WHERE ID_EMPRESA_REM='$COD_EMP'";

        
            $resultadoempresa=sqlsrv_query($conexion,$empresa);
            if($registroempresa=sqlsrv_fetch_array($resultadoempresa)){
                $NUEVAEMPRESA=$registroempresa['COD_EMP'];
            }
        }
       
        if($COD_EMP=='9'){
            $NUEVAEMPRESA='ARAP';
        }
        if($COD_EMP=='14'){
            $NUEVAEMPRESA='FORT';
        }

    

        		
		$consulta="SELECT ISNULL(MAX(PLANILLA),0)+1 as planilla FROM ANDROID_CTACTE_TRABAJADOR_MATERIAL WHERE COD_EMP='{$NUEVAEMPRESA}' ";
    

		$resultado=sqlsrv_query($conexion,$consulta);
        while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
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
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
}
?>






