<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

        $usuario=$_GET["usuario"];
        $clave=$_GET["clave"];
        
        $info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
        $conexion = sqlsrv_connect($hostname_localhost,$info);
        if($conexion){
            $json=array();
           
            if(isset($_GET["IDEMPRESA"])&&isset($_GET["IDZONA"])&&isset($_GET["IDACTIVIDAD"])&&isset($_GET["IDLABOR"])
            &&isset($_GET["IDCUARTEL"])&&isset($_GET["IDTIPOTRABAJADOR"])&&isset($_GET["CANTIDAD"])&&isset($_GET["TURNO"])&&isset($_GET["UNICO"])
            &&isset($_GET["FECHA"])&&isset($_GET["ETAPA"])){
              
                $IDEMPRESA=$_GET["IDEMPRESA"];
                $IDZONA=$_GET["IDZONA"];
                $IDACTIVIDAD=$_GET["IDACTIVIDAD"];
                $IDLABOR=$_GET["IDLABOR"];
                $IDCUARTEL=$_GET["IDCUARTEL"];
                $IDTIPOTRABAJADOR=$_GET["IDTIPOTRABAJADOR"];
                $CANTIDAD=$_GET["CANTIDAD"];
                $TURNO=$_GET["TURNO"];
                $UNICO=$_GET["UNICO"];
                $FECHA=$_GET["FECHA"];
                $ETAPA=$_GET["ETAPA"];
                $DATO=  explode("/",$FECHA);
                $MES=$DATO[1];
                $AÑO=$DATO[2];


                $dtz = new DateTimeZone("America/Lima");
                $dt = new DateTime("now", $dtz);

//Stores time as "2021-04-04T13:35:48":
                $fecharegistro = $dt->format("Y-m-d") . "T" . $dt->format("H:i:s");
                
             
                $consultaantes="SELECT Correlativo FROM AsistenciaRapida WITH(NOLOCK) WHERE IdEmpresa='{$IDEMPRESA}' AND FechaActividad='{$FECHA}'
                 AND Año='{$AÑO}' AND MES='{$MES}' AND  IdZona='{$IDZONA}' AND IdFamilia='{$IDACTIVIDAD}' AND IdActividad='{$IDLABOR}' AND IdCuartel='{$IDCUARTEL}' 
                 AND TipoTrabajador='{$IDTIPOTRABAJADOR}' AND TURNO='{$TURNO}'  ";

              
                $resultadoantes=sqlsrv_query($conexion,$consultaantes);
                if($registross=sqlsrv_fetch_array($resultadoantes)){
                   
                    $Correlativo=$registross['Correlativo'];
                   if($Correlativo==""){
                      
                   }else{
                        $data=array('Llave'=>$UNICO); 
                        $json[]=$data;
                        echo json_encode($json);
                   }
                

                }else{
                  
                    //debemos insertar registro
                  $consultamax="SELECT ISNULL(MAX (CORRELATIVO),0) +1 AS 'Id' FROM AsistenciaRapida";
                  $resultadomax=sqlsrv_query($conexion,$consultamax);
                  if($registromax=sqlsrv_fetch_array($resultadomax)){
                    $nuevocorrelativo=$registromax['Id'];
                  
                    $insert="INSERT INTO AsistenciaRapida(IdEmpresa,Año,Mes,IdZona,Correlativo,IdFamilia,IdActividad,Cantidad,FechaActividad,IdCuartel,TipoTrabajador,Turno,Sw_App,ETAPA,IdUsuario,FechaRegistro) 
                    VALUES('{$IDEMPRESA}','{$AÑO}','{$MES}','{$IDZONA}','{$nuevocorrelativo}','{$IDACTIVIDAD}','{$IDLABOR}','{$CANTIDAD}','{$FECHA}','{$IDCUARTEL}','{$IDTIPOTRABAJADOR}','{$TURNO}','1','{$ETAPA}','{$usuario}','{$fecharegistro}')";

                   

                    $resultado=sqlsrv_query($conexion,$insert);
                    if($resultado){
                        $data=array('Llave'=>$UNICO); 
                        $json[]=$data;
                        echo json_encode($json);

                    } 


  
                  }
                  
       
                }
            } else{
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