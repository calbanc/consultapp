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
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["FECHA"])&&isset($_GET["TIPO"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $FECHA=$_GET["FECHA"];
        $TIPO=$_GET["TIPO"];
        $WHERE="";
		if(is_numeric($COD_EMP)&&$COD_EMP<>'9'){
			$consultaempresa="SELECT COD_EMP FROM EMPRESAS WHERE ID_EMPRESA_REM='{$COD_EMP}'";
			$resultadoempresa=sqlsrv_query($conexion,$consultaempresa);
			if($registroempresa=sqlsrv_fetch_array($resultadoempresa)){
				$NUEVAEMPRESA=$registroempresa['COD_EMP'];
			}
		}else{
			if($COD_EMP=='9'){
				$NUEVAEMPRESA='ARAP';
			}
			
		}
		
		$COD_EMP=$NUEVAEMPRESA;

		$ZON;
            $consultazona="SELECT ZON FROM PACKINGS_PARAMETROS WHERE IDUSUARIO='{$usuario}' AND COD_EMP='{$NUEVAEMPRESA}' AND COD_TEM='{$COD_TEM}' ";
            $resultadozona=sqlsrv_query($conexion,$consultazona);
            if($registrozona=sqlsrv_fetch_array($resultadozona)){
                $ZON=$registrozona['ZON'];
            }
		

		if($TIPO<>'TODOS' && $TIPO<>'CAMION'){
			$WHERE.="AND TIPO='{$TIPO}' AND CONVERT(VARCHAR,FECHA_INGRESO,23)='{$FECHA}' ";
		}else{
			if($TIPO=='CAMION'){
				$WHERE.="AND TIPO='{$TIPO}' AND CONVERT(VARCHAR,FECHA_REGISTRO,23)='{$FECHA}' ";
			}else{
				$WHERE.="AND CONVERT(VARCHAR,FECHA_INGRESO,23)='{$FECHA}' ";
			}
		}


		
			
		$consulta="SELECT isnull(patente,'') as patente,isnull(rutconductor,'') as rutconductor,NombreConductor,isnull(CONVERT(VARCHAR,fecha_ingreso,20),'') as fecha_ingreso,isnull(CONVERT(VARCHAR,fecha_salida,20),'') as fecha_salida,isnull(CONVERT(VARCHAR,fecha_registro,20),'')as fecha_registro
        FROM ANDROID_RECEPCION_CAMIONES WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND ZON='{$ZON}' ".$WHERE ." order by id";

		


		
	


        $resultado=sqlsrv_query($conexion,$consulta);
		while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
		}
		echo json_encode($json);
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