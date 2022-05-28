<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["TIP_TRA"])&&isset($_GET["NRO_ORDEN"])&&isset($_GET["COD_REC"])&&isset($_GET["PATENTE"])&&
    isset($_GET["LOTE"])&&isset($_GET["FECHA"])&&isset($_GET["HORA"])&&isset($_GET["TEMP"])&&isset($_GET["NRO_TER"])&&isset($_GET["IDUSUARIO"])){
        

        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $TIP_TRA=$_GET["TIP_TRA"];
        $NRO_ORDEN=$_GET["NRO_ORDEN"];
        $COD_REC=$_GET["COD_REC"];
        $PATENTE=$_GET["PATENTE"];
        $LOTE=$_GET["LOTE"];    
        $FECHA=$_GET["FECHA"];
        $HORA=$_GET["HORA"];
        $TEMP=$_GET["TEMP"];
        $NRO_TER=$_GET["ODOMETRO"];
        $IDUSUARIO=$_GET["IDUSUARIO"];
      
        
        

        		
		$consulta="INSERT INTO ANDROID_DESPACHO (COD_EMP, COD_TEM, TIP_TRA, NRO_ORDEN, COD_REC, PATENTE, LOTE, FECHA, HORA, TEMP, NRO_TER, IDUSUARIO, SW_ENVIADO)          
        VALUES('{$COD_EMP}', '{$COD_TEM}', '{$TIP_TRA}', '{$NRO_ORDEN}', '{$COD_REC}', '{$PATENTE}', '{$LOTE}', '{$FECHA}', '{$HORA}', '{$TEMP}', '{$NRO_TER}', '{$IDUSUARIO}',0)";
                	
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

