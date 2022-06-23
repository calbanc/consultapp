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
	if(isset($_GET["IdEmpresa"])){
        
	
		$IdEmpresa=$_GET["IdEmpresa"];
		
		
		if($IdEmpresa=='9' || $IdEmpresa=='14'){
			
		 	$consulta="SELECT DISTINCT t.IdTrabajador AS CodigoTrabajador,t.ApellidoPaterno+' '+t.ApellidoMaterno+' '+ t.Nombre as DATOTRABAJADOR,
			CASE e.DECIMAL when 0 THEN ltrim(str(t.RutTrabajador)) + ' ' + Digito ELSE replicate('0', Tdi.LARGO - Len(T.RUTTRABAJADOR))+LEFT(T.RUTTRABAJADOR,Tdi.LARGO) END as DNI,
			t.IdEmpresa,Contratos.IndicadorVigencia,OFI.Descripcion as 'OFICIO'
			FROM Trabajador t WITH(NOLOCK)
			INNER JOIN EMPRESA E ON E.IDEMPRESA=T.IDEMPRESA
			INNER JOIN CONTRATOS C WITH(NOLOCK) ON C.IDEMPRESA = T.IDEMPRESA AND C.IdTrabajador = T.IdTrabajador AND C.IndicadorVigencia=1
			INNER JOIN Oficio OFI WITH(NOLOCK) ON OFI.IdEmpresa=C.IDEMPRESA and OFI.IdOficio=C.IdOficio
			LEFT JOIN TipoDctoIden tdi on  tdi.idempresa=t.idempresa and tdi.IdTipoDctoIden=t.IdTipoDctoIden ,dbo.Contratos      
			WHERE   Contratos.IndicadorVigencia=1  and T.IdEmpresa='{$IdEmpresa}'";

				 
		}else{
			$consulta="SELECT DISTINCT t.IdTrabajador AS CodigoTrabajador,t.ApellidoPaterno+' '+t.ApellidoMaterno+' '+ t.Nombre as DATOTRABAJADOR,
			CASE E.DECIMAL WHEN 0 THEN REPLICATE('0', TDI.LARGO - LEN(T.RUTTRABAJADOR))+LEFT(T.RUTTRABAJADOR,TDI.LARGO)END AS DNI,
			t.IdEmpresa,Contratos.IndicadorVigencia,AC.Nombre as 'OFICIO'
			FROM Trabajador t WITH(NOLOCK)
			INNER JOIN EMPRESA E ON E.IDEMPRESA=T.IDEMPRESA
			INNER JOIN CONTRATOS C WITH(NOLOCK) ON C.IDEMPRESA = T.IDEMPRESA AND C.IdTrabajador = T.IdTrabajador AND C.IndicadorVigencia=1
			INNER JOIN Actividades AC WITH(NOLOCK) ON  C.IdActividad=AC.IdActividad AND C.IdEmpresa=AC.IdEmpresa AND AC.IdFamilia=C.IdFamilia
			LEFT JOIN TipoDctoIden tdi on  tdi.idempresa=t.idempresa and tdi.IdTipoDctoIden=t.IdTipoDctoIden ,dbo.Contratos      
			WHERE   Contratos.IndicadorVigencia=1  and T.IdEmpresa='{$IdEmpresa}'";
				
		}

		

		
		
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
