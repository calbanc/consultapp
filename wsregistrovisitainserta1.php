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
    &&isset($_GET["PROCEDENCIA"])
    &&isset($_GET["TELEFONO"])
    &&isset($_GET["PRESENTACI"])
    &&isset($_GET["COINCIDECI"])
    &&isset($_GET["PATENTE"])
    &&isset($_GET["ENTREGATRIP"])
    &&isset($_GET["DESTINO"])
    &&isset($_GET["MOTIVO"])
    &&isset($_GET["AUTORIZADO"])
    &&isset($_GET["TARJETA"])    
    &&isset($_GET["OBSERVACION"])
    &&isset($_GET["ZON"])
    &&isset($_GET["NGUIA"])
    &&isset($_GET["TEMPERATURA"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];  
        $FECHA=$_GET["FECHA"];
        $HORAINGRESO=$_GET["HORAINGRESO"];
        $RUT=$_GET["RUT"];
        $NOMBRE=strtoupper($_GET["NOMBRE"]) ;
        $PROCEDENCIA=strtoupper($_GET["PROCEDENCIA"]) ;
        $TELEFONO=$_GET["TELEFONO"];
        $PRESENTACI=$_GET["PRESENTACI"];
        $COINCIDECI=$_GET["COINCIDECI"];
        $PATENTE= strtoupper($_GET["PATENTE"]);
        $ENTREGATRIP=$_GET["ENTREGATRIP"];
        $DESTINO=strtoupper($_GET["DESTINO"]);
        $MOTIVO=strtoupper($_GET["MOTIVO"]) ;
        $AUTORIZADO=strtoupper($_GET["AUTORIZADO"]) ;
        $TARJETA=$_GET["TARJETA"];
        $OBSERVACION=strtoupper($_GET["OBSERVACION"]);
        $TEMPERATURA=$_GET["TEMPERATURA"];
        $ID=$_GET["ID"];
        $TIPO=$_GET["TIPO"];
        $ZON=$_GET["ZON"];
        $NGUIA=$_GET["NGUIA"];


        //-----SOLO PARA PERU

        $NROLICENCIA=$_GET["NROLICENCIA"];
        $SCRTVIGENTE=$_GET["SCTRVIGENTE"];
        $ACOMPANADO=$_GET["ACOMPANADO"];
        $FECHAINICIOSCTR=$_GET["FECHAINICIOSCTR"];
        $FECHATERMINOSCTR=$_GET["FECHATERMINOSCTR"];
        $CUENTACONSALUD=$_GET["CUENTACONSALUD"];
        $OBSERVACIONSALUD=strtoupper($_GET["OBSERVACIONSALUD"]);
        
        if(empty($TEMPERATURA)){
            $TEMPERATURA='0';
        }

        


        if(empty($PATENTE)){
            $PATENTE="NULL";
        }

        if(empty($ID)){
            $consultaantes="SELECT NombreConductor,Id FROM ANDROID_RECEPCION_CAMIONES WHERE Fecha_salida IS NULL  AND UsuarioSis_ingreso='{$usuario}' AND TIPO='VISITA' AND RUTCONDUCTOR='{$RUT}' ORDER BY Fecha_ingreso DESC";
        }else{
            $consultaantes="SELECT NombreConductor,Id FROM ANDROID_RECEPCION_CAMIONES WHERE ID='{$ID}' AND COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND ZON='{$ZON}' AND Fecha_salida IS NULL ";
        }

        
       
        
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

            if($COD_EMP=='ARAP' || $COD_EMP=='FORT'){

                if($TIPO=="ACTUALIZACION"){
                    $consultaempresazona="SELECT Fecha_ingreso,COD_EMP,COD_TEM,ZON FROM ANDROID_RECEPCION_CAMIONES WHERE  Id='{$ID}' AND ZON IS  NULL  ";
                    
                    $execempresazona=sqlsrv_query($conexion,$consultaempresazona);

                    if($resultadoempresazona=sqlsrv_fetch_array($execempresazona)){
                            //ACTUALIZAMOS EL REGISTRO YA QUE ES LA PRIMERA VEZ QUE INGRESA
                            $consulta="UPDATE ANDROID_RECEPCION_CAMIONES SET ZON='{$ZON}',COD_EMP='{$COD_EMP}',COD_TEM='{$COD_TEM}',Fecha_ingreso='{$HORAINGRESO}',PRESENTACI='{$PRESENTACI}',COINCIDECI='{$COINCIDECI}',
                            ENTREGATRIP='{$ENTREGATRIP}',UsuarioSis_ingreso='{$usuario}',TARJETA='{$TARJETA}',temperatura='{$TEMPERATURA}' where Id='{$ID}' ";
                
                    }else{
                        $sql1="SELECT Id,Fecha_ingreso,COD_EMP,COD_TEM,ZON FROM ANDROID_RECEPCION_CAMIONES WHERE  COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND RutConductor='{$RUT}' and ZON='{$ZON}' AND Fecha_ingreso IS NOT  NULL  ";
                        
                        $execsql1=sqlsrv_query($conexion,$sql1);
                        if($resultadosql1=sqlsrv_fetch_array($execsql1)){
                            $id=$resultadosql1["Id"];
                            $resultar["respuesta"]='REGISTRADO';
                            $resultar["id"]=$id;
                            $json[]=$resultar;
                            echo json_encode($json);
                        }else{
                            $consulta="INSERT INTO ANDROID_RECEPCION_CAMIONES(COD_EMP,COD_TEM,Fecha_ingreso,RutConductor,NombreConductor,PROCEDENCIA,Telefono,PRESENTACI,COINCIDECI,Patente,ENTREGATRIP,DESTINO,UsuarioSis_ingreso,Sw_Despachado,ZON, Motivo,AUTORIZADO,TARJETA,Observacion,temperatura,TIPO,NROLICENCIA,SGROVIGENTE,ESTADIACOMPANIA,FECHAINICIOSCTR,FECHATERMINOSCTR,BUENASALUD,OBSERVACIONSALUD,Guia_ingreso)
                            VALUES('{$COD_EMP}','{$COD_TEM}','{$HORAINGRESO}','{$RUT}','{$NOMBRE}','{$PROCEDENCIA}','{$TELEFONO}','{$PRESENTACI}','{$COINCIDECI}','{$PATENTE}','{$ENTREGATRIP}','{$DESTINO}','{$usuario}','0','{$ZON}','{$MOTIVO}','{$AUTORIZADO}','{$TARJETA}','{$OBSERVACION}','{$TEMPERATURA}','VISITA','{$NROLICENCIA}','{$SCRTVIGENTE}','{$ACOMPANADO}','{$FECHAINICIOSCTR}','{$FECHATERMINOSCTR}','{$CUENTACONSALUD}','{$OBSERVACIONSALUD}','{$NGUIA}')";              
                        }
                    }
              
                 
                 }else{
                     
                    $consulta="INSERT INTO ANDROID_RECEPCION_CAMIONES(COD_EMP,COD_TEM,Fecha_ingreso,RutConductor,NombreConductor,PROCEDENCIA,Telefono,PRESENTACI,COINCIDECI,Patente,ENTREGATRIP,DESTINO,UsuarioSis_ingreso,Sw_Despachado,ZON, Motivo,AUTORIZADO,TARJETA,Observacion,temperatura,TIPO,NROLICENCIA,SGROVIGENTE,ESTADIACOMPANIA,FECHAINICIOSCTR,FECHATERMINOSCTR,BUENASALUD,OBSERVACIONSALUD)
                    VALUES('{$COD_EMP}','{$COD_TEM}','{$HORAINGRESO}','{$RUT}','{$NOMBRE}','{$PROCEDENCIA}','{$TELEFONO}','{$PRESENTACI}','{$COINCIDECI}','{$PATENTE}','{$ENTREGATRIP}','{$DESTINO}','{$usuario}','0','{$ZON}','{$MOTIVO}','{$AUTORIZADO}','{$TARJETA}','{$OBSERVACION}','{$TEMPERATURA}','VISITA','{$NROLICENCIA}','{$SCRTVIGENTE}','{$ACOMPANADO}','{$FECHAINICIOSCTR}','{$FECHATERMINOSCTR}','{$CUENTACONSALUD}','{$OBSERVACIONSALUD}')";            
                }
            }else{

                 if($TIPO=="ACTUALIZACION"){
                     $consulta="UPDATE ANDROID_RECEPCION_CAMIONES SET ZON='{$ZON}',COD_EMP='{$COD_EMP}',COD_TEM='{$COD_TEM}',Fecha_ingreso='{$HORAINGRESO}',PRESENTACI='{$PRESENTACI}',COINCIDECI='{$COINCIDECI}',
                     ENTREGATRIP='{$ENTREGATRIP}',UsuarioSis_ingreso='{$usuario}',TARJETA='{$TARJETA}',temperatura='{$TEMPERATURA}' where Id='{$ID}' ";
              
                 }else{
                     $consulta="INSERT INTO ANDROID_RECEPCION_CAMIONES(COD_EMP,COD_TEM,Fecha_ingreso,RutConductor,NombreConductor,PROCEDENCIA,Telefono,PRESENTACI,COINCIDECI,Patente,ENTREGATRIP,DESTINO,UsuarioSis_ingreso,Sw_Despachado,ZON, Motivo,AUTORIZADO,TARJETA,Observacion,temperatura,TIPO)
                     VALUES('{$COD_EMP}','{$COD_TEM}','{$HORAINGRESO}','{$RUT}','{$NOMBRE}','{$PROCEDENCIA}','{$TELEFONO}','{$PRESENTACI}','{$COINCIDECI}','{$PATENTE}','{$ENTREGATRIP}','{$DESTINO}','{$usuario}','0','{$idzona}','{$MOTIVO}','{$AUTORIZADO}','{$TARJETA}','{$OBSERVACION}','{$TEMPERATURA}','VISITA')";
                 }

    
            }
          
          
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