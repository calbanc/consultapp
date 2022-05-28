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
			$sqlWhere .= " AND  dbo.MIXEXISTENCIA.ZON='{$ZON}'";
		}
		if($COD_FRI!='null'){
			$sqlWhere .= " AND  dbo.MIXEXISTENCIA.COD_FRI='{$COD_FRI}'";
		}
		
		$consulta="SELECT     MIXEXISTENCIA.COD_TEM, MIXEXISTENCIA.COD_EMP, MIXEXISTENCIA.ESTA_FUIN, MIXEXISTENCIA.PLANILLA,
                              PRODUCTORES.NOM_PRO, MIXEXISTENCIA.COD_ENVOP, MIXEXISTENCIA.COD_VAR, MIXEXISTENCIA.CAJAS, 
                              MIXEXISTENCIA.NRO_MIX, MIXEXISTENCIA.LOTE, MIXEXISTENCIA.COD_ETI, MIXEXISTENCIA.COD_MER,
                              MIXEXISTENCIA.COD_MER4, MIXEXISTENCIA.SELLADO, MIXEXISTENCIA.COD_CAL, CONVERT( VARCHAR, MIXEXISTENCIA.FECHA_PAC , 111 ) as fecha , CONVERT( VARCHAR, MIXEXISTENCIA.HORA_REC, 108 ) as Hora,
                              MIXEXISTENCIA.ALTURA,MIXEXISTENCIA.COD_PRO
        			FROM         PRODUCTORES 
		INNER JOIN            MIXEXISTENCIA ON PRODUCTORES.COD_EMP = MIXEXISTENCIA.COD_EMP AND
                              PRODUCTORES.COD_TEM = MIXEXISTENCIA.COD_TEM AND PRODUCTORES.COD_PRO = MIXEXISTENCIA.COD_PRO
    WHERE MIXEXISTENCIA.COD_TEM ='{$COD_TEM}' AND MIXEXISTENCIA.COD_EMP='{$COD_EMP}' ".$sqlWhere." ";
		
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