<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

    $usuario=$_GET["usuario"];
    $clave=$_GET["clave"];
         
    $info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    $conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
    if(isset($_GET["idplanillaandroid"])&&isset($_GET["fechaactividad"])&&isset($_GET["idcuadrilla"])&&isset($_GET["idactividad"])&&isset($_GET["idfamilia"])
    &&isset($_GET["idzona"])&&isset($_GET["ciclo"])&&isset($_GET["etapa"])&&isset($_GET["idcuartel"])&&isset($_GET["idempresa"])
    &&isset($_GET["temporada"])){
        
        $idplanillaandroid=$_GET["idplanillaandroid"];
        $fechaactividad=$_GET["fechaactividad"];
        $idcuadrilla=$_GET["idcuadrilla"];
        $idactividad=$_GET["idactividad"];
        $idfamilia=$_GET["idfamilia"];
        $idzona=$_GET["idzona"];
        $ciclo=$_GET["ciclo"];
        $etapa=$_GET["etapa"];
        $idcuartel=$_GET["idcuartel"];
        $idempresa=$_GET["idempresa"];
        $temporada=$_GET["temporada"];



        $consultatrabajadores="SELECT DISTINCT IdEmpresaTrabajador,IdTrabajador
        FROM ActividadTrabajadorAndroid act
        where PLANILLA='{$idplanillaandroid}' and Convert(date,fechaactividad)='{$fechaactividad}' and idcuadrilla='{$idcuadrilla}' 
        and idactividad='{$idactividad}' and idfamilia='{$idfamilia}' and idzona='{$idzona}' and ciclo='{$ciclo}' 
        and etapa='{$etapa}' and idcuartel='{$idcuartel}' and idempresa='{$idempresa}' and temporada='{$temporada}' ";
        

        $mensajeerror='LOS TRABAJADORES  ';
        $salida='TIENEN MAS DE UNA PLANILLA CON REFRIGERIO';

        $resultadotrabajadores=sqlsrv_query($conexion,$consultatrabajadores);


        while ($registro =sqlsrv_fetch_array($resultadotrabajadores)){
                $idempresatrabajador=$registro['IdEmpresaTrabajador'];
				$IdTrabajador=$registro['IdTrabajador'];
				$refrigerio=$registro['REFRIGERIO'];
				$apellidopaterno=$registro['ApellidoPaterno'];
				$apellidomaterno=$registro['ApellidoMaterno'];
				$nombre=$registro['Nombre'];

                $consultamayores="SELECT DISTINCT act.IdEmpresaTrabajador,act.IdTrabajador,COUNT(REFRIGERIO)AS REFRIGERIO,tra.ApellidoPaterno,tra.ApellidoMaterno,tra.Nombre
                    FROM ActividadTrabajadorAndroid act
                    INNER JOIN TRABAJADOR tra ON tra.IdEmpresa=act.IdEmpresa and tra.IdTrabajador=act.IdTrabajador
                    WHERE  CONVERT(VARCHAR,act.FechaActividad,23)='{$fechaactividad}' 
                    AND act.IdEmpresa='{$idempresa}' AND act.Temporada='{$temporada}' AND act.IdEmpresaTrabajador='{$idempresatrabajador}' AND act.IdTrabajador='{$IdTrabajador}'
                    AND act.REFRIGERIO > 0 
                    GROUP BY  act.IdEmpresaTrabajador,act.IdTrabajador,tra.ApellidoPaterno,tra.ApellidoMaterno,tra.Nombre
                    ORDER BY tra.ApellidoPaterno,tra.ApellidoMaterno,tra.Nombre";
                    
                     $resultadomayores=sqlsrv_query($conexion,$consultamayores);
                     if($registromayores =sqlsrv_fetch_array($resultadomayores)){

                        $idempresatrabajadormayor=$registromayores['IdEmpresaTrabajador'];
                        $IdTrabajadormayor=$registromayores['IdTrabajador'];
                        $apellidopaternomayor=$registromayores['ApellidoPaterno'];
                        $apellidomaternomayor=$registromayores['ApellidoMaterno'];
                        $nombremayor=$registromayores['Nombre'];
                        $refrigerio=$registromayores['REFRIGERIO'];
                        
                        if($refrigerio>1){   
                            
                            $trabajador.=$IdTrabajadormayor;
                            $trabajador.=' ';
                            $trabajador.=$apellidopaternomayor;
                            $trabajador.=' ';
                            $trabajador.=$apellidomaternomayor;
                            $trabajador.=' ';
                            $trabajador.=$nombremayor;
                            $trabajador.=' ,';	
                        }else{
                            $consulta="UPDATE ActividadTrabajadorAndroid  set SW_VALIDADO='1'  , fecha_firma='{$fecha_firma}', usuario_firma='{$usuario}'
                            where PLANILLA='{$idplanillaandroid}' and Convert(date,fechaactividad)='{$fechaactividad}' and idcuadrilla='{$idcuadrilla}' 
                            and idactividad='{$idactividad}' and idfamilia='{$idfamilia}' and idzona='{$idzona}' and ciclo='{$ciclo}' 
                            and etapa='{$etapa}' and idcuartel='{$idcuartel}' and idempresa='{$idempresa}' and temporada='{$temporada}' 
                            AND IdEmpresaTrabajador='{$idempresatrabajador}' and IdTrabajador='{$IdTrabajador}'";
                                
                            $resultado=sqlsrv_query($conexion,$consulta);
                             
                            if($resultado){
                                 
                                 $data=array(
                                     'id'=>'PLANILLAS FIRMADAS CORRECTAMENTE'
                                 ); 
                                 $json[]=$data;
                                 echo json_encode($json);
                            }else{
                                 $data=array(
                                     'id'=>'NO REGISTRA'
                                 );
                                 $json[]=$data;
                                 echo json_encode($json); 
                            } 
                        } 
					
				    }
                  

         
        }
		
        $mensaje.=$mensajeerror;
        $mensaje.=$trabajador;
        $mensaje.=$salida;
        
        $data=array(
            'id'=>$mensaje
        ); 
        $json[]=$data;
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