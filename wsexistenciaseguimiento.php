<?PHP
$hostname_localhost="192.168.2.210";

if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	 

	$info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_TEM"])&&isset($_GET["COD_EMP"])){
        
       
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
		$ZON=$_GET["ZON"];
		$COD_FRI=$_GET["COD_FRI"];
			
		if($ZON!='null'){
			$sqlWhere .= " AND  dbo.EXISTENCIA.ZON='{$ZON}'";
		}	
		if($COD_FRI!='null'){
			$sqlWhere .= " AND  dbo.EXISTENCIA.COD_FRI='{$COD_FRI}'";
		}
		

			$consulta="SELECT   dbo.EXISTENCIA.PLANILLA, dbo.EXISTENCIA.COD_TEM, dbo.EXISTENCIA.COD_EMP, dbo.PRODUCTORES.NOM_PRO, dbo.EXISTENCIA.COD_VAR, 
			dbo.EXISTENCIA.ESTA_FUIN, dbo.EXISTENCIA.LOTE, dbo.EXISTENCIA.COD_ETI, dbo.EXISTENCIA.COD_ENVOP, dbo.EXISTENCIA.CAJAS,
			dbo.EXISTENCIA.COD_CAL, dbo.EXISTENCIA.NRO_MIX, dbo.EXISTENCIA.COD_MER,dbo.EXISTENCIA.COD_MER1,dbo.EXISTENCIA.COD_MER2,dbo.EXISTENCIA.COD_MER3, dbo.EXISTENCIA.COD_MER4, dbo.EXISTENCIA.SELLADO,
			dbo.EXISTENCIA.COD_CAM, dbo.EXISTENCIA.COD_BANDA, dbo.EXISTENCIA.FILA, dbo.EXISTENCIA.PISO,CONVERT(VARCHAR, dbo.EXISTENCIA.FECHA_PAC,103) AS HORA_REC,dbo.EXISTENCIA.COD_CAT,
			dbo.EXISTENCIA.ALTURA, dbo.EXISTENCIA.COD_FRI,dbo.PRODUCTORES.COD_PRO,OD.TIP_TRA,OD.PLANILLA,dbo.EXISTENCIA.COD_CUA,[PRODUCTOR_SAG]=CU.COD_CSG+'-'+PS.NOM_PRO,dbo.PREDIOS_INSPECCION.COD_INSCRIPCION AS 'PREDIO_INSPECCION'
			FROM            dbo.EXISTENCIA WITH(NOLOCK)
			
			INNER JOIN dbo.PRODUCTORES WITH(NOLOCK) ON dbo.PRODUCTORES.COD_EMP = dbo.EXISTENCIA.COD_EMP AND dbo.PRODUCTORES.COD_TEM = dbo.EXISTENCIA.COD_TEM AND dbo.PRODUCTORES.COD_PRO = dbo.EXISTENCIA.COD_PRO
			LEFT JOIN dbo.PREDIOS_INSPECCION WITH(NOLOCK) on dbo.PREDIOS_INSPECCION.COD_EMP=dbo.EXISTENCIA.COD_EMP AND dbo.PREDIOS_INSPECCION.COD_TEM=dbo.EXISTENCIA.COD_TEM AND dbo.PREDIOS_INSPECCION.COD_PRO=dbo.EXISTENCIA.COD_PRO AND dbo.PREDIOS_INSPECCION.COD_PRE=dbo.PREDIOS_INSPECCION.COD_PRE AND dbo.PREDIOS_INSPECCION.COD_CUA=dbo.EXISTENCIA.COD_CUA
			LEFT OUTER JOIN dbo.CUARTELES AS CU WITH(NOLOCK) ON CU.COD_EMP =  dbo.EXISTENCIA.COD_EMP AND CU.COD_TEM =  dbo.EXISTENCIA.COD_TEM AND CU.COD_PRO =  dbo.EXISTENCIA.COD_PRO AND CU.COD_PRE =  dbo.EXISTENCIA.COD_PRE AND CU.COD_CUA =  dbo.EXISTENCIA.COD_CUA           
	
		LEFT JOIN PRODUCTORES_SAG PS WITH(NOLOCK) ON PS.COD_PRO = CU.COD_CSG AND PS.COD_TEM = CU.COD_TEM AND PS.COD_EMP = Cu.COD_EMP             

		LEFT JOIN OEM_DETALLE OD WITH(NOLOCK) 	ON OD.COD_EMP=dbo.EXISTENCIA.COD_EMP AND OD.COD_TEM=dbo.EXISTENCIA.COD_TEM AND OD.LOTE=dbo.EXISTENCIA.LOTE AND OD.ANULAR=0       
		  WHERE dbo.EXISTENCIA.COD_EMP ='{$COD_EMP}' AND dbo.EXISTENCIA.COD_TEM ='{$COD_TEM}' ".$sqlWhere." ";

		  
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