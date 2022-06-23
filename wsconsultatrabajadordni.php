<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["DNI"])){
        $DNI=$_GET["DNI"];

				$consulta="SELECT DISTINCT t.IdTrabajador AS CodigoTrabajador,t.ApellidoPaterno+' '+t.ApellidoMaterno+' '+ t.Nombre as DATOTRABAJADOR,
				CASE e.DECIMAL when 0 THEN ltrim(str(t.RutTrabajador)) + ' ' + Digito ELSE replicate('0', Tdi.LARGO - Len(T.RUTTRABAJADOR))+LEFT(T.RUTTRABAJADOR,Tdi.LARGO) END as DNI,
				t.IdEmpresa
				FROM Trabajador t WITH(NOLOCK)
				INNER JOIN EMPRESA E ON E.IDEMPRESA=T.IDEMPRESA
				INNER JOIN CONTRATOS C WITH(NOLOCK) ON C.IDEMPRESA = T.IDEMPRESA AND C.IdTrabajador = T.IdTrabajador AND C.IndicadorVigencia=1
				left join TipoDctoIden tdi on  tdi.idempresa=t.idempresa and tdi.IdTipoDctoIden=t.IdTipoDctoIden ,dbo.Contratos
				WHERE   Contratos.IndicadorVigencia=1  and CASE e.DECIMAL when 0 THEN ltrim(str(t.RutTrabajador)) + ' ' + Digito ELSE replicate('0', Tdi.LARGO - Len(T.RUTTRABAJADOR))+LEFT(T.RUTTRABAJADOR,Tdi.LARGO) END='{$DNI}'";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
		}

		
		echo json_encode($json);
		

    }else{
		$resultar["message"]='Faltan datos';
		$json[]=$resultar;
		echo json_encode($json);
	}

	



}else{
	echo "CONEXION FALLIDA";
}
	
?>