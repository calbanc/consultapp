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
    &&isset($_GET["COD_PRO"])
    &&isset($_GET["COD_PRE"])
    &&isset($_GET["COD_CUA"])
    &&isset($_GET["COD_ESP"])
    &&isset($_GET["COD_VAR"])
    &&isset($_GET["COD_CAL"])
    &&isset($_GET["COD_ENV"])
  
    &&isset($_GET["FECHA_COSECHA"])
    &&isset($_GET["CANTIDAD"])
    &&isset($_GET["ACOPIO"])
  
   ){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $LOTE=$_GET["LOTE"];
        $COD_PRO=$_GET["COD_PRO"];
        $COD_PRE=$_GET["COD_PRE"];
        $COD_CUA=$_GET["COD_CUA"];
        $COD_ESP=$_GET["COD_ESP"];
        $COD_VAR=$_GET["COD_VAR"];
        $COD_CAL=$_GET["COD_CAL"];
        $COD_ENV=$_GET["COD_ENV"];
      
        $FECHA_COSECHA=$_GET["FECHA_COSECHA"];
        $CANTIDAD=$_GET["CANTIDAD"];
        $ACOPIO=$_GET["ACOPIO"];
       
        
      
		
		$consulta="INSERT INTO COSECHA_HUERTO(COD_TEM,COD_EMP,LOTE,COD_PRO,COD_PRE,COD_CUA,COD_ESP,COD_VAR,COD_CAL,COD_ENV,FECHA_COSECHA,CANTIDAD,ACOPIO)
        VALUES ('{$COD_TEM}','{$COD_EMP}','{$LOTE}','{$COD_PRO}','{$COD_PRE}','{$COD_CUA}','{$COD_ESP}','{$COD_VAR}','{$COD_CAL}','{$COD_ENV}','{$FECHA_COSECHA}','{$CANTIDAD}','{$ACOPIO}')";
		
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