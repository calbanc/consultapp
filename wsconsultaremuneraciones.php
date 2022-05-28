<?PHP
$hostname_localhost="192.168.2.210";

if(isset($_GET["UsuarioSis"])&&isset($_GET["clave"])){

	$UsuarioSis=$_GET["UsuarioSis"];
	$clave=$_GET["clave"];
	$info=array("Database"=>"bsis_rem_afr","UID"=>$UsuarioSis,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
	


$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["UsuarioSis"])&&isset($_GET["IdEmpresa"])){
        
        $UsuarioSis=$_GET["UsuarioSis"];
        $IdEmpresa=$_GET["IdEmpresa"];

		
			$consulta="SELECT t.IdTrabajador,t.Nombre,t.ApellidoPaterno,t.ApellidoMaterno,u.IdZona,t.UsuarioSis,u.IdAplicacion,zon.Nombre as ZONANOMBRE,t.IdEmpresa,cua.idcuadrilla,cont.IdCuartel
			FROM [bsis_rem_afr].[dbo].[Trabajador] t
			inner join bpriv.dbo.ZONAS_USUARIOS u on u.IdUsuario=t.UsuarioSis and u.idempresa=t.idempresa
			inner join bsis_rem_afr.dbo.Zona zon on zon.IdZona=u.IdZona and zon.IdEmpresa=u.IdEmpresa
			left join bsis_rem_afr.dbo.Cuadrilla cua on cua.IdTrabajador_Enc=t.IdTrabajador and t.idempresa=cua.idempresa
			inner join Contratos cont on cont.IdEmpresa=t.IdEmpresa and cont.IdTrabajador=t.IdTrabajador
			where t.UsuarioSis='{$UsuarioSis}' and IdAplicacion='AppRemu' and u.IdEmpresa='{$IdEmpresa}' and cont.IndicadorVigencia='1' ORDER BY IdCuadrilla DESC";
		

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