<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

$usuario=$_GET["usuario"];
$clave=$_GET["clave"];
	 
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

	if($conexion){
	$json=array();
		if(isset($_GET["fechaactividad"])&&isset($_GET["idzona"])&&isset($_GET["IdCuartel"])&&isset($_GET["IdEmpresa"])
   		 &&isset($_GET["Temporada"])){
        
			$fechaactividad=$_GET["fechaactividad"];
			$idzona=$_GET["idzona"];
			$IdCuartel=$_GET["IdCuartel"];
			$Idcuadrilla=$_GET["Idcuadrilla"];
			$IdEmpresa=$_GET["IdEmpresa"];
			$Temporada=$_GET["Temporada"];
			$fecha_firma=date('d/m/Y H:i:s',time());
			$sqlwhere="";
			$sqlwherebusqueda="";

			if($Idcuadrilla!='TODOS'){
				$sqlwhere.=" AND IdCuadrilla='{$Idcuadrilla}'";
			}
			if($IdEmpresa=='9' && $idzona=='55'){
				$sqlwhere.="  AND  IdCuartel='{$IdCuartel}'";
			}
			
			if($IdEmpresa=='9' && $idzona=='55'){
				$sqlwherebusqueda.="  AND  act.IdCuartel='{$IdCuartel}'";
			}

			$consultatrabajadores="SELECT DISTINCT act.IdEmpresaTrabajador,act.IdTrabajador,COUNT(REFRIGERIO)AS REFRIGERIO,tra.ApellidoPaterno,tra.ApellidoMaterno,tra.Nombre
			FROM ActividadTrabajadorAndroid act
			INNER JOIN TRABAJADOR tra ON tra.IdEmpresa=act.IdEmpresa and tra.IdTrabajador=act.IdTrabajador
			WHERE  CONVERT(VARCHAR,act.FechaActividad,23)='{$fechaactividad}' 
			AND act.IdEmpresa='{$IdEmpresa}' AND act.Temporada='{$Temporada}'  AND act.IdZona='{$idzona}'  " .$sqlwherebusqueda." AND act.REFRIGERIO > 0 
			GROUP BY  act.IdEmpresaTrabajador,act.IdTrabajador,tra.ApellidoPaterno,tra.ApellidoMaterno,tra.Nombre
			ORDER BY tra.ApellidoPaterno,tra.ApellidoMaterno,tra.Nombre";
			
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
								
				if($refrigerio>1){
					$trabajador.=$IdTrabajador;
					$trabajador.=' ';
					$trabajador.=$apellidopaterno;
					$trabajador.=' ';
					$trabajador.=$apellidomaterno;
					$trabajador.=' ';
					$trabajador.=$nombre;
					$trabajador.=' ,';	
					
				}else{
					$consulta="UPDATE ActividadTrabajadorAndroid SET SW_VALIDADO='1' , fecha_firma='{$fecha_firma}', usuario_firma='{$usuario}'
					WHERE  CONVERT(VARCHAR,FechaActividad,23)='{$fechaactividad}' 
					AND IdEmpresa='{$IdEmpresa}' AND Temporada='{$Temporada}'  AND IdZona='{$idzona}' AND IdEmpresaTrabajador='{$idempresatrabajador}' and IdTrabajador='{$IdTrabajador}' " .$sqlwhere."";
					
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


			$mensaje.=$mensajeerror;
				$mensaje.=$trabajador;
				$mensaje.=$salida;
				
				$data=array(
					'id'=>$mensaje
				); 
				$json[]=$data;
				echo json_encode($json);
		
				
		

		}else{
			$resultar["id"]='Ws no Retorna';
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