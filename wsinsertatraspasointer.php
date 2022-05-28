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
    if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["PLANILLA"])&&isset($_GET["ZON"])&&isset($_GET["ZON_DESTINO"])&&isset($_GET["FRIO_ORIGEN"])&&isset($_GET["FRIO_DESTINO"])
    &&isset($_GET["FECHA"])&&isset($_GET["LOTE"])&&isset($_GET["HORA"])){
       
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $PLANILLA=$_GET["PLANILLA"];
        $ZON=$_GET["ZON"];
        $ZON_DESTINO=$_GET["ZON_DESTINO"];
        $FRIO_ORIGEN=$_GET["FRIO_ORIGEN"];
        $FRIO_DESTINO=$_GET["FRIO_DESTINO"];
        $FECHA=$_GET["FECHA"];  
        $HORA=$_GET["HORA"];
        $LOTE=$_GET["LOTE"];
       
        $consultaantes="SELECT LOTE FROM ANDROID_TRASPASO_INTER WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND LOTE='{$LOTE}' ";
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        if($registross=sqlsrv_fetch_array($resultadoantes)){
            if($registross['LOTE']==$LOTE){
                $resulta["LOTE"]=$LOTE;
                    $json[]=$resulta;
                    echo json_encode($json);
            }
        }else{
            $consulta="INSERT INTO ANDROID_TRASPASO_INTER (COD_EMP,COD_TEM,ZON_ORIGEN,FRIO_ORIGEN,FRIO_DESTINO,SELLO,LOTE,FECHA,HORA,IDUSUARIO,ZON_DESTINO) 
            VALUES('{$COD_EMP}','{$COD_TEM}','{$ZON}','{$FRIO_ORIGEN}','{$FRIO_DESTINO}','{$PLANILLA}','{$LOTE}','{$FECHA}','{$HORA}','{$usuario}','{$ZON_DESTINO}')";
            
          
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