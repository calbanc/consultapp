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

        date_default_timezone_set('America/Santiago');
		    $Fecha_ingreso=date('d/m/Y',time());

       

        $WHERE="";
        
        if(!$RUT=='0'){
          $WHERE.=" AND RutConductor='{$RUT}'";
        }

        if(!empty($IDEMPRESA)){
          $WHERE.=" AND IDEMPRESATRAB='{$IDEMPRESA}' AND IDTRABAJADOR='{$IDTRABAJADOR}' ";
        }

              $consultaantes="SELECT NombreConductor,Id FROM ANDROID_RECEPCION_CAMIONES WHERE Fecha_salida IS NULL AND convert(date,Fecha_ingreso)='{$Fecha_ingreso}' AND UsuarioSis_ingreso='{$usuario}' ".$WHERE . " ORDER BY Fecha_ingreso DESC";
              
             

              $resultadoantes=sqlsrv_query($conexion,$consultaantes);
              
              $registroantes =sqlsrv_fetch_array($resultadoantes);
              $nombretrabajador=$registroantes['NombreConductor'];
              $id=$registroantes["Id"];
              if(!empty($nombretrabajador)){
                $resultar["respuesta"]='REGISTRADO';
                $resultar["id"]=$id;
                $json[]=$resultar;
                echo json_encode($json);
              }else{
                if($RUT=='0'){
                
                        $consulta="SELECT * FROM 
	
                        (	SELECT TIPO='EMPRESA', 	T.NOMBRE,  T.APELLIDOPATERNO + ' ' + T.APELLIDOMATERNO AS APELLIDOS,                                      
                        JD.NOMBRE + ' ' + JD.APELLIDOPATERNO + ' ' + JD.APELLIDOMATERNO AS [JEFE_DIRECTO],    
                        [USUARIO_SISTEMA]=ISNULL(T.USUARIOSIS,'') ,                 
                        CASE E.DECIMAL WHEN 0 THEN                                       
                          REPLACE(REPLACE(CONVERT(VARCHAR(14),CAST(T.RUTTRABAJADOR AS MONEY), 1), '.00', ''), ',', '')                                      
                        ELSE                        
                          REPLICATE('0', TDI.LARGO - LEN(T.RUTTRABAJADOR))+LEFT(T.RUTTRABAJADOR,TDI.LARGO)                        
                        END AS RUTTRABAJADOR
                        ,T.IDTRABAJADOR,CO.IDEMPRESA_JEFEDIRECTO, CO.IDJEFEDIRECTO
                        , [EMAIL_JEJE]=JD.MAIL_INSTITUCIONAL, [EMAIL_RENDIDOR]=T.MAIL_INSTITUCIONAL,T.IDEMPRESA
                          FROM BSIS_REM_AFR.DBO.CONTRATOS CO WITH(NOLOCK)                                       
                        INNER JOIN BSIS_REM_AFR.DBO.TRABAJADOR T WITH(NOLOCK)  ON T.IDEMPRESA=CO.IDEMPRESA  AND T.IDTRABAJADOR=CO.IDTRABAJADOR                                      
                        INNER JOIN BSIS_REM_AFR.DBO.EMPRESA E WITH(NOLOCK)  ON E.IDEMPRESA=T.IDEMPRESA   
                        LEFT JOIN BSIS_REM_AFR.DBO.TRABAJADOR JD WITH(NOLOCK) ON CO.IDEMPRESA_JEFEDIRECTO=JD.IDEMPRESA AND CO.IDJEFEDIRECTO=JD.IDTRABAJADOR                                      
                        LEFT JOIN BSIS_REM_AFR.DBO.TIPODCTOIDEN TDI WITH(NOLOCK)  ON  TDI.IDEMPRESA=T.IDEMPRESA AND TDI.IDTIPODCTOIDEN=T.IDTIPODCTOIDEN          
                        LEFT JOIN BSIS_REM_AFR.DBO.ZONA ON CO.IDEMPRESA = ZONA.IDEMPRESA AND CO.IDZONA = ZONA.IDZONA          
                        LEFT JOIN BSIS_REM_AFR.DBO.CUARTEL ON CO.IDEMPRESA = CUARTEL.IDEMPRESA AND CO.IDZONA = CUARTEL.IDZONA AND CO.IDCUARTEL = CUARTEL.IDCUARTEL   
                                            
                        WHERE  CO.INDICADORVIGENCIA=1 
                      
                        UNION ALL
                      
                        SELECT TIPO='CONTRATISTA',	T.NOMBRE,  T.NOMBRE AS APELLIDOS,                                      
                        T.APELLIDOPATERNO AS [JEFE_DIRECTO],    
                        [USUARIO_SISTEMA]='' ,                 
                        CASE E.DECIMAL WHEN 0 THEN                                       
                          REPLACE(REPLACE(CONVERT(VARCHAR(14),CAST(T.RUTTRABAJADOR AS MONEY), 1), '.00', ''), ',', '')                                      
                        ELSE                        
                          REPLICATE('0', TDI.LARGO - LEN(T.RUTTRABAJADOR))+LEFT(T.RUTTRABAJADOR,TDI.LARGO)                        
                        END AS RUTTRABAJADOR
                        ,T.IDTRABAJADOR,IDEMPRESA_JEFEDIRECTO='', IDJEFEDIRECTO=''
                        , [EMAIL_JEJE]=''
                        --JD.MAIL_INSTITUCIONAL,
                        ,[EMAIL_RENDIDOR]=''
                        --T.MAIL_INSTITUCIONAL,
                        ,T.IDEMPRESA
                                             
                        FROM BSIS_REM_AFR.DBO.TRABAJADOREXTERNO T WITH(NOLOCK)                                       
                        INNER JOIN BSIS_REM_AFR.DBO.EMPRESA E WITH(NOLOCK)  ON E.IDEMPRESA=T.IDEMPRESA   
                        LEFT JOIN BSIS_REM_AFR.DBO.TIPODCTOIDEN TDI WITH(NOLOCK)  ON  TDI.IDEMPRESA=T.IDEMPRESA AND TDI.IDTIPODCTOIDEN=T.IDTIPODCTOIDEN
                        )TMP
                        WHERE 
                        TMP.IDTRABAJADOR='{$IDTRABAJADOR}'  AND
                        TMP.IDEMPRESA='{$IDEMPRESA}'";    
                }else{
                    $consulta="SELECT * FROM 
	
                    (	SELECT TIPO='EMPRESA', 	T.NOMBRE,  T.APELLIDOPATERNO + ' ' + T.APELLIDOMATERNO AS APELLIDOS,                                      
                    JD.NOMBRE + ' ' + JD.APELLIDOPATERNO + ' ' + JD.APELLIDOMATERNO AS [JEFE_DIRECTO],    
                    [USUARIO_SISTEMA]=ISNULL(T.USUARIOSIS,'') ,                 
                    CASE E.DECIMAL WHEN 0 THEN                                       
                      REPLACE(REPLACE(CONVERT(VARCHAR(14),CAST(T.RUTTRABAJADOR AS MONEY), 1), '.00', ''), ',', '')                                      
                    ELSE                        
                      REPLICATE('0', TDI.LARGO - LEN(T.RUTTRABAJADOR))+LEFT(T.RUTTRABAJADOR,TDI.LARGO)                        
                    END AS RUTTRABAJADOR
                    ,T.IDTRABAJADOR,CO.IDEMPRESA_JEFEDIRECTO, CO.IDJEFEDIRECTO
                    , [EMAIL_JEJE]=JD.MAIL_INSTITUCIONAL, [EMAIL_RENDIDOR]=T.MAIL_INSTITUCIONAL,T.IDEMPRESA
                      FROM BSIS_REM_AFR.DBO.CONTRATOS CO WITH(NOLOCK)                                       
                    INNER JOIN BSIS_REM_AFR.DBO.TRABAJADOR T WITH(NOLOCK)  ON T.IDEMPRESA=CO.IDEMPRESA  AND T.IDTRABAJADOR=CO.IDTRABAJADOR                                      
                    INNER JOIN BSIS_REM_AFR.DBO.EMPRESA E WITH(NOLOCK)  ON E.IDEMPRESA=T.IDEMPRESA   
                    LEFT JOIN BSIS_REM_AFR.DBO.TRABAJADOR JD WITH(NOLOCK) ON CO.IDEMPRESA_JEFEDIRECTO=JD.IDEMPRESA AND CO.IDJEFEDIRECTO=JD.IDTRABAJADOR                                      
                    LEFT JOIN BSIS_REM_AFR.DBO.TIPODCTOIDEN TDI WITH(NOLOCK)  ON  TDI.IDEMPRESA=T.IDEMPRESA AND TDI.IDTIPODCTOIDEN=T.IDTIPODCTOIDEN          
                    LEFT JOIN BSIS_REM_AFR.DBO.ZONA ON CO.IDEMPRESA = ZONA.IDEMPRESA AND CO.IDZONA = ZONA.IDZONA          
                    LEFT JOIN BSIS_REM_AFR.DBO.CUARTEL ON CO.IDEMPRESA = CUARTEL.IDEMPRESA AND CO.IDZONA = CUARTEL.IDZONA AND CO.IDCUARTEL = CUARTEL.IDCUARTEL   
                                        
                    WHERE  CO.INDICADORVIGENCIA=1 
                  
                    UNION ALL
                  
                    SELECT TIPO='CONTRATISTA',	T.NOMBRE,  T.NOMBRE AS APELLIDOS,                                      
                    T.APELLIDOPATERNO AS [JEFE_DIRECTO],    
                    [USUARIO_SISTEMA]='' ,                 
                    CASE E.DECIMAL WHEN 0 THEN                                       
                      REPLACE(REPLACE(CONVERT(VARCHAR(14),CAST(T.RUTTRABAJADOR AS MONEY), 1), '.00', ''), ',', '')                                      
                    ELSE                        
                      REPLICATE('0', TDI.LARGO - LEN(T.RUTTRABAJADOR))+LEFT(T.RUTTRABAJADOR,TDI.LARGO)                        
                    END AS RUTTRABAJADOR
                    ,T.IDTRABAJADOR,IDEMPRESA_JEFEDIRECTO='', IDJEFEDIRECTO=''
                    , [EMAIL_JEJE]=''
                    --JD.MAIL_INSTITUCIONAL,
                    ,[EMAIL_RENDIDOR]=''
                    --T.MAIL_INSTITUCIONAL,
                    ,T.IDEMPRESA
                                         
                    FROM BSIS_REM_AFR.DBO.TRABAJADOREXTERNO T WITH(NOLOCK)                                       
                    INNER JOIN BSIS_REM_AFR.DBO.EMPRESA E WITH(NOLOCK)  ON E.IDEMPRESA=T.IDEMPRESA   
                    LEFT JOIN BSIS_REM_AFR.DBO.TIPODCTOIDEN TDI WITH(NOLOCK)  ON  TDI.IDEMPRESA=T.IDEMPRESA AND TDI.IDTIPODCTOIDEN=T.IDTIPODCTOIDEN
                    )TMP
                    WHERE 
                    TMP.RUTTRABAJADOR='{$RUT}'";
                }

        
        $resultado=sqlsrv_query($conexion,$consulta);
       
        while($registro =sqlsrv_fetch_array($resultado)){
          $registro["respuesta"]='NUEVO';
          $json[]=$registro;
        }

        
        echo json_encode($json);
              }



                
				

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