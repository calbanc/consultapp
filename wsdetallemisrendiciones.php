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
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["IDTRABAJADOR"])&&isset($_GET["NRENDICION"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
		$IDTRABAJADOR=$_GET["IDTRABAJADOR"];
        $NRENDICION=$_GET["NRENDICION"];
		
		$consulta="SELECT [Empresa]= E.NOM_EMP,[Temporada]=R.COD_TEM,[IdRendidior]=R.IDTRABAJADOR, [Rendidor]=T.NOMBRE+' '+T.APELLIDOPATERNO+' '+T.APELLIDOMATERNO,
        [Id Gasto]=R.IDMANGASTO, [Item]=G.DESCRIPCION, [Año]=YEAR(R.FECHA), [Mes]=DATENAME(mm,R.FECHA), [Fecha]=CONVERT(VARCHAR,R.FECHA,103),       
        [Tipo]=CASE WHEN R.ENTREGADINERO=1 THEN 'Entrega Dinero' ELSE 'Rendicion Gasto' END,       
        [NRendicion]=R.NRENDICION, [NReport]=R.NREPORT,     
        [Centro Costo]=LTRIM(STR(cc.COD_CENTROCOSTO))+' '+ CC.DESCRIPCION,     
        [Sub Centro]=LTRIM(STR(sb.COD_SUBCENTRO))+' '+SB.DESCRIPCION,    
        [Total]=R.TOTAL*CASE WHEN R.ENTREGADINERO=1 THEN 1 ELSE 1 END,      
        [Observacion]=R.OBSERVACION      
        ,ISNULL(ISNULL(B.COD_FAM+B.COD_SUBFAM+B.COD_CUENTA,'') + ' ' + B.NOM_CUENTA,'') AS [CUENTA CONTABLE]
        ,TOTAL_US =R.TOTAL/D.DOLAR	, R.CODIGOCLIENTE, R.CANTIDAD, R.HOROMETRO, R.ODOMETRO, G.SW_COMBUSTIBLE, R.APROBACION, R.IMPORTADO,JD.UsuarioSis,R.ENTREGADINERO,R.COD_EMP,R.IDFOTO
        FROM APP_TRANSRENDICIONESCHOFERES R      
        INNER JOIN TransManGASTOS_OT G ON G.COD_EMP=R.COD_EMP AND G.COD_TEM=R.COD_TEM AND G.IDMANGASTO=R.IDMANGASTO   
        LEFT JOIN CUENTA_CONT B  ON G.COD_EMP = B.COD_EMP AND G.COD_FAM = B.COD_FAM AND G.COD_SUBFAM = B.COD_SUBFAM AND G.COD_CUENTA = B.COD_CUENTA    
        INNER JOIN EMPRESAS E ON E.COD_EMP=R.COD_EMP              
        INNER JOIN Bsis_Rem_Afr.dbo.Trabajador T ON T.IDEMPRESA=E.ID_EMPRESA_REM AND T.IDTRABAJADOR=R.IDTRABAJADOR      
        INNER JOIN Bsis_Rem_Afr.dbo.Contratos C WITH(NOLOCK) ON T.IdTrabajador = C.IdTrabajador AND T.IdEmpresa = C.IdEmpresa  and r.fecha BETWEEN c.fechainicio and isnull(c.fechatermino,isnull(c.fechaterminoc,getDATE())) 
        left JOIN BSIS_REM_AFR.DBO.TRABAJADOR JD WITH(NOLOCK) ON c.IDEMPRESA_JEFEDIRECTO=JD.IDEMPRESA AND c.IDJEFEDIRECTO=JD.IDTRABAJADOR
        LEFT JOIN Bsis_Rem_Afr.dbo.Zona ON c.IdEmpresa = Zona.IdEmpresa AND c.IdZona = Zona.IdZona          
        LEFT JOIN Bsis_Rem_Afr.dbo.Cuartel ON c.IdEmpresa = Cuartel.IdEmpresa AND c.IdZona = Cuartel.IdZona AND c.IdCuartel = Cuartel.IdCuartel          
        LEFT JOIN CENTROCOSTO_CONT CC ON CC.COD_EMP=R.COD_EMP AND CC.COD_CENTROCOSTO=zona.COD_CENTROCOSTO    
        LEFT JOIN SUB_CENTROCOSTO SB ON SB.COD_EMP=CC.COD_EMP AND SB.COD_CENTROCOSTO=CC.COD_CENTROCOSTO AND SB.COD_SUBCENTRO=cuartel.COD_SUBCENTRO    
        LEFT JOIN DOLAR D ON D.COD_PAIS=E.COD_PAIS AND D.FECHA=R.FECHA  
        WHERE R.COD_EMP='$COD_EMP' AND R.COD_TEM='$COD_TEM' and R.APROBACION='0'AND R.IDTRABAJADOR='$IDTRABAJADOR' AND R.NRENDICION='$NRENDICION'  ORDER BY R.NRENDICION ";

		
		
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