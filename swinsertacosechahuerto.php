<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
    if(isset($_GET["ZON"])
    &&isset($_GET["SERIE"])
    &&isset($_GET["GUIA"])
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["COD_EMP"])
    &&isset($_GET["COD_PACK"])
    &&isset($_GET["COD_FRI"])  
    &&isset($_GET["CHOFER"])
    &&isset($_GET["PATENTE"])
    &&isset($_GET["GLOSA"])
    
    &&isset($_GET["SW_TRASLADO"])
 
    &&isset($_GET["LOTE"])
    &&isset($_GET["TIPOFRU"])
    &&isset($_GET["COD_CALIDAD"]) 
    &&isset($_GET["ATM"])
    &&isset($_GET["COD_TIP_COM"])


   ){
        
        $ZON=$_GET["ZON"];
        $SERIE=$_GET["SERIE"];
        $GUIA=$_GET["GUIA"];
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        $COD_PACK=$_GET["COD_PACK"];
        $COD_FRI=$_GET["COD_FRI"];
        $CHOFER=$_GET["CHOFER"];
        $PATENTE=$_GET["PATENTE"];
        $GLOSA=$_GET["GLOSA"];
        $SW_TRASLADO=$_GET["SW_TRASLADO"];
    
        $LOTE=$_GET["LOTE"];
        $TIPOFRU=$_GET["TIPOFRU"];
        $COD_CALIDAD=$_GET["COD_CALIDAD"];
        $ATM=$_GET["ATM"];
        $COD_TIP_COM=$_GET["COD_TIP_COM"];     
		
		$consulta="UPDATE COSECHA_HUERTO 
		SET ZON='{$ZON}',SERIE='{$SERIE}',GUIA='{$GUIA}',COD_PACK='{$COD_PACK}',COD_FRI='{$COD_FRI}',CHOFER='{$CHOFER}',PATENTE='{$PATENTE}',GLOSA='{$GLOSA}',TIPOFRU='{$TIPOFRU}',COD_CALIDAD='{$COD_CALIDAD}',COD_TIP_COM='{$COD_TIP_COM}',ATM='{$ATM}',SW_TRASLADO='{$SW_TRASLADO}'
		WHERE LOTE='{$LOTE}' AND COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}'";

        
		$resultado_update=sqlsrv_query($conexion,$consulta);
        if($resultado_update){
            $consultafinal="SELECT * FROM COSECHA_HUERTO WHERE LOTE='{$LOTE}' AND COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}'";
           
                    $resultado=sqlsrv_query($conexion,$consultafinal);
                    
                    if($registro=sqlsrv_fetch_array($resultado)){
                        $json[]=$registro;
                    }
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