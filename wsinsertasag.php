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
    if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["ZON"])&&isset($_GET["OBS"]) &&isset($_GET["FECHA"])&&isset($_GET["LOTE"])&&isset($_GET["HORA"])){
       
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
      
        $ZON=$_GET["ZON"];
        $OBS=$_GET["OBS"];
    
        $FECHA=$_GET["FECHA"];  
        $HORA=$_GET["HORA"];
        $LOTE=$_GET["LOTE"];
       
        $consultaantes="SELECT LOTE FROM ANDROID_SAG WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND LOTE='{$LOTE}' AND ZON='{$ZON}' AND OBS='{$OBS}' ";
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        if($registross=sqlsrv_fetch_array($resultadoantes)){
            if($registross['LOTE']==$LOTE){
                $resulta["LOTE"]=$LOTE;
                    $json[]=$resulta;
                    echo json_encode($json);
            }
        }else{
            $consulta=" INSERT INTO ANDROID_SAG(COD_EMP, COD_TEM, ZON,OBS,LOTE,FECHA, HORA, IDUSUARIO, SW_ENVIADO)
            VALUES('{$COD_EMP}','{$COD_TEM}','{$ZON}','{$OBS}','{$LOTE}','{$FECHA}', '{$HORA}','{$usuario}',0)";
            
            $resultado=sqlsrv_query($conexion,$consulta);
            if($resultado){
                $resulta["LOTE"]=$LOTE;
                    $json[]=$resulta;
                    echo json_encode($json);
            }else{
                    $resulta["LLAVE"]='NO REGISTRA';
                    $json[]=$resulta;
                    echo json_encode($json);
            } 
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