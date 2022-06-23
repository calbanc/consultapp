<?PHP
$hostname_localhost="192.168.2.210";


if(isset($_GET["IDUSUARIO"])&&isset($_GET["clave"])){

	$IDUSUARIO=$_GET["IDUSUARIO"];
	$clave=$_GET["clave"];
	 
	$info=array("Database"=>"erpfrusys","UID"=>$IDUSUARIO,"PWD"=>$clave,"CharacterSet"=>"UTF-8");



	$conexion = sqlsrv_connect($hostname_localhost,$info);

	if($conexion){
		$json=array();
		if(isset($_GET["IDUSUARIO"])&&isset($_GET["COD_TEM"])&&isset($_GET["COD_EMP"])){
			
			$IDUSUARIO=$_GET["IDUSUARIO"];
			$COD_TEM=$_GET["COD_TEM"];
			$COD_EMP=$_GET["COD_EMP"];
			
			$consulta="SELECT P.COD_PACK,P.COD_TEM,P.COD_EMP,P.ZON,P.COD_FRI,P.IDUSUARIO,P.COD_LINEA,PA.NOM_PACK,FRI.NOM_FRI,ZN.NOM_ZON,[TRABAJADOR]=T.NOMBRE+' '+T.APELLIDOPATERNO+' '+T.APELLIDOMATERNO
			FROM PACKINGS_PARAMETROS P
			INNER JOIN PACKINGS PA ON PA.COD_EMP=P.COD_EMP AND PA.COD_TEM=P.COD_TEM AND PA.COD_PACK=P.COD_PACK
			INNER JOIN FRIOS FRI ON FRI.COD_EMP=P.COD_EMP AND FRI.COD_TEM=P.COD_TEM AND FRI.COD_FRI=P.COD_FRI
            INNER JOIN ZONAS ZN ON P.COD_EMP=ZN.COD_EMP AND P.COD_TEM=ZN.COD_TEM AND P.ZON=ZN.ZON
			LEFT JOIN bsis_rem_afr.dbo.Trabajador T on t.usuariosis=p.idusuario
			where P.IDUSUARIO='{$IDUSUARIO}' and P.COD_TEM='{$COD_TEM}' AND P.COD_EMP='{$COD_EMP}'";
			
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