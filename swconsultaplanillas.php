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
    if(isset($_GET["idzona"])&&isset($_GET["fechaactividad"])&&isset($_GET["IdEmpresa"])
    &&isset($_GET["Temporada"])&&isset($_GET["firmados"])&&isset($_GET["IdCuartel"])){
        
        $idzona=$_GET["idzona"];
        $fechaactividad=$_GET["fechaactividad"];
        $IdEmpresa=$_GET["IdEmpresa"];
        $Temporada=$_GET["Temporada"];
        $firmados=$_GET["firmados"];
        $IdCuartel=$_GET["IdCuartel"];
       
        
        $sqlwhere="";

        if($firmados=='SI'){
            $sqlwhere.=" AND act.SW_VALIDADO IS NOT NULL";
        }else{
            $sqlwhere.=" AND act.SW_VALIDADO IS NULL";
        }

        if($IdEmpresa=='9' && $idzona=='55'){
            $sqlwhere.="  AND  act.IdCuartel='{$IdCuartel}'";
        }

       
		$consulta="SELECT act.idcuadrilla,tr.nombre,tr.apellidopaterno,tr.apellidomaterno
		from ActividadTrabajadorAndroid act
		inner join cuadrilla cu on cu.idcuadrilla=act.IdCuadrilla and cu.Idempresa=act.idempresa
		inner join Trabajador tr on cu.IdTrabajador_Enc=tr.idtrabajador and cu.idempresa=tr.idempresa
        where act.idzona='{$idzona}' and act.IdEmpresa='{$IdEmpresa}' and act.Temporada='{$Temporada}' and Convert(date,act.fechaactividad)='{$fechaactividad}' ".$sqlwhere. "
        GROUP BY act.idcuadrilla,tr.nombre,tr.apellidopaterno,tr.apellidomaterno";
        
       
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