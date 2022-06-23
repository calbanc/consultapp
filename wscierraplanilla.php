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
    if(isset($_GET["temporada"])
    &&isset($_GET["empresa"])
    &&isset($_GET["planilla"])
    &&isset($_GET["IdUsuario"])
    &&isset($_GET["planilla_detalle"])
    &&isset($_GET["fecha_termino"])
    &&isset($_GET["hora_termino"])
    &&isset($_GET["temperatura"])
    &&isset($_GET["COD_FRI"])){
        
       
        $COD_TEM=$_GET["temporada"];
        $COD_EMP=$_GET["empresa"];
        $PLANILLA=$_GET["planilla"];
        $IdUsuario=$_GET["IdUsuario"];
        $planilla_detalle=$_GET["planilla_detalle"];
        $fecha_termino=$_GET["fecha_termino"];
        $hora_termino=$_GET["hora_termino"];
        $temperatura=$_GET["temperatura"];
        $COD_FRI=$_GET["COD_FRI"];
     
        $consulta=" UPDATE ANDROID_CTRL_PREFRIO
        SET FECHATERMINO='{$fecha_termino}',HORA_TERMINO='{$hora_termino}', TEMP_TERMINO='{$temperatura}'
        WHERE PLANILLA='{$PLANILLA}' AND COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND COD_FRI='{$COD_FRI}' AND IdUsuario='{$IdUsuario}' and PLANILLA_DETALLE='{$planilla_detalle}'";
        
            $resultado_update=sqlsrv_query($conexion,$consulta);
            if($resultado_update){
                $consultafinal="SELECT * FROM ANDROID_CTRL_PREFRIO WHERE PLANILLA='{$PLANILLA}' AND COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND COD_FRI='{$COD_FRI}' AND IdUsuario='{$IdUsuario}' and PLANILLA_DETALLE='{$planilla_detalle}' ";
                $resultado=sqlsrv_query($conexion,$consultafinal);
                        
                if($registro=sqlsrv_fetch_array($resultado)){
                    $json[]=$registro;
                }
                echo json_encode($json);
            }else{
                $resulta["PLANILLA_DETALLE"]='NO REGISTRA';
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