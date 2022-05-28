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
    &&isset($_GET["COD_PRO"])
    &&isset($_GET["COD_PRE"])
    &&isset($_GET["COD_CUA"])
    &&isset($_GET["COD_ESP"])
    &&isset($_GET["COD_VAR"])
    &&isset($_GET["COD_CAL"])
    &&isset($_GET["COD_ENV"])
    &&isset($_GET["HORA_COSECHA"])
    &&isset($_GET["FECHA_COSECHA"])
    &&isset($_GET["CANTIDAD"])
    &&isset($_GET["ACOPIO"])
    &&isset($_GET["TIPO_COSECHA"])
    &&isset($_GET["CATEGORIA"])
    &&isset($_GET["OBSERVACION"])
  
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
        $HORA_COSECHA=$_GET["HORA_COSECHA"];
       
        $CANTIDAD=$_GET["CANTIDAD"];
        $ACOPIO=$_GET["ACOPIO"];
        $TIPO_COSECHA=$_GET["TIPO_COSECHA"];
        $CATEGORIA=$_GET["CATEGORIA"];
        $OBSERVACION=$_GET["OBSERVACION"];
        $fecha=date('d-m-Y');
        $FECHA_COSECHA=date('d-m-Y',strtotime($_GET["FECHA_COSECHA"]));

        if($COD_EMP=='ARAP' &&  $COD_ESP='GR'){
            $COD_ENV='P08';
        }
      
      $consultaante="SELECT LOTE FROM COSECHA_HUERTO WHERE LOTE='{$LOTE}' AND COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' ";
     
      $resultadoantes=sqlsrv_query($conexion,$consultaante);
       if($registross=sqlsrv_fetch_array($resultadoantes)){
        if($registross['LOTE']==$LOTE){
            $resulta["LOTE"]=$LOTE;
                $json[]=$resulta;
                echo json_encode($json);
        }
       }else{
        $consulta="INSERT INTO COSECHA_HUERTO(COD_TEM,COD_EMP,LOTE,COD_PRO,COD_PRE,COD_CUA,COD_ESP,COD_VAR,COD_CAL,COD_ENV,FECHA_COSECHA,CANTIDAD,ACOPIO,TIPO_COSECHA,CATEGORIA,IdUsuario,OBSERVACION,HORA_COSECHA)
        VALUES ('{$COD_TEM}','{$COD_EMP}','{$LOTE}','{$COD_PRO}','{$COD_PRE}','{$COD_CUA}','{$COD_ESP}','{$COD_VAR}','{$COD_CAL}','{$COD_ENV}','{$FECHA_COSECHA}','{$CANTIDAD}','{$ACOPIO}','{$TIPO_COSECHA}','{$CATEGORIA}','{$usuario}','{$OBSERVACION}','{$HORA_COSECHA}')";
        
        $resultado=sqlsrv_query($conexion,$consulta);
        if($resultado){
            $resulta["LOTE"]=$LOTE;
            $json[]=$resulta;
            echo json_encode($json);
        }else{
            $resulta["LOTE"]='NO REGISTRA';
            $json[]=$resulta;
            echo json_encode($json);
        }

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