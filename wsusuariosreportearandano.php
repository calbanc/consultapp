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
	if(isset($_GET["fecha"])){
        $FECHAHASTA=$_GET["fechahasta"];

        $FECHA=$_GET["fecha"];
		$where="";
		if(empty($FECHAHASTA)||$FECHAHASTA==="TODOS"){
			$where="WHERE ACHD.FECHA BETWEEN '{$FECHA}' AND '{$FECHA}' ";
		}else{
			$where="WHERE ACHD.FECHA BETWEEN '{$FECHA}' AND '{$FECHAHASTA}' ";
		}
        
        $consulta="SELECT DISTINCT ACHD.USUARIO, [Trabajador]=t.apellidopaterno+' '+t.apellidomaterno+' '+t.nombre
        FROM ANDROID_COSECHA_HUERTO_DETALLE ACHD
        INNER JOIN bsis_rem_afr.dbo.trabajador t ON t.usuariosis=ACHD.USUARIO ".$where;
    
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