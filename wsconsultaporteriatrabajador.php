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
			if(isset($_GET["RUT"])&&isset($_GET["IDEMPRESA"])&&isset($_GET["IDTRABAJADOR"]))	{
				
				$RUT=$_GET["RUT"];
				$IDEMPRESA=$_GET["IDEMPRESA"];
				$IDTRABAJADOR=$_GET["IDTRABAJADOR"];
        
                if($RUT=='0'){
                
                       $consulta="SELECT 
                       T.NOMBRE,  T.APELLIDOPATERNO + ' ' + T.APELLIDOMATERNO AS APELLIDOS,                                      
                       JD.NOMBRE + ' ' + JD.APELLIDOPATERNO + ' ' + JD.APELLIDOMATERNO AS [JEFE_DIRECTO],    
                       [USUARIO_SISTEMA]=ISNULL(T.USUARIOSIS,'') ,                 
                       CASE E.DECIMAL WHEN 0 THEN                                       
                         REPLACE(REPLACE(CONVERT(VARCHAR(14),CAST(T.RUTTRABAJADOR AS MONEY), 1), '.00', ''), ',', '')                                      
                        ELSE                        
                         REPLICATE('0', TDI.LARGO - LEN(T.RUTTRABAJADOR))+LEFT(T.RUTTRABAJADOR,TDI.LARGO)                        
                        END AS RUTTRABAJADOR
                        ,T.IDTRABAJADOR,CO.IDEMPRESA_JEFEDIRECTO, CO.IDJEFEDIRECTO
                       , [Email_Jeje]=JD.MAIL_INSTITUCIONAL, [Email_Rendidor]=t.MAIL_INSTITUCIONAL,T.IDEMPRESA
                       
                       FROM BSIS_REM_AFR.DBO.CONTRATOS CO WITH(NOLOCK)                                       
                       INNER JOIN BSIS_REM_AFR.DBO.TRABAJADOR T WITH(NOLOCK)  ON T.IDEMPRESA=CO.IDEMPRESA  AND T.IDTRABAJADOR=CO.IDTRABAJADOR                                      
                       INNER JOIN BSIS_REM_AFR.DBO.EMPRESA E WITH(NOLOCK)  ON E.IDEMPRESA=T.IDEMPRESA   
                       left JOIN BSIS_REM_AFR.DBO.TRABAJADOR JD WITH(NOLOCK) ON CO.IDEMPRESA_JEFEDIRECTO=JD.IDEMPRESA AND CO.IDJEFEDIRECTO=JD.IDTRABAJADOR                                      
                       LEFT JOIN BSIS_REM_AFR.DBO.TIPODCTOIDEN TDI WITH(NOLOCK)  ON  TDI.IDEMPRESA=T.IDEMPRESA AND TDI.IDTIPODCTOIDEN=T.IDTIPODCTOIDEN          
                       LEFT JOIN Bsis_Rem_Afr.dbo.Zona ON co.IdEmpresa = Zona.IdEmpresa AND co.IdZona = Zona.IdZona          
                       LEFT JOIN Bsis_Rem_Afr.dbo.Cuartel ON co.IdEmpresa = Cuartel.IdEmpresa AND co.IdZona = Cuartel.IdZona AND co.IdCuartel = Cuartel.IdCuartel   
                           
                       
                       WHERE  CO.IndicadorVigencia=1 
                       AND CO.IDTRABAJADOR='{$IDTRABAJADOR}'  AND CO.IdEmpresa='{$IDEMPRESA}'";    
                }else{
                    $consulta="SELECT 
                    T.NOMBRE,  T.APELLIDOPATERNO + ' ' + T.APELLIDOMATERNO AS APELLIDOS,                                      
                    JD.NOMBRE + ' ' + JD.APELLIDOPATERNO + ' ' + JD.APELLIDOMATERNO AS [JEFE_DIRECTO],    
                    [USUARIO_SISTEMA]=ISNULL(T.USUARIOSIS,'') ,                 
                    CASE E.DECIMAL WHEN 0 THEN                                       
                      REPLACE(REPLACE(CONVERT(VARCHAR(14),CAST(T.RUTTRABAJADOR AS MONEY), 1), '.00', ''), ',', '')                                        
                     ELSE                        
                      REPLICATE('0', TDI.LARGO - LEN(T.RUTTRABAJADOR))+LEFT(T.RUTTRABAJADOR,TDI.LARGO)                        
                     END AS RUTTRABAJADOR
                     ,T.IDTRABAJADOR,CO.IDEMPRESA_JEFEDIRECTO, CO.IDJEFEDIRECTO
                    , [Email_Jeje]=JD.MAIL_INSTITUCIONAL, [Email_Rendidor]=t.MAIL_INSTITUCIONAL,T.IDEMPRESA
                    FROM BSIS_REM_AFR.DBO.CONTRATOS CO WITH(NOLOCK)                                       
                    INNER JOIN BSIS_REM_AFR.DBO.TRABAJADOR T WITH(NOLOCK)  ON T.IDEMPRESA=CO.IDEMPRESA  AND T.IDTRABAJADOR=CO.IDTRABAJADOR                                      
                    INNER JOIN BSIS_REM_AFR.DBO.EMPRESA E WITH(NOLOCK)  ON E.IDEMPRESA=T.IDEMPRESA   
                    left JOIN BSIS_REM_AFR.DBO.TRABAJADOR JD WITH(NOLOCK) ON CO.IDEMPRESA_JEFEDIRECTO=JD.IDEMPRESA AND CO.IDJEFEDIRECTO=JD.IDTRABAJADOR                                      
                    LEFT JOIN BSIS_REM_AFR.DBO.TIPODCTOIDEN TDI WITH(NOLOCK)  ON  TDI.IDEMPRESA=T.IDEMPRESA AND TDI.IDTIPODCTOIDEN=T.IDTIPODCTOIDEN          
                    LEFT JOIN Bsis_Rem_Afr.dbo.Zona ON co.IdEmpresa = Zona.IdEmpresa AND co.IdZona = Zona.IdZona          
                    LEFT JOIN Bsis_Rem_Afr.dbo.Cuartel ON co.IdEmpresa = Cuartel.IdEmpresa AND co.IdZona = Cuartel.IdZona AND co.IdCuartel = Cuartel.IdCuartel   
                    WHERE  CO.IndicadorVigencia=1 AND T.RutTrabajador='{$RUT}' ";
                }

				
				$resultado=sqlsrv_query($conexion,$consulta);
				
				while($registro =sqlsrv_fetch_array($resultado)){
					$json[]=$registro;
				}

				
				echo json_encode($json);
				

			}else{
				$resultar["message"]='Faltan parametros';
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