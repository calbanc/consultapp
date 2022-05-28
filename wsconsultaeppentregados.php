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
        if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["DNI"])){
        
            $COD_EMP=$_GET["COD_EMP"];
            $COD_TEM=$_GET["COD_TEM"];
            $DNI=$_GET["DNI"];


            if($COD_EMP=='9'){
                $COD_EMP='ARAP';
            }

            if($COD_EMP=='14'){
                $COD_EMP='FORT';
            }

            $consulta="SELECT T.ApellidoPaterno + ' ' + T.ApellidoMaterno + ' ' + T.Nombre AS Trabajador,T.IdTrabajador AS codigo,CONVERT(VARCHAR, C.FECHA,4) AS 'FECHA',  S.DES_SITEM AS Material,
            C.CANTIDAD  as Cantidad, C.TIPO, 
            CASE WHEN e.DECIMAL = 0 THEN REPLACE(REPLACE(CONVERT(varchar(14), CAST(t .RutTrabajador AS money), 1),'.00', ''), ',', '.') ELSE REPLACE(REPLACE(CONVERT(varchar(14), CAST(REPLICATE('0', Td.LARGO - LEN(t .RUTTRABAJADOR))+ LEFT(t.RUTTRABAJADOR, Td.LARGO) AS NVARCHAR(20)), 1), '.00', ''), ',', '.') END AS RutTrabajador,
            C.MOTIVO, ZL.Nombre AS [ZONA LABORES]           
            FROM CTACTE_TRABAJADOR_MATERIAL AS C  
            INNER JOIN EMPRESAS AS E  ON E.COD_EMP = C.COD_EMP 
            INNER JOIN SUBITEM AS S ON S.COD_EMP = C.COD_EMP AND S.COD_TEM = C.COD_TEM AND S.SUBITEM = C.SUBITEM 
            INNER JOIN AGRUPACION AS A  ON S.COD_EMP = A.COD_EMP AND S.COD_TEM = A.COD_TEM AND S.COD_AGRUP = A.COD_AGRUP 
            INNER JOIN bsis_rem_afr.dbo.Trabajador AS T WITH (NOLOCK) ON T.IdEmpresa = E.ID_EMPRESA_REM AND T.IdTrabajador = C.IDTRABAJADOR 
            INNER JOIN bsis_rem_afr.dbo.TipoDctoIden AS Td WITH (NOLOCK) ON Td.IdEmpresa = T.IdEmpresa AND Td.IdTipoDctoIden = T.IdTipoDctoIden 
            LEFT OUTER JOIN bsis_rem_afr.dbo.Zona AS ZL WITH (NOLOCK) ON T.IdEmpresa = ZL.IdEmpresa AND T.IdZonaLabores = ZL.IdZona
            where T.RutTrabajador='{$DNI}' and C.TIPO='Entrega' and C.COD_TEM='{$COD_TEM}' and C.COD_EMP='{$COD_EMP}' ORDER BY FECHA ASC";
            $resultado=sqlsrv_query($conexion,$consulta);
            
            while($registro =sqlsrv_fetch_array($resultado)){
                $json[]=$registro;
            }

            
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