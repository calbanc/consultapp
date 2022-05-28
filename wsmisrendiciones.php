<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
    $clave=$_GET["clave"];
    
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    

$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["IDTRABAJADOR"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
		$IDTRABAJADOR=$_GET["IDTRABAJADOR"];
     
		
		$consulta="SELECT [Empresa]= E.NOM_EMP,[Temporada]=R.COD_TEM,[IdRendidior]=R.IDTRABAJADOR, [Rendidor]=T.NOMBRE+' '+T.APELLIDOPATERNO+' '+T.APELLIDOMATERNO,[NRendicion]=convert(int,R.NRENDICION),[Total]=SUM(R.TOTAL)
        FROM APP_TRANSRENDICIONESCHOFERES R
        INNER JOIN EMPRESAS E ON E.COD_EMP=R.COD_EMP
        INNER JOIN Bsis_Rem_Afr.dbo.Trabajador T ON T.IDEMPRESA=E.ID_EMPRESA_REM AND T.IDTRABAJADOR=R.IDTRABAJADOR
        INNER JOIN Bsis_Rem_Afr.dbo.Contratos C WITH(NOLOCK) ON T.IdTrabajador = C.IdTrabajador AND T.IdEmpresa = C.IdEmpresa  and r.fecha BETWEEN c.fechainicio and isnull(c.fechatermino,isnull(c.fechaterminoc,getDATE()))
        left JOIN BSIS_REM_AFR.DBO.TRABAJADOR JD WITH(NOLOCK) ON c.IDEMPRESA_JEFEDIRECTO=JD.IDEMPRESA AND c.IDJEFEDIRECTO=JD.IDTRABAJADOR
        WHERE R.COD_EMP='{$COD_EMP}' AND R.COD_TEM='{$COD_TEM}'  and  R.IDTRABAJADOR='{$IDTRABAJADOR}' and R.APROBACION='0'
        GROUP BY R.NRENDICION,E.NOM_EMP,R.COD_TEM,R.IDTRABAJADOR,T.Nombre,T.ApellidoPaterno,T.ApellidoMaterno
        ORDER BY NRendicion DESC";

		
		
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