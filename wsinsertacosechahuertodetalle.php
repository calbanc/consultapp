<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
    if(isset($_GET["COD_EMP"])
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["LOTE"])
    &&isset($_GET["ZON"])
    &&isset($_GET["SERIE"])
    &&isset($_GET["GUIA"])
   
    
  
   ){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $LOTE=$_GET["LOTE"];
      
        $ZON=$_GET["ZON"];
        $SERIE=$_GET["SERIE"];
        $GUIA=$_GET["GUIA"];
		$consulta="UPDATE COSECHA_HUERTO_DETALLE
        SET ZON='{$ZON}', SERIE='{$SERIE}', GUIA='{$GUIA}' 
        WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND LOTE='{$LOTE}'";
		
			
		$resultado_update=sqlsrv_query($conexion,$consulta);
        if($resultado_update){
            $consultafinal="SELECT * FROM COSECHA_HUERTO_DETALLE WHERE LOTE='{$LOTE}' AND COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}'";
                    $resultado=sqlsrv_query($conexion,$consultafinal);
                    
                    if($registro=sqlsrv_fetch_array($resultado)){
                        $json[]=$registro;
                    }
                    mysqli_close($conexion);
                    echo json_encode($json);
            }
            else{
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
	
?>