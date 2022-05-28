<?PHP
$hostname_localhost="192.168.2.210";
 if(isset($_GET["IDUSUARIO"])&&isset($_GET["clave"])){

	$IDUSUARIO=$_GET["IDUSUARIO"];
	$clave=$_GET["clave"];
	 
	
	$info=array("Database"=>"bpriv","UID"=>$IDUSUARIO,"PWD"=>$clave,"CharacterSet"=>"UTF-8"); 
	

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IDUSUARIO"])){
        
        $IDUSUARIO=$_GET["IDUSUARIO"];
		
		$consulta="SELECT [IDEMPRESA]=ISNULL(E.COD_EMP,ER.COD_EMP_CONT)
        ,[NOM_EMP]=ISNULL(E.NOM_EMP,ER.NOMBRE)
        ,[COD_TEM_DEFAULT],[ID_EMPRESA_REM],IDMENU,P.IDAPLICACION,PRO.IDUSUARIO,[COD_EMP]=P.IDEMPRESA,ZU.IDZONA,PRO.CLAVE,PRECIO_ESTIMADO
        FROM BPRIV.DBO.PERFIL P
        LEFT JOIN ERPFRUSYS.DBO.EMPRESAS E ON P.IDEMPRESA = E.COD_EMP
        LEFT JOIN BSIS_REM_AFR.DBO.EMPRESA ER ON P.IDEMPRESA = LTRIM(STR(ER.IDEMPRESA))
        LEFT JOIN  BPRIV.DBO.PROTOCOLOS_USUARIOS PRO ON PRO.IDUSUARIO=P.IDUSUARIO
		LEFT JOIN BPRIV.DBO.ZONAS_USUARIOS ZU ON P.IDAPLICACION=ZU.IdAplicacion  and ZU.IdEmpresa=P.IdEmpresa and ZU.IdUsuario=P.Idusuario
        WHERE PRO.IDUSUARIO='{$IDUSUARIO}' AND P.IDAPLICACION LIKE ('APP%')";
		
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






<?PHP
$hostname_localhost="192.168.2.210";
 if(isset($_GET["IDUSUARIO"])&&isset($_GET["clave"])){

	$IDUSUARIO=$_GET["IDUSUARIO"];
	$clave=$_GET["clave"];
	 
	
	$info=array("Database"=>"bpriv","UID"=>$IDUSUARIO,"PWD"=>$clave,"CharacterSet"=>"UTF-8"); 
	

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IDUSUARIO"])){
        
        $IDUSUARIO=$_GET["IDUSUARIO"];
		
		$consulta="SELECT [COD_EMP]=ISNULL(E.COD_EMP,ER.COD_EMP_CONT)
        ,[NOM_EMP]=ISNULL(E.NOM_EMP,ER.NOMBRE)
        ,[COD_TEM_DEFAULT],[ID_EMPRESA_REM],IDMENU,P.IDAPLICACION,PRO.IDUSUARIO,P.IDEMPRESA,ZU.IDZONA,PRO.CLAVE,PRECIO_ESTIMADO
        FROM BPRIV.DBO.PERFIL P
        LEFT JOIN ERPFRUSYS.DBO.EMPRESAS E ON P.IDEMPRESA = E.COD_EMP
        LEFT JOIN BSIS_REM_AFR.DBO.EMPRESA ER ON P.IDEMPRESA = LTRIM(STR(ER.IDEMPRESA))
        LEFT JOIN  BPRIV.DBO.PROTOCOLOS_USUARIOS PRO ON PRO.IDUSUARIO=P.IDUSUARIO
		LEFT JOIN BPRIV.DBO.ZONAS_USUARIOS ZU ON P.IDAPLICACION=ZU.IdAplicacion  and ZU.IdEmpresa=P.IdEmpresa and ZU.IdUsuario=P.Idusuario
        WHERE PRO.IDUSUARIO='{$IDUSUARIO}' AND P.IDAPLICACION LIKE ('APP%')";
		
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