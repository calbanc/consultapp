<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
    if(isset($_GET["COD_EMP"])
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["FECHA"])
    &&isset($_GET["HORAINGRESO"]) 
    &&isset($_GET["RUT"])
    &&isset($_GET["NOMBRE"])
    
    &&isset($_GET["PATENTE"])
    &&isset($_GET["MOTIVO"])
    &&isset($_GET["OBSERVACION"])
    
    &&isset($_GET["TEMPERATURA"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];  
        $FECHA=$_GET["FECHA"];
        $HORAINGRESO=$_GET["HORAINGRESO"];
        $MOTIVO=strtoupper($_GET["MOTIVO"]) ;
        $OBSERVACION=strtoupper($_GET["OBSERVACION"]);
        $PATENTE= strtoupper($_GET["PATENTE"]);
        $TEMPERATURA=$_GET["TEMPERATURA"];
        $RUT=$_GET["RUT"];
        $NOMBRE=strtoupper($_GET["NOMBRE"]) ;

      


        if(is_numeric($COD_EMP)&&$COD_EMP<>'9'){
            $consultaempresa="SELECT COD_EMP FROM EMPRESAS WHERE ID_EMPRESA_REM='{$COD_EMP}'";
            $resultadoempresa=sqlsrv_query($conexion,$consultaempresa);
            if($registroempresa=sqlsrv_fetch_array($resultadoempresa)){
                $NUEVAEMPRESA=$registroempresa['COD_EMP'];
            }
        }else{
            if($COD_EMP=='9'){
                $NUEVAEMPRESA='ARAP';
            }
            
        }

        $COD_EMP=$NUEVAEMPRESA;
        $consulta1="SELECT ZON FROM PACKINGS_PARAMETROS WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND IDUSUARIO='{$usuario}' ";
        
       
        $resultado2=sqlsrv_query($conexion,$consulta1);
        $registros=sqlsrv_fetch_array($resultado2);
        $idzona=$registros['ZON'];


        $consultaantes="SELECT NombreConductor,Id FROM ANDROID_RECEPCION_CAMIONES WHERE Fecha_salida IS NULL  AND UsuarioSis_ingreso='{$usuario}' AND RUTCONDUCTOR='{$RUT}' ORDER BY Fecha_ingreso DESC";
              
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        
        $registroantes =sqlsrv_fetch_array($resultadoantes);
        $nombretrabajador=$registroantes['NombreConductor'];
        $id=$registroantes["Id"];
        if(!empty($nombretrabajador)){
            $resultar["respuesta"]='REGISTRADO';
            $resultar["id"]=$id;
            $json[]=$resultar;
            echo json_encode($json);
        }else{

            $consulta="INSERT INTO ANDROID_RECEPCION_CAMIONES(COD_EMP,COD_TEM,Fecha_ingreso,RutConductor,NombreConductor,Patente,UsuarioSis_ingreso,Sw_Despachado,ZON, Motivo,Observacion,temperatura,TIPO)
            VALUES('{$COD_EMP}','{$COD_TEM}','{$HORAINGRESO}','{$RUT}','{$NOMBRE}','{$PATENTE}','{$usuario}','0','{$idzona}','{$MOTIVO}','{$OBSERVACION}','{$TEMPERATURA}','VISITA')";


            
            $resultado=sqlsrv_query($conexion,$consulta);

            if($resultado){
                $resultar["respuesta"]='OK';
                
                $json[]=$resultar;
                echo json_encode($json);
            }else{
                $resultar["respuesta"]='NO REGISTRADO';
                
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