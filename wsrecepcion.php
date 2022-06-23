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
    if(isset($_GET["COD_EMP"])
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["LOTE"])
    &&isset($_GET["COD_VAR"])
    &&isset($_GET["COD_ETI"])
    &&isset($_GET["COD_ENV"])
    &&isset($_GET["COD_PRO"])
    &&isset($_GET["COD_CAL"])
    &&isset($_GET["ALTURA"])
    &&isset($_GET["CAJAS"])
    &&isset($_GET["USUARIO"])
    &&isset($_GET["FECHA"])
    &&isset($_GET["HORA"])
    &&isset($_GET["SW_DIA"])
  ){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $LOTE=$_GET["LOTE"];
        $COD_VAR=$_GET["COD_VAR"];
        $COD_ETI=$_GET["COD_ETI"];
        $COD_ENV=$_GET["COD_ENV"];
        $COD_PRO=$_GET["COD_PRO"];
        $COD_CAL=$_GET["COD_CAL"];
        $ALTURA=$_GET["ALTURA"];
        $CAJAS=$_GET["CAJAS"];
        $USUARIO=$_GET["USUARIO"];
        $FECHA=$_GET["FECHA"];
        $HORA=$_GET["HORA"];
        $SW_DIA=$_GET["SW_DIA"];
		
		$consulta="INSERT INTO ANDROID_RECEPCION (COD_EMP, COD_TEM, LOTE, COD_VAR, COD_ETI, COD_ENV, COD_PRO, COD_CAL, ALTURA, CAJAS, USUARIO, FECHA, HORA, SW_DIA, SW_ENVIADO)                          
        VALUES('{$COD_EMP}', '{$COD_TEM}', '{$LOTE}', '{$COD_VAR}', '{$COD_ETI}', '{$COD_ENV}', '{$COD_PRO}', '{$COD_CAL}', '{$ALTURA}', '{$CAJAS}', '{$USUARIO}', '{$FECHA}', '{$HORA}', '{$SW_DIA}',0)";
      
      $resultado=sqlsrv_query($conexion,$consulta);
      
        if($resultado){
            $data=array(
                'id'=>'REGISTRA'
            );
            $json[]=$data;
            echo json_encode($json);
      
            }
            else{
                $data=array(
                    'id'=>'NO REGISTRA'
                );
                $json[]=$data;
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