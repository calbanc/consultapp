<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
		 
	$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	
	$fecha=date('d-m-Y');
	//and '{$fecha}'  BETWEEN FECHAINICIO AND ISNULL(isnull(fechatermino,FECHATERMINOc),GETDATE())
	        
				$consulta="SELECT DISTINCT C.IdTrabajador AS CodigoTrabajador,t.ApellidoPaterno+' '+t.ApellidoMaterno+' '+ t.Nombre as DATOTRABAJADOR
				,CASE e.DECIMAL when 0 THEN ltrim(str(t.RutTrabajador)) + ' ' + Digito ELSE replicate('0', Tdi.LARGO - Len(T.RUTTRABAJADOR))+LEFT(T.RUTTRABAJADOR,Tdi.LARGO) END as DNI,
				t.IdEmpresa,C.IndicadorVigencia
				FROM Contratos C WITH(NOLOCK)                     
				INNER JOIN Trabajador T WITH(NOLOCK) ON T.IdEmpresa=C.IdEmpresa AND T.IdTrabajador=C.IdTrabajador   
				INNER JOIN EMPRESA E ON E.IDEMPRESA=C.IDEMPRESA and E.IdEmpresa=T.IdEmpresa
				LEFT join TipoDctoIden tdi on  tdi.idempresa=t.idempresa and tdi.IdTipoDctoIden=t.IdTipoDctoIden ,dbo.Contratos
				WHERE C.IdEmpresa in (9,14)  AND '{$fecha}' BETWEEN C.FECHAINICIO AND ISNULL(ISNULL(C.FECHATERMINO,C.FECHATERMINOC),GETDATE())  and c.jornal='1'";
		
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
		}

		
		echo json_encode($json);
		

	

}else{
	echo "CONEXION FALLIDA";
}
}else{
	$resultar["message"]='Sin usuario';
	$json[]=$resultar;
	echo json_encode($json);
} 
	
?>