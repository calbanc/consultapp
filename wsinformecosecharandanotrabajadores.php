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
	if(isset($_GET["fecha"])&&isset($_GET["usuariocon"])){
        
        $FECHA=$_GET["fecha"];
        $USUARIOCON=$_GET["usuariocon"];
        $where="";

        if($USUARIOCON<>"TODOS"){
            $where.="AND USUARIO='{$USUARIOCON}'";
        }

       
        $consulta="SELECT [TRABAJADOR]=t.ApellidoPaterno+' '+t.ApellidoMaterno+' '+t.Nombre,ENV.NOM_ENV,SUM(ACHD.CANTIDAD) AS 'CANTIDAD',CAST( ISNULL(SUM(ACHD.CANTIDAD*ENVP.PESO_NETO),0) AS DECIMAL(16,2)) AS 'TOTALKILOS'
        FROM ANDROID_COSECHA_HUERTO_DETALLE ACHD
        INNER JOIN ENVASE ENV ON ACHD.COD_ENV=ENV.COD_ENV AND ACHD.COD_EMP=ENV.COD_EMP AND ACHD.COD_TEM=ENV.COD_TEM
        LEFT JOIN ENVASEOPERACIONAL_COSECHA ENVP ON ENVP.COD_EMP=ACHD.COD_EMP AND ENVP.COD_TEM=ACHD.COD_TEM AND ENVP.COD_ENV=ACHD.COD_ENV
        INNER JOIN bsis_rem_afr.dbo.Trabajador T ON T.idempresa=ACHD.IDEMPRESATRAB AND T.IDTRABAJADOR=ACHD.IDTRABAJADOR
        WHERE FECHA='{$FECHA}' ".$where." GROUP BY t.ApellidoPaterno,t.ApellidoMaterno,t.Nombre,ENV.NOM_ENV  ORDER BY CANTIDAD DESC ,t.ApellidoPaterno,t.ApellidoMaterno,t.Nombre";
        
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