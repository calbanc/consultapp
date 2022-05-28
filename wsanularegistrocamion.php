<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

    $conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
    if(isset($_GET["id"])){
        
      
        $Id=$_GET["id"];
        

        date_default_timezone_set('America/Santiago');
		$Fecha_salida=date('y/m/d H:i:s',time());

		$consultaantes="SELECT convert(varchar,FECHA_REGISTRO,20) as 'FECHA_REGISTRO' FROM ANDROID_RECEPCION_CAMIONES WHERE Id='{$Id}'";
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        if($registrosantes=sqlsrv_fetch_array($resultadoantes)){
                $FECHA=$registrosantes['FECHA_REGISTRO'] ;
                   

                $update="UPDATE ANDROID_RECEPCION_CAMIONES SET Fecha_ingreso=CONVERT(DATETIME,'{$FECHA}',120) ,Fecha_salida=CONVERT(DATETIME,'{$FECHA}',120) WHERE Id='{$Id}' ";
              

               
                $resultado=sqlsrv_query($conexion,$update);
                if($resultado){  
                    $resultar["registro"]='ACTUALIZADO';           
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