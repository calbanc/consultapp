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
	if(isset($_GET["cod_emp"])&&isset($_GET["cod_tem"])){
        
        $cod_emp=$_GET["cod_emp"];
        $cod_tem=$_GET["cod_tem"];
		
		$consulta="SELECT p.COD_EMP,p.COD_TEM,p.COD_PRO,pr.NOM_PRO,p.COD_PRE,c.COD_CUA,c.DESCRIPCION,c.COD_VAR,v.NOM_VAR,e.COD_ESP,e.NOM_ESP
        from predios p 
        inner join cuarteles c on c.cod_emp=p.cod_emp and c.cod_tem=p.cod_tem and c.cod_pro=p.cod_pro and c.cod_pre=p.cod_pre
        inner join ESPECIE e on e.COD_EMP=p.COD_EMP and e.COD_TEM=p.COD_TEM and e.COD_ESP=c.COD_ESP
        inner join VARIEDAD v on v.COD_EMP=p.COD_EMP and v.COD_TEM=p.COD_TEM and v.COD_ESP=c.COD_ESP and v.COD_VAR=c.COD_VAR
        inner join PRODUCTORES pr on pr.COD_PRO=c.COD_PRO AND pr.COD_EMP=p.COD_EMP and pr.COD_TEM=p.COD_TEM
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
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
} 
	
?>