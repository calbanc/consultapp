<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["idtrabajador"])&&isset($_GET["IdEmpresa"])){
        
        $idtrabajador=$_GET["idtrabajador"];
        $IdEmpresa=$_GET["IdEmpresa"];
        
		
		$consulta="SELECT cont.idcuartel
        from contratos cont
        inner join trabajador trab on trab.idempresa=cont.idempresa and trab.idtrabajador=cont.idtrabajador and trab.IdEmpresa=cont.IdEmpresa
        where cont.idtrabajador='{$idtrabajador}' and cont.indicadorvigencia='1' and cont.IdEmpresa='{$IdEmpresa}'";
		
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