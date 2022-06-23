<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
    if(isset($_GET["Id"])&&isset($_GET["GUIASALIDA"])&&isset($_GET["DEVOLUCION"])){
        
      
        $Id=$_GET["Id"];
        $GuiaSalida=$_GET["GUIASALIDA"];
        $DEVOLUCION=$_GET["DEVOLUCION"];
       

        date_default_timezone_set('America/Santiago');
		$Fecha_salida=date('d/m/Y H:i:s',time());

		
        //$consultafecha="SELECT CONVERT(DATE,Fecha_ingreso) AS 'Fecha_ingreso',Patente FROM ANDROID_RECEPCION_CAMIONES WHERE Id='{$Id}' ";
        //$resultadoconsu=sqlsrv_query($conexion,$consultafecha);
        //while($registrofecha=sqlsrv_fetch_array($resultadoconsu)){
         //   echo $registrofecha['Patente'];
        //}

        //die();
        $consulta="UPDATE ANDROID_RECEPCION_CAMIONES SET Fecha_salida='{$Fecha_salida}',Guia_salida='{$GuiaSalida}', UsuarioSis_salida='{$usuario}' , DEVOLUCIONTARJETA='{$DEVOLUCION}' WHERE Id='{$Id}'" ;
     
        $resultado=sqlsrv_query($conexion,$consulta);

	
		if($resultado){  
            $consultafecha="SELECT CONVERT(VARCHAR,Fecha_ingreso,23) AS 'Fecha_ingreso',Patente FROM ANDROID_RECEPCION_CAMIONES WHERE Id='{$Id}'";
            $resultadoconsu=sqlsrv_query($conexion,$consultafecha);

            if($registrofecha=sqlsrv_fetch_array($resultadoconsu)){
               
                $fechaingreso=$registrofecha['Fecha_ingreso'];
                $patente=$registrofecha['Patente'];

                $consultaacompañante="SELECT Patente,Id from ANDROID_RECEPCION_CAMIONES WHERE CONVERT(DATE,Fecha_ingreso)='{$fechaingreso}' and Patente='{$patente}' and Id<>'{$Id}' and Fecha_salida IS NULL";
                

                $resultadoacompañantes=sqlsrv_query($conexion,$consultaacompañante);
                if($resultadosacompañantes=sqlsrv_fetch_array($resultadoacompañantes)){
                   
                        $resultar["registro"]='ACTUALIZADO';
                        $resultar["acom"]='si';
                     
                        $json[]=$resultar;           
                   
                }else{
                    $resultar["registro"]='ACTUALIZADO';
                    $resultar["acom"]='no';
                    $json[]=$resultar;       
                }  
                    
                    
                

            }else{
                $resultar["registro"]='ACTUALIZADO';
                    $resultar["acom"]='no';
                    $json[]=$resultar;   
            }
            
            

        }
		
		echo json_encode($json);
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