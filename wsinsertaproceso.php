<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
    if(isset($_GET["ZON"])   
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["COD_EMP"])
    &&isset($_GET["FECHA_PAC"])
    &&isset($_GET["LOTE"])
    &&isset($_GET["CANTIDAD"])
    &&isset($_GET["KILOS"])
    &&isset($_GET["TOTAL_KILOS"])
    &&isset($_GET["COD_PRO"])
    &&isset($_GET["COD_FRI"])
    &&isset($_GET["COD_PRE"])
    &&isset($_GET["COD_CUA"])
    &&isset($_GET["COD_LINEA"])
    

   ){
        
       
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        $ZON=$_GET["ZON"];
        $FECHA_PAC=$_GET["FECHA_PAC"];
        $LOTE=$_GET["LOTE"];
        $CANTIDAD=$_GET["CANTIDAD"];
        $KILOS=$_GET["KILOS"];
        $TOTAL_KILOS=$_GET["TOTAL_KILOS"];
        $COD_PRO=$_GET["COD_PRO"];
        $COD_FRI=$_GET["COD_FRI"];
        $COD_PRE=$_GET["COD_PRE"];
        $COD_CUA=$_GET["COD_CUA"];
        $COD_LINEA=$_GET["COD_LINEA"];


        $FE=str_replace("T", " ", $FECHA_PAC);
       
        
      
		
		$consulta="INSERT INTO APP_INGRESO_APROCESO(COD_EMP,COD_TEM,ZON,FECHA_PAC,LOTE,CANTIDAD,KILOS,TOTAL_KILOS,COD_PRO,COD_FRI,COD_PRE,COD_CUA,COD_LINEA) 
        VALUES('{$COD_EMP}','{$COD_TEM}','{$ZON}','{$FE}','{$LOTE}','{$CANTIDAD}','{$KILOS}','{$TOTAL_KILOS}','{$COD_PRO}','{$COD_FRI}','{$COD_PRE}','{$COD_CUA}','{$COD_LINEA}')";
		
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
        $resultar["id"]='FALTAN DATOS';
        $json[]=$resultar;
        echo json_encode($json);
    }

}else{
	echo "CONEXION FALLIDA";
}
	
?>