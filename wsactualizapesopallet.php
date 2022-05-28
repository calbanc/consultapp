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
    if(isset($_GET["KILOS"])
    &&isset($_GET["TOTAL_KILOS"])
    &&isset($_GET["HORA_RECEP"])
    &&isset($_GET["LOTE"])
   ){
        
        $KILOS=$_GET["KILOS"];
        $TOTAL_KILOS=$_GET["TOTAL_KILOS"];
        $HORA_RECEP=$_GET["HORA_RECEP"];
        $LOTE=$_GET["LOTE"];

        
        
		$consulta="UPDATE COSECHA_HUERTO 
		SET KILOS='{$KILOS}',TOTAL_KILOS='{$TOTAL_KILOS}',HORA_RECEP='{$HORA_RECEP}'
		WHERE LOTE='{$LOTE}'";
		
       
		$resultado_update=sqlsrv_query($conexion,$consulta);
        if($resultado_update){
            $consultafinal="SELECT KILOS FROM COSECHA_HUERTO WHERE LOTE='{$LOTE}' ";
           
                    $resultado=sqlsrv_query($conexion,$consultafinal);
                    
                    if($registro=sqlsrv_fetch_array($resultado)){
                        $json[]=$registro;
                    }
                   
                    echo json_encode($json);
        }else{
                $resulta["id"]='NO REGISTRA';
                $json[]=$resulta;
                echo json_encode($json);
        }
    

        }else{
        $resultar["id"]='FALTAN DATOS';
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