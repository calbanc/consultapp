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
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["ZON"])&&isset($_GET["PLANILLA_REC"])&&isset($_GET["COD_MOV"])
	&&isset($_GET["FECHA"])&&isset($_GET["FECHA_DOCUMENTO"])&&isset($_GET["COD_BOD_ORIGEN"])&&isset($_GET["COD_PRO"])&&isset($_GET["CODIGOCLIENTE"])
	&&isset($_GET["COD_BOD"])&&isset($_GET["SERIE"])&&isset($_GET["NRO_GUIA"])&&isset($_GET["NRO_ORDEN"])&&isset($_GET["CORRELATIVO"])&&isset($_GET["SUBITEM"])
	&&isset($_GET["CANTIDAD_REC"])&&isset($_GET["COD_TIPODOC"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $ZON=$_GET["ZON"];
		$PLANILLA_REC=$_GET["PLANILLA_REC"];
		$COD_MOV=$_GET["COD_MOV"];
		$FECHA=$_GET["FECHA"];
		$FECHA_DOCUMENTO=$_GET["FECHA_DOCUMENTO"];
		$COD_BOD_ORIGEN=$_GET["COD_BOD_ORIGEN"];
		$COD_PRO=$_GET["COD_PRO"];
		$CODIGOCLIENTE=$_GET["CODIGOCLIENTE"];
		$COD_BOD=$_GET["COD_BOD"];
		$SERIE=$_GET["SERIE"];
		$NRO_GUIA=$_GET["NRO_GUIA"];
		$NRO_ORDEN=$_GET["NRO_ORDEN"];
		$CORRELATIVO=$_GET["CORRELATIVO"];
		$SUBITEM=$_GET["SUBITEM"];
        $CANTIDAD_REC=$_GET["CANTIDAD_REC"];
		$COD_TIPODOC=$_GET["COD_TIPODOC"];


	

		if($COD_MOV=='100'){
			$insertaplanilla="INSERT INTO ANDROID_TIT_RECEPCIONMATERIALES(COD_EMP,COD_TEM,ZON,PLANILLA_REC,COD_MOV,FECHA_RECEPCION,FECHA_DOCUMENTO,CODIGOCLIENTE,COD_BOD,SERIE,NRO_GUIA,COD_TIPODOC)
			VALUES('{$COD_EMP}','{$COD_TEM}','{$ZON}','{$PLANILLA_REC}','{$COD_MOV}','{$FECHA}','{$FECHA_DOCUMENTO}','{$CODIGOCLIENTE}','{$COD_BOD}','{$SERIE}','{$NRO_GUIA}','{$COD_TIPODOC}') ";
		}else{
			if($COD_MOV=='101'){
				$insertaplanilla="INSERT INTO ANDROID_TIT_RECEPCIONMATERIALES(COD_EMP,COD_TEM,ZON,PLANILLA_REC,COD_MOV,FECHA_RECEPCION,FECHA_DOCUMENTO,COD_BOD_ORIGEN,COD_BOD,SERIE,NRO_GUIA,COD_TIPODOC)
				VALUES('{$COD_EMP}','{$COD_TEM}','{$ZON}','{$PLANILLA_REC}','{$COD_MOV}','{$FECHA}','{$FECHA_DOCUMENTO}','{$COD_BOD_ORIGEN}','{$COD_BOD}','{$SERIE}','{$NRO_GUIA}','{$COD_TIPODOC}') ";
			}else{
				$insertaplanilla="INSERT INTO ANDROID_TIT_RECEPCIONMATERIALES(COD_EMP,COD_TEM,ZON,PLANILLA_REC,COD_MOV,FECHA_RECEPCION,FECHA_DOCUMENTO,COD_PRO,COD_BOD,SERIE,NRO_GUIA,COD_TIPODOC)
				VALUES('{$COD_EMP}','{$COD_TEM}','{$ZON}','{$PLANILLA_REC}','{$COD_MOV}','{$FECHA}','{$FECHA_DOCUMENTO}','{$COD_PRO}','{$COD_BOD}','{$SERIE}','{$NRO_GUIA}','{$COD_TIPODOC}') ";
			}
		}	
		

		$resultado=sqlsrv_query($conexion,$insertaplanilla);	
		$consulta="SELECT COD_EMP,COD_TEM,ZON,PLANILLA_REC,CORRELATIVO,SUBITEM FROM ANDROID_RECEPCIONMATERIALES WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND ZON='{$ZON}' AND PLANILLA_REC='{$PLANILLA_REC}' AND CORRELATIVO='{$CORRELATIVO}' ";
		
		$resultadoconsulta=sqlsrv_query($conexion,$consulta);
        if($registross=sqlsrv_fetch_array($resultadoconsulta)){
            if($registross['CORRELATIVO']==$CORRELATIVO){
                $data=array('COD_EMP'=>$COD_EMP,
                'COD_TEM'=>$COD_TEM,
                'ZON'=>$ZON,
                'PLANILLA_REC'=>$PLANILLA_REC,
                'CORRELATIVO'=>$CORRELATIVO,
                'SUBITEM'=>$SUBITEM); 
                $json[]=$data;
                echo json_encode($json);
            }
        }else{
            $insertarrecepcion="INSERT INTO ANDROID_RECEPCIONMATERIALES(COD_EMP,COD_TEM,ZON,PLANILLA_REC,CORRELATIVO,SUBITEM,CAN_REC,ID_ORDEN)VALUES
            ('{$COD_EMP}','{$COD_TEM}','{$ZON}','{$PLANILLA_REC}','{$CORRELATIVO}','{$SUBITEM}','{$CANTIDAD_REC}','{$NRO_ORDEN}') ";
		
			
			$resultadoinsertarecep=sqlsrv_query($conexion,$insertarrecepcion);
			$data=array('COD_EMP'=>$COD_EMP,
			'COD_TEM'=>$COD_TEM,
			'ZON'=>$ZON,
			'PLANILLA_REC'=>$PLANILLA_REC,
			'CORRELATIVO'=>$CORRELATIVO,
			'SUBITEM'=>$SUBITEM); 
			$json[]=$data;
			echo json_encode($json);
			


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