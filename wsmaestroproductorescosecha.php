<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["cod_emp"])&&isset($_GET["cod_tem"])){
        
        $cod_emp=$_GET["cod_emp"];
        $cod_tem=$_GET["cod_tem"];
		
		$consulta="SELECT p.COD_EMP,p.COD_TEM,p.COD_PRO,pr.NOM_PRO,p.COD_PRE,c.COD_CUA,c.DESCRIPCION,c.COD_VAR,v.NOM_VAR,e.COD_ESP,e.NOM_ESP,PRI.COD_INSCRIPCION,c.PLANTAS,c.COD_GRP_CUARTEL,gc.DESCRIPCION AS 'NOMBREGRUPO'
        from predios p 
        inner join cuarteles c on c.cod_emp=p.cod_emp and c.cod_tem=p.cod_tem and c.cod_pro=p.cod_pro and c.cod_pre=p.cod_pre and c.ESTADO<>'A' and c.ASOCIADO_SUELO='1'
        inner join ESPECIE e on e.COD_EMP=p.COD_EMP and e.COD_TEM=p.COD_TEM and e.COD_ESP=c.COD_ESP
        inner join VARIEDAD v on v.COD_EMP=p.COD_EMP and v.COD_TEM=p.COD_TEM and v.COD_ESP=c.COD_ESP and v.COD_VAR=c.COD_VAR
        inner join PRODUCTORES pr on pr.COD_PRO=c.COD_PRO AND pr.COD_EMP=p.COD_EMP and pr.COD_TEM=p.COD_TEM
        LEFT JOIN PREDIOS_INSPECCION PRI ON PRI.COD_EMP=c.COD_EMP AND PRI.COD_TEM=c.COD_TEM AND PRI.COD_CUA=c.COD_CUA AND PRI.COD_PRO=c.COD_PRO AND pri.COD_PRE=c.COD_PRE
		LEFT JOIN GRUPO_CUARTELES gc on gc.COD_EMP=c.COD_EMP and gc.COD_TEM=c.COD_TEM and gc.COD_GRP_CUARTEL=c.COD_GRP_CUARTEL
        where c.cod_emp='{$cod_emp}' and c.cod_tem='{$cod_tem}'";


		
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