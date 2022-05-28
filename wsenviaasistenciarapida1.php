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


                $fecharegistro = $dt->format("Y-m-d") . "T" . $dt->format("H:i:s");
                
                $insert="INSERT INTO ANDROID_AsistenciaRapida(IdEmpresa,Año,Mes,IdZona,Llave,IdFamilia,IdActividad,Cantidad,FechaActividad,IdCuartel,TipoTrabajador,Turno,ETAPA,IdUsuario,FechaRegistro, SW_Aprobado) 
                VALUES('{$IDEMPRESA}','{$AÑO}','{$MES}','{$IDZONA}','{$UNICO}','{$IDACTIVIDAD}','{$IDLABOR}','{$CANTIDAD}','{$FECHA}','{$IDCUARTEL}','{$IDTIPOTRABAJADOR}','{$TURNO}','{$ETAPA}','{$usuario}','{$fecharegistro}','0')";

                
                $resultado=sqlsrv_query($conexion,$insert);
                if($resultado){
                    $resultar["Llave"]=$UNICO;
                    $json[]=$resultar;
                    echo json_encode($json);

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