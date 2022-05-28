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
	if(isset($_GET["LLAVE"])&&isset($_GET["SUBITEM"])&&isset($_GET["CANTIDAD"])){
        
        
        $LLAVE=$_GET["LLAVE"];
        $SUBITEM=$_GET["SUBITEM"];
        $CANTIDAD=$_GET["CANTIDAD"];

       
        $consultausuario="SELECT COD_BOD,ZON,COD_EMP,COD_TEM FROM DESPACHOMATERIALES_ANDROID WHERE LLAVE='{$LLAVE}'";
        
       
        $resultadousuario=sqlsrv_query($conexion,$consultausuario);
        if($registrousuario=sqlsrv_fetch_array($resultadousuario)){
            $ZON=$registrousuario['ZON'];
            $COD_BOD=$registrousuario['COD_BOD'];
            $COD_EMP=$registrousuario['COD_EMP'];
            $COD_TEM=$registrousuario['COD_TEM'];

        }

		
		$consultastock=" SELECT STOCK  FROM VIEW_MATERIALES_AYUDA WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND ZON ='{$ZON}' AND COD_BOD ='{$COD_BOD}' AND SUBITEM='{$SUBITEM}' ";
		
        $resultadostock=sqlsrv_query($conexion,$consultastock);
        
        if($registrostock=sqlsrv_fetch_array($resultadostock)){
            $STOCK=$registrostock['STOCK'];
        }
        
		if($CANTIDAD>$STOCK){
            $resultar["RESPUESTA"]='STOCK';
		    $json[]=$resultar;
		    echo json_encode($json);
        }else{
            $update="UPDATE DESPACHOMATERIALES_ANDROID SET SUBITEM='{$SUBITEM}' , CAN_DES='{$CANTIDAD}'  WHERE LLAVE='{$LLAVE}' ";
         
            $resultado=sqlsrv_query($conexion,$update);

            if($resultado){
                $resultar["RESPUESTA"]='ACTUALIZADO';
                $json[]=$resultar;
                echo json_encode($json);
            }else{
                $resultar["RESPUESTA"]='NO ACTUALIZADO';
                $json[]=$resultar;
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