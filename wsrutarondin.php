<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["UsuarioSis"])){
        
       
        $UsuarioSis=$_GET["UsuarioSis"];
        
		
			$consulta="  SELECT RD.IDEMPRESA,RR.IDZONA ,RR.IDRUTA,RR.LUN,RR.MAR,RR.MIE,RR.JUE,RR.VIE,RR.SAB,RR.DOM,RD.IDCUARTEL,CONVERT(VARCHAR,RD.HORA,108) AS 'HORA'
            FROM RONDIN_RUTAS_DETALLE RD WITH(NOLOCK)
            INNER JOIN RONDIN_RUTAS RR WITH(NOLOCK) ON RR.IDEMPRESA=RD.IDEMPRESA AND RR.IDZONA=RD.IDZONA AND RR.IDRUTA=RD.IDRUTA
            INNER JOIN RONDIN_RUTAS_TRABAJADOR RT WITH(NOLOCK) ON RT.IDEMPRESA=RD.IDEMPRESA AND RD.IDZONA=RT.IDZONA AND RD.IDRUTA=RT.IDRUTA 
            INNER JOIN Trabajador T WITH(NOLOCK) ON RT.IDEMPRESA=T.IdEmpresa AND RT.IDTRABAJADOR=T.IdTrabajador
            INNER JOIN Cuartel C WITH(NOLOCK) ON C.IdEmpresa=RD.IDEMPRESA AND C.IdZona=RD.IDZONA AND C.IdCuartel=RD.IDCUARTEL
            INNER JOIN NFC NFC WITH(NOLOCK) ON NFC.IDEMPRESA=RD.IDEMPRESA AND NFC.IDCUARTEL=RD.IDCUARTEL AND NFC.IDZONA=RD.IDZONA 
            WHERE T.UsuarioSis='{$UsuarioSis}' 
            ORDER BY HORA ASC";
		
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
	
?>