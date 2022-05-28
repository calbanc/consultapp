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
	if(isset($_GET["LOTE"])&&isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])){
        
        $LOTE=$_GET["LOTE"];
        $COD_EMP=$_GET["COD_EMP"];
		$COD_TEM=$_GET["COD_TEM"];
	
       
		
		$consulta="  SELECT em.NOM_EMP,cs.COD_TEM,esp.NOM_ESP,var.NOM_VAR,pr.NOM_PRO,cu.DESCRIPCION,cs.CANTIDAD
        from COSECHA_HUERTO cs
        INNER JOIN EMPRESAS em ON em.COD_EMP=cs.COD_EMP
        INNER JOIN ESPECIE esp ON esp.COD_EMP=cs.COD_EMP and esp.COD_TEM=cs.COD_TEM and esp.COD_ESP=cs.COD_ESP
        INNER JOIN VARIEDAD var ON var.COD_EMP=cs.COD_EMP and var.COD_TEM=cs.COD_TEM and var.COD_ESP=cs.COD_ESP and var.COD_VAR=cs.COD_VAR
        INNER JOIN PRODUCTORES pr ON pr.COD_EMP=cs.COD_EMP and pr.COD_TEM=cs.COD_TEM and pr.COD_PRO=cs.COD_PRO
        INNER JOIN CUARTELES cu ON cu.COD_EMP=cs.COD_EMP AND cu.COD_TEM=cs.COD_TEM and cu.COD_PRO=cs.COD_PRO and cu.COD_PRE=cs.COD_PRE and cu.COD_CUA=cs.COD_CUA
        WHERE cs.LOTE='{$LOTE}' and cs.COD_EMP='{$COD_EMP}' and cs.COD_TEM='{$COD_TEM}'";
		
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