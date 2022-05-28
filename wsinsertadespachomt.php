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
    if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["ZON"])&&isset($_GET["COD_BOD"])&&isset($_GET["LLAVE"])&&isset($_GET["PLANILLA"])&&isset($_GET["COD_MOV"])
    &&isset($_GET["FECHA"])&&isset($_GET["COD_BOD_USER"])&&isset($_GET["COD_ZON_USER"])&&isset($_GET["CAN_DES"])&&isset($_GET["SUBITEM"])&&isset($_GET["LOTE_MATERIAL"])&&isset($_GET["USUARIO"])&&isset($_GET["HORA"])){
       
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $ZON=$_GET["ZON"];
        $COD_BOD=$_GET["COD_BOD"];
        $LLAVE=$_GET["LLAVE"];
        $PLANILLA=$_GET["PLANILLA"];
        $COD_MOV=$_GET["COD_MOV"];
        $COD_BOD_USER=$_GET["COD_BOD_USER"];
        $COD_ZON_USER=$_GET["COD_ZON_USER"];
        $CAN_DES=$_GET["CAN_DES"];
        $SUBITEM=$_GET["SUBITEM"];
        $HORA=$_GET["HORA"];
        $LOTE_MATERIAL=$_GET["LOTE_MATERIAL"];
        $USUARIO=$_GET["USUARIO"];
        $FECHA=date('d-m-Y',strtotime($_GET["FECHA"]));


        
        $consultaantes="SELECT * FROM DESPACHOMATERIALES_ANDROID WHERE LLAVE='{$LLAVE}'";
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        if($registross=sqlsrv_fetch_array($resultadoantes)){
            if($registross['LLAVE']==$LLAVE){
                $resulta["LLAVE"]=$LLAVE;
                    $json[]=$resulta;
                    echo json_encode($json);
            }
        }else{

            $consultalotematerial=" SELECT PLANILLA_REC FROM RECEPCIONMATERIALES WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND SUBITEM='{$SUBITEM}' AND CAN_REC>='{$CAN_DES}' AND ZON='{$ZON}' ORDER BY FECHA_ING ASC";
            $resultadolote=sqlsrv_query($conexion,$consultalotematerial);
            if($registrolote=sqlsrv_fetch_array($resultadolote)){
                $LOTE_MATERIAL=$registrolote['PLANILLA_REC'];
            }
            


            $consulta=" INSERT INTO DESPACHOMATERIALES_ANDROID(LLAVE,COD_EMP,COD_TEM,ZON,PLANILLA,COD_BOD,COD_MOV,FECHA,COD_BOD_USER,COD_ZON_USER,CAN_DES,SUBITEM,LOTE_MATERIAL,HORA,USUARIO) 
            VALUES('{$LLAVE}','{$COD_EMP}','{$COD_TEM}','{$ZON}','{$PLANILLA}','{$COD_BOD}','{$COD_MOV}','{$FECHA}','{$COD_BOD_USER}','{$COD_ZON_USER}','{$CAN_DES}','{$SUBITEM}','{$LOTE_MATERIAL}','{$HORA}','{$USUARIO}')";
            
    
            $resultado=sqlsrv_query($conexion,$consulta);
            if($resultado){
                $resulta["LLAVE"]=$LLAVE;
                    $json[]=$resulta;
                    echo json_encode($json);
                }
                else{
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