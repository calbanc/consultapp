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
	if(isset($_GET["FECHADESDE"])&&isset($_GET["FECHAHASTA"])&&isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["PRODUCTOR"])&&isset($_GET["SECTOR"])
    &&isset($_GET["CUARTEL"])&&isset($_GET["SUPERVISOR"])){
        $FECHADESDE=$_GET["FECHADESDE"];
        $FECHAHASTA=$_GET["FECHAHASTA"];
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $PRODUCTOR=$_GET["PRODUCTOR"];
        $SECTOR=$_GET["SECTOR"];
        $CUARTEL=$_GET["CUARTEL"];
        $USUARIO=$_GET["SUPERVISOR"];
        $VARIEDAD=$_GET["VARIEDAD"];

        
		$where="";
		if(empty($FECHAHASTA)||$FECHAHASTA==="TODOS"){
			$where="AND ACD.FECHA BETWEEN '{$FECHADESDE}' AND '{$FECHADESDE}' ";
		}else{
			$where="AND ACD.FECHA BETWEEN '{$FECHADESDE}' AND '{$FECHAHASTA}' ";
		}

        if($PRODUCTOR!="TODOS"){
              $where.="AND AC.COD_PRO='{$PRODUCTOR}'"  ;
        }
        if($SECTOR!="TODOS"){
            $where.="AND GC.COD_GRP_CUARTEL='{$SECTOR}'";
        }
        if($VARIEDAD!="TODOS"){
            $where.=" AND V.COD_VAR='{$VARIEDAD}'";
        }
        if($CUARTEL!="TODOS"){
            $where.="AND AC.COD_CUA='{$CUARTEL}' ";
        }

        if($USUARIO!="TODOS"){
            $where.="AND ACD.USUARIO='{$USUARIO}'";
        }

        
        $consulta=" SELECT CONVERT(VARCHAR,ACD.FECHA,23) AS
        'FECHA',[CUARTEL]=C.COD_CUA,(AC.CANTIDAD) as CANTIDAD,[SECTOR]=GC.DESCRIPCION,[KILOS]=ISNULL(envop.peso_neto,0)*AC.CANTIDAD,
        [USUARIO]=T.ApellidoPaterno+' '+T.ApellidoMaterno+' '+T.Nombre
        FROM ANDROID_COSECHA_HUERTO AC
        INNER JOIN EMPRESAS E ON E.COD_EMP=AC.COD_EMP
        INNER JOIN ANDROID_COSECHA_HUERTO_DETALLE ACD ON AC.COD_EMP=ACD.COD_EMP AND AC.COD_TEM=ACD.COD_TEM AND AC.PLANILLA=ACD.PLANILLA
        LEFT JOIN PRODUCTORES P ON P.COD_EMP = AC.COD_EMP AND P.COD_TEM=AC.COD_TEM AND P.COD_PRO=AC.COD_PRO
        LEFT JOIN CUARTELES C ON C.COD_EMP=AC.COD_EMP AND C.COD_TEM=AC.COD_TEM AND C.COD_PRO=AC.COD_PRO AND C.COD_CUA=AC.COD_CUA
        LEFT JOIN GRUPO_CUARTELES GC ON GC.COD_EMP=AC.COD_EMP AND GC.COD_TEM=AC.COD_TEM AND GC.COD_GRP_CUARTEL=C.COD_GRP_CUARTEL
        LEFT JOIN ENVASEOPERACIONAL_COSECHA ENVOP ON ENVOP.COD_EMP =AC.COD_EMP AND ENVOP.COD_TEM=AC.COD_TEM AND ENVOP.COD_ENV =ACD.COD_ENV
        LEFT JOIN ESPECIE ES ON ES.COD_EMP=AC.COD_EMP AND ES.COD_TEM=AC.COD_TEM AND ES.COD_ESP='AR'
        INNER JOIN bsis_rem_afr.dbo.Trabajador T on T.UsuarioSis=ACD.USUARIO
        LEFT JOIN VARIEDAD V ON V.COD_EMP=AC.COD_EMP AND V.COD_TEM=AC.COD_TEM AND C.COD_ESP=V.COD_ESP AND V.COD_VAR=C.COD_VAR
        WHERE AC.COD_EMP='{$COD_EMP}' AND AC.COD_TEM='{$COD_TEM}' ".$where." group by ACD.FECHA,C.COD_CUA,GC.DESCRIPCION,ENVOP.PESO_NETO,T.ApellidoPaterno,T.ApellidoMaterno,T.Nombre,AC.CANTIDAD,AC.PLANILLA ORDER BY FECHA ASC,CUARTEL ASC";

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