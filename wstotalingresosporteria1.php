<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
    if(isset($_GET["COD_EMP"])
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["FECHA"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];  
        $FECHA=$_GET["FECHA"];
        $TIPO=$_GET["TIPO"];

        $WHERE="";

        if($TIPO<>"TODOS"){
            $WHERE.="AND TIPO='{$TIPO}'";    
        }
            
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
            $consultazona="SELECT ZON FROM PACKINGS_PARAMETROS WHERE IDUSUARIO='{$usuario}' AND COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' ";
            $resultadozona=sqlsrv_query($conexion,$consultazona);
            if($registrozona=sqlsrv_fetch_array($resultadozona)){
                $ZON=$registrozona['ZON'];
            }
    

     

        $consultaantes="SELECT COUNT(ID) AS 'Total'
               FROM ANDROID_RECEPCION_CAMIONES  
               WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND CONVERT(date,Fecha_ingreso,103)='{$FECHA}' AND ZON='{$ZON}' AND FECHA_SALIDA IS NULL ".$WHERE;
        
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
    
        while($registross=sqlsrv_fetch_array($resultadoantes)){
            $json[]=$registross;
          
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