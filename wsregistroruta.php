<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

$usuario=$_GET["usuario"];
$clave=$_GET["clave"];
	 
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
if($conexion){
	$json=array();
	
    if(isset($_GET["IDEMPRESA"])&&isset($_GET["FECHA"])&&isset($_GET["TEMPORADA"])){
        $IDEMPRESA=$_GET["IDEMPRESA"];
        $FECHA=$_GET["FECHA"];
        $TEMPORADA=$_GET["TEMPORADA"];


        $consultaempresa="SELECT DISTINCT COD_EMP_CONT FROM Empresa WHERE IdEmpresa='{$IDEMPRESA}'";
      
        $resultadoempresa=sqlsrv_query($conexion,$consultaempresa);
        if($registross=sqlsrv_fetch_array($resultadoempresa)){
            $COD_EMP=$registross['COD_EMP_CONT'];
            
        }
        
      	$consulta=" SELECT R.COD_TRP , R.COD_BUS,B.PATENTE , R.COD_TRONCAL,R.COD_RUTA , R.IDZONA ,
        OBSERVACION=ISNULL(R.OBSERVACION,''), R.IDCUARTEL, R.IDFAMILIA ,R.IDACTIVIDAD,R.IDEMPRESA,CONVERT(VARCHAR,R.FECHA,105) AS 'FECHA'
         FROM REGISTRO_RUTA R 
         INNER JOIN ERPFRUSYS.DBO.TRANSPORTISTAS T ON T.COD_TRP=R.COD_TRP AND T.COD_EMP ='{$COD_EMP}' AND T.COD_TEM='{$TEMPORADA}' 
         INNER JOIN BUSES B ON B.IDEMPRESA =R.IDEMPRESA AND B.COD_BUS=R.COD_BUS AND B.COD_TRP =R.COD_TRP 
         INNER JOIN TRONCAL TR ON TR.IDEMPRESA =R.IDEMPRESA AND TR.COD_TRONCAL =R.COD_TRONCAL 
         INNER JOIN RUTAS RU ON RU.IdEmpresa=R.IdEmpresa AND RU.Cod_Ruta=R.COD_RUTA AND RU.COD_TRONCAL =R.COD_TRONCAL 
         INNER JOIN Zona Z ON Z.IdEmpresa =R.IDEMPRESA AND Z.IdZona =R.IDZONA 
         LEFT JOIN CUARTEL C ON C.IdEmpresa=R.IdEmpresa AND C.IdZona=R.IdZona AND C.IdCuartel=R.IdCuartel 
         LEFT JOIN FAMILIAACTIVIDADES F ON F.IdFamilia=R.IDFAMILIA AND F.IdEmpresa=R.IdEmpresa 
         LEFT JOIN ACTIVIDADES A ON A.IdEmpresa=R.IdEmpresa AND A.IdFamilia=R.IdFamilia AND A.IdActividad=R.IdActividad 
         LEFT JOIN TABLA_DESCUENTOS_TRANSPORTISTA TD ON TD.IdEmpresa = R.IDEMPRESA AND R.COD_DES=TD.COD_DES 
         WHERE R.IDEMPRESA='{$IDEMPRESA}' AND R.FECHA='{$FECHA}' 
         ORDER BY R.CORRELATIVO";

       
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
		}

		
		echo json_encode($json);
		

     } else{
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