<?PHP
$hostname_localhost="192.168.2.210";if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["idzona"])&&isset($_GET["fechaactividad"])&&isset($_GET["IdEmpresa"])
    &&isset($_GET["Temporada"])&&isset($_GET["Temporada"])&&isset($_GET["IdCuartel"])&&isset($_GET["firmados"])&&isset($_GET["Idcuadrilla"])){
        
        $idzona=$_GET["idzona"];
        $fechaactividad=$_GET["fechaactividad"];
        $IdEmpresa=$_GET["IdEmpresa"];
        $Temporada=$_GET["Temporada"];
        $firmados=$_GET["firmados"];
        $IdCuartel=$_GET["IdCuartel"];
        $Idcuadrilla=$_GET["Idcuadrilla"];
        $sqlwhere="";

        if($firmados=='SI'){
            $sqlwhere.=" AND act.SW_VALIDADO IS NOT NULL";
        }else{
            $sqlwhere.=" AND act.SW_VALIDADO IS NULL";
        }

        if($IdEmpresa=='9' && $idzona=='55'){
            $sqlwhere.="  AND  act.IdCuartel='{$IdCuartel}'";
        }
        if($Idcuadrilla!='TODOS'){
            $sqlwhere.="  AND  act.Idcuadrilla='{$Idcuadrilla}'";
        }

		
		$consulta="SELECT act.IdActividad,ac.Nombre as NombreLabor,act.IdFamilia,fact.Nombre as NombreActividad,act.IdEmpresa,emp.Nombre as NombreEmpresa,
        act.Temporada,act.IdCuartel,ct.Nombre,act.IdZona,zn.nombre as NombreZona,CONVERT(VARCHAR(10), act.FechaActividad,23) as FechaActividad,act.IdCuadrilla,
        cu.IdTrabajador_Enc,tr.nombre,tr.apellidopaterno,tr.apellidomaterno,act.Ciclo,act.USUARIO,act.COD_BUS,act.ETAPA,act.POR_TAREA,act.PLANILLA AS IDPLANILLAANDROID,
        act.SW_VALIDADO,count(act.idtrabajador)as cantidadTrabajadores,sum(act.unidadproducida) as rendimientoTotal,CONVERT(VARCHAR(10),act.HoraInicio,8) AS 'HoraInicio',CONVERT(VARCHAR(10),act.HoraFinal,8) AS 'HoraFinal',REFRIGERIO
        FROM ActividadTrabajadorAndroid act
        LEFT JOIN cuartel ct on ct.idcuartel=act.idcuartel and ct.idempresa=act.idempresa and ct.IdZona=act.IdZona
        INNER JOIN FamiliaActividades fact on fact.IdFamilia=act.idfamilia and fact.idempresa=act.idempresa
        INNER JOIN actividades ac on ac.idfamilia=act.IdFamilia and ac.IdEmpresa=act.IdEmpresa and ac.IdActividad=act.idactividad
        INNER JOIN Empresa emp on emp.IdEmpresa=act.idempresa
        INNER JOIN Zona zn on zn.idzona=act.idzona and zn.idempresa=act.idempresa
        INNER JOIN cuadrilla cu on cu.idcuadrilla=act.IdCuadrilla and cu.Idempresa=act.idempresa
        INNER JOIN Trabajador tr on cu.IdTrabajador_Enc=tr.idtrabajador and cu.idempresa=tr.idempresa
        WHERE act.IdEmpresa='{$IdEmpresa}' and act.Temporada='{$Temporada}' and act.idzona='{$idzona}' and Convert(date,act.fechaactividad)='{$fechaactividad}'  " .$sqlwhere. "
        group by act.IdActividad,ac.Nombre,act.IdFamilia,fact.Nombre ,act.IdEmpresa,emp.Nombre,act.Temporada,act.IdCuartel,ct.Nombre,act.IdZona,zn.nombre,
        act.FechaActividad,act.IdCuadrilla,cu.IdTrabajador_Enc,tr.nombre,tr.apellidopaterno,tr.apellidomaterno,act.Ciclo,act.USUARIO,act.COD_BUS,
        act.ETAPA,act.POR_TAREA,act.PLANILLA,act.SW_VALIDADO,HoraInicio,HoraFinal,REFRIGERIO";

      
		
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
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
}
	
?>