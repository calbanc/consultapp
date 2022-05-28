<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
    if(isset($_GET["COD_EMP"])
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["GLOSA"])
   
    &&isset($_GET["LOTE"])
    &&isset($_GET["FECHA"])
    &&isset($_GET["HORA"])
    &&isset($_GET["TEMP"])
    &&isset($_GET["IDUSUARIO"])
    &&isset($_GET["SW_ENVIADO"])
  ){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
      
        $LOTE=$_GET["LOTE"];
        $GLOSA=$_GET["GLOSA"];
   
        $FECHA=$_GET["FECHA"];
        $HORA=$_GET["HORA"];
        $TEMP=$_GET["TEMP"];
        $IDUSUARIO=$_GET["IDUSUARIO"];
        $SW_ENVIADO=$_GET["SW_ENVIADO"];
     

      
		
		$consulta="INSERT INTO ANDROID_RESERVA(COD_EMP, COD_TEM, GLOSA, LOTE, FECHA, HORA, TEMP, IDUSUARIO, SW_ENVIADO)          
        VALUES('{$COD_EMP}', '{$COD_TEM}', '{$GLOSA}','{$LOTE}', '{$FECHA}', '{$HORA}', '{$TEMP}', '{$IDUSUARIO}','{$SW_ENVIADO}')";
        
		
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