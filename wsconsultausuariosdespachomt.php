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
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["FECHA"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $FECHA=$_GET["FECHA"];
       
		
		$consulta="SELECT DISTINCT USUARIO,[Trabajador]=T.ApellidoPaterno+' '+T.ApellidoMaterno+' '+T.Nombre
        FROM DESPACHOMATERIALES_ANDROID DA
        INNER JOIN bsis_rem_afr.dbo.trabajador T on T.UsuarioSis=DA.USUARIO
        WHERE DA.COD_EMP='{$COD_EMP}' AND DA.COD_TEM='{$COD_TEM}' AND DA.FECHA='{$FECHA}'";
		
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