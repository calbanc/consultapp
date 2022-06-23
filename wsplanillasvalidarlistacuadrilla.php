<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["idzona"])&&isset($_GET["fechaactividad"])&&isset($_GET["IdCuadrilla"])){
        
        $idzona=$_GET["idzona"];
        $fechaactividad=$_GET["fechaactividad"];
       
        $IdCuadrilla=$_GET["IdCuadrilla"];
		
		$consulta="SELECT act.IdActividad,ac.Nombre as NombreLabor,act.IdFamilia,fact.Nombre as NombreActividad,act.IdEmpresa,emp.Nombre as NombreEmpresa,
        act.Temporada,act.IdCuartel,ct.Nombre,act.IdZona,zn.nombre as NombreZona,CONVERT(VARCHAR(10), act.FechaActividad,23) as FechaActividad,act.IdCuadrilla,
        cu.IdTrabajador_Enc,tr.nombre,tr.apellidopaterno,tr.apellidomaterno,act.Ciclo,act.USUARIO,act.COD_BUS,act.ETAPA,act.POR_TAREA,act.IDPLANILLAANDROID,
        act.SW_VALIDADO,count(act.idtrabajador)as cantidadTrabajadores,sum(act.unidadproducida) as rendimientoTotal
        FROM ActividadTrabajadorAndroid act
        left join cuartel ct on ct.idcuartel=act.idcuartel and ct.idempresa=act.idempresa and ct.IdZona=act.IdZona
        inner join FamiliaActividades fact on fact.IdFamilia=act.idfamilia and fact.idempresa=act.idempresa
        inner join actividades ac on ac.idfamilia=act.IdFamilia and ac.IdEmpresa=act.IdEmpresa and ac.IdActividad=act.idactividad
        inner join Empresa emp on emp.IdEmpresa=act.idempresa
        inner join Zona zn on zn.idzona=act.idzona and zn.idempresa=act.idempresa
        inner join cuadrilla cu on cu.idcuadrilla=act.IdCuadrilla and cu.Idempresa=act.idempresa
        inner join Trabajador tr on cu.IdTrabajador_Enc=tr.idtrabajador and cu.idempresa=tr.idempresa
        where act.idzona='{$idzona}' and Convert(date,act.fechaactividad)='{$fechaactividad}' and act.IdCuadrilla='{$IdCuadrilla}' and act.SW_VALIDADO is null 
        group by act.IdActividad,ac.Nombre,act.IdFamilia,fact.Nombre ,act.IdEmpresa,emp.Nombre,act.Temporada,act.IdCuartel,ct.Nombre,act.IdZona,zn.nombre,
        act.FechaActividad,act.IdCuadrilla,cu.IdTrabajador_Enc,tr.nombre,tr.apellidopaterno,tr.apellidomaterno,act.Ciclo,act.USUARIO,act.COD_BUS,
        act.ETAPA,act.POR_TAREA,act.IDPLANILLAANDROID,act.SW_VALIDADO";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
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
	
?>