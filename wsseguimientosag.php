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
	if(isset($_GET["Empresa"])&&isset($_GET["Temporada"])){
        
        $Empresa=$_GET["Empresa"];
		$Temporada=$_GET["Temporada"];
		
		
        $COD_FRI=$_GET["COD_FRI"];
        $sqlWhere = "";
     
        if($COD_FRI!=NULL){
            $sqlWhere .= " AND [Codigo Frio]='{$COD_FRI}'";
        }
		
		$consulta="SELECT Empresa,Temporada,[Numero de Pallet],[Planilla de Recepcion],[Codigo de Productor],[Nombre de Variedad],[Codigo de Envase Operacional]
		,[Cantidad de Cajas],[Codigo de Calibre],[Codigo de Mercado Inspeccion],[Mercado Proceso],[Numero de Mixtos],[Estado Fitosanitario],[Etiqueta],[Sellado],[Codigo Frio],[Camara],[Banda],
		[Fila Camara],[Piso Camara],CONVERT(VARCHAR,[Fecha de Recepcion],23) AS 'Fecha de Recepcion',[Codigo de Categoria],[Productor Sag],[CSP],[Altura del Pallet]
		 FROM viewReportesDeExistencia2 WHERE Empresa='{$Empresa}' AND Temporada='{$Temporada}' ".$sqlWhere." ";
		
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