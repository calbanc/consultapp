<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["idzona"])&&isset($_GET["fechaactividad"])&&isset($_GET["IDPLANILLAANDROID"])&&isset($_GET["IDCUADRILLA"])&&isset($_GET["ciclo"])&&isset($_GET["IdEmpresa"])&&isset($_GET["Temporada"])&&isset($_GET["IdCuartel"])){
        
        $idzona=$_GET["idzona"];
        $fechaactividad=$_GET["fechaactividad"];
        $IDPLANILLAANDROID=$_GET["IDPLANILLAANDROID"];
        $IDCUADRILLA=$_GET["IDCUADRILLA"];
        $ciclo=$_GET["ciclo"];
        $IdEmpresa=$_GET["IdEmpresa"];
        $Temporada=$_GET["Temporada"];
        $IdCuartel=$_GET["IdCuartel"];
		
		$consulta=" SELECT act.IdActividad,ac.Nombre as NombreLabor,act.IdFamilia,fact.Nombre as NombreActividad,act.IdEmpresa,emp.Nombre as NombreEmpresa,
        act.Temporada,act.IdCuartel,ct.Nombre,act.IdZona,zn.nombre as NombreZona,CONVERT(VARCHAR(10), act.FechaActividad,23) as FechaActividad,Convert (VARCHAR(8),act.HoraInicio,108)as HoraInicio,Convert (VARCHAR(8),act.HoraFinal,108)as HoraFinal,act.IdCuadrilla,
        cu.IdTrabajador_Enc,tr.nombre,tr.apellidopaterno,tr.apellidomaterno,act.Ciclo,act.USUARIO,act.COD_BUS,act.ETAPA,act.POR_TAREA,act.IDPLANILLAANDROID,
        act.SW_VALIDADO,act.IdTrabajador,tra.ApellidoPaterno,tra.ApellidoMaterno,tra.Nombre,
		REPLICATE('0', TipoDctoIden.Largo - LEN( tra.RutTrabajador)) + LEFT(tra.RutTrabajador, TipoDctoIden.Largo)as Dni,act.UnidadProducida,act.IdActividadTrabajador
        FROM ActividadTrabajadorAndroid act
        left join cuartel ct on ct.idcuartel=act.idcuartel and ct.idempresa=act.idempresa and ct.IdZona=act.IdZona
        inner join FamiliaActividades fact on fact.IdFamilia=act.idfamilia and fact.idempresa=act.idempresa	
        inner join actividades ac on ac.idfamilia=act.IdFamilia and ac.IdEmpresa=act.IdEmpresa and ac.IdActividad=act.idactividad
        inner join Empresa emp on emp.IdEmpresa=act.idempresa
        inner join Zona zn on zn.idzona=act.idzona and zn.idempresa=act.idempresa
        inner join cuadrilla cu on cu.idcuadrilla=act.IdCuadrilla and cu.Idempresa=act.idempresa
        inner join Trabajador tr on cu.IdTrabajador_Enc=tr.idtrabajador and cu.idempresa=tr.idempresa
		inner join Trabajador tra on tra.IdTrabajador=act.IdTrabajador and tra.idempresa=act.IdEmpresaTrabajador
		INNER JOIN TipoDctoIden   ON  TipoDctoIden.IdEmpresa = tra.IdEmpresa AND TipoDctoIden.IdTipoDctoIden =tra.IdTipoDctoIden
        where act.idzona='{$idzona}' and Convert(date,act.fechaactividad)='{$fechaactividad}' and act.SW_VALIDADO is null and act.PLANILLA='{$IDPLANILLAANDROID}' AND act.IDCUADRILLA='{$IDCUADRILLA}' and act.ciclo='{$ciclo}' and act.IdEmpresa='{$IdEmpresa}' and act.Temporada='{$Temporada}' and act.IdCuartel='{$IdCuartel}'";
		
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