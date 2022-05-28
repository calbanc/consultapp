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
        
        if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["ZON"])&&isset($_GET["FECHA_DESDE"])&&isset($_GET["FECHA_HASTA"])
        &&isset($_GET["NSOLICITUD"])&&isset($_GET["ESTADO"])&&isset($_GET["CORRELATIVO"])&&isset($_GET["SUBITEM"])){
            
            $COD_EMP=$_GET["COD_EMP"];
            $COD_TEM=$_GET["COD_TEM"];
            $ZON=$_GET["ZON"];
            $FECHA_DESDE=$_GET["FECHA_DESDE"];
            $FECHA_HASTA=$_GET["FECHA_HASTA"];
            $NSOLICITUD=$_GET["NSOLICITUD"];
            $ESTADO=$_GET["ESTADO"];
            $CORRELATIVO=$_GET["CORRELATIVO"];
            $SUBITEM=$_GET["SUBITEM"];

            
            $sqlwhere="";

            if($ZON!='TODOS'){
                $sqlwhere.="  AND D.ZON='{$ZON }'";
            }
            if($FECHA_DESDE!='TODOS' && $FECHA_HASTA!='TODOS'){
                $sqlwhere.="   AND C.FEC_SOLICITUD BETWEEN '{$FECHA_DESDE}' AND '{$FECHA_HASTA}' ";
            }

            if($NSOLICITUD!='TODOS'){
                $sqlwhere.="  AND C.NRO_SOLICITUD='{$NSOLICITUD}' ";   
            }

            if($ESTADO!='TODOS'){
                if($ESTADO=='Pendiente'){
                    $sqlwhere.="  AND DO.COD_EMP IS NULL";   
                }else{
                    $sqlwhere.="  AND DO.COD_EMP IS NOT NULL"; 
                }
                
            }

            if($CORRELATIVO!='TODOS'){
                $sqlwhere.=" AND D.CORREL='{$CORRELATIVO}'";
            }

            if($SUBITEM!='TODOS'){
                $sqlwhere.=" AND D.SUBITEM='{$SUBITEM}'";
            } 
            
             $consulta="SELECT D.CORREL, C.NRO_SOLICITUD,[Cod. Material]   = D.SUBITEM,[Descripcion Material]  = SI.DES_SITEM,CANTIDAD     = ISNULL(D.CANTIDAD,0),CANTIDAD_APROBADA =(CASE WHEN ISNULL(A.CANTIDAD, 0)=0  THEN D.CANTIDAD  ELSE  ISNULL(A.CANTIDAD, 0) END),                                    
            [CANTIDAD OC]    = ISNULL(DO.CANTIDAD,0),[CANTIDAD RECEPCIONADA] = R.CAN_REC,D.COD_CENTROCOSTO,D.COD_SUBCENTRO,C.COD_EMP,C.ZON, C.COD_TEM, Z.NOM_ZON,Nombre_CentroCosto   = CC.DESCRIPCION,                                  
            Nombre_SubCentroCosto  = SCC.DESCRIPCION,ESTADO      = (CASE WHEN DO.COD_EMP IS NULL THEN 'Pendiente' ELSE 'Cerrada' END),DO.NRO_ORDEN ,R.PLANILLA_REC,FECHA_SOLICITUD  =CONVERT(VARCHAR, C.FEC_SOLICITUD,23) , FECHA_APROBACION_SOLICITUD =CONVERT(VARCHAR, A.FECHA,23),                                  
            FECHA_ORDEN_COMPRA  =CONVERT(VARCHAR, O.FEC_ORDEN,23), FECHA_APROBACION_ORDEN  = CONVERT(VARCHAR,O.FECHA_ING,23), FECHA_APROBACION_ORDEN_ADM =CONVERT(VARCHAR, AGE.FECHA_APROB_ADM,23),FECHA_APROBACION_ORDEN_GER =CONVERT(VARCHAR, AGE.FECHA_APROB_GER,23),APROBADO    = CASE WHEN A.APROBADO = 1 THEN 'SI' ELSE 'NO'  END                         
            FROM SOLICITUD_DE_COMPRA C                                  
            INNER JOIN EMPRESAS WITH(NOLOCK) ON EMPRESAS.COD_EMP = C.COD_EMP                                     
            INNER JOIN ZONAS Z WITH(NOLOCK) ON Z.ZON = C.ZON AND Z.COD_TEM = C.COD_TEM AND Z.COD_EMP = C.COD_EMP                                     
            INNER JOIN DETALLE_SOLICITUD_DE_COMPRA D WITH(NOLOCK) ON C.COD_EMP = D.COD_EMP AND C.ZON = D.ZON AND C.NRO_SOLICITUD = D.NRO_SOLICITUD AND C.COD_TEM = D.COD_TEM                                     
            INNER JOIN SUBITEM SI WITH(NOLOCK) ON D.COD_TEM = SI.COD_TEM AND D.SUBITEM = SI.SUBITEM AND D.COD_EMP = SI.COD_EMP              
            INNER JOIN FAMILIA F ON F.COD_EMP = SI.COD_EMP AND F.COD_TEM = SI.COD_TEM AND F.FAMILIA = SI.FAMILIA        
            INNER JOIN ITEM I ON I.COD_EMP = SI.COD_EMP AND I.COD_TEM = SI.COD_TEM AND I.FAMILIA = SI.FAMILIA AND I.ITEM = SI.ITEM        
            LEFT JOIN AGRUPACION AG WITH(NOLOCK) ON AG.COD_EMP = SI.COD_EMP AND AG.COD_TEM = SI.COD_TEM AND AG.COD_AGRUP= SI.COD_AGRUP                                                                                        
            INNER JOIN UNID_MED WITH(NOLOCK) ON SI.COD_UNID = UNID_MED.COD_UNID AND SI.COD_EMP = UNID_MED.COD_EMP AND SI.COD_TEM = UNID_MED.COD_TEM                                     
            INNER JOIN RESPONSABLES RESP WITH(NOLOCK) ON RESP.COD_RESP = C.COD_RESP AND RESP.COD_TEM = C.COD_TEM AND RESP.COD_EMP = C.COD_EMP                    
            INNER JOIN RESPONSABLES RESP_EMI WITH(NOLOCK) ON RESP_EMI.COD_RESP = C.COD_RESP_EM AND RESP_EMI.COD_TEM = C.COD_TEM AND RESP_EMI.COD_EMP = C.COD_EMP                    
            LEFT JOIN CENTROCOSTO_CONT CC WITH(NOLOCK) ON CC.COD_EMP = D.COD_EMP AND CC.COD_CENTROCOSTO = D.COD_CENTROCOSTO                                                        
            LEFT JOIN SUB_CENTROCOSTO SCC WITH(NOLOCK) ON SCC.COD_EMP = D.COD_EMP AND SCC.COD_CENTROCOSTO = D.COD_CENTROCOSTO AND SCC.COD_SUBCENTRO = D.COD_SUBCENTRO                                                                                      
            LEFT JOIN DETALLEORDEN DO WITH(NOLOCK) ON DO.COD_EMP = D.COD_EMP AND DO.COD_TEM=D.COD_TEM AND DO.ZON_MAT=D.ZON AND D.NRO_SOLICITUD=DO.NRO_SOLICITUD AND DO.CORREL_SOLICITUD=D.CORREL AND D.SUBITEM=DO.SUBITEM                                    
            LEFT JOIN ORDEN O WITH(NOLOCK) ON O.COD_EMP = DO.COD_EMP AND O.COD_TEM = DO.COD_TEM AND O.ZON = DO.ZON AND O.NRO_ORDEN = DO.NRO_ORDEN                
            LEFT JOIN MONEDAS_CONT M WITH(NOLOCK) ON M.COD_EMP = O.COD_EMP AND M.COD_MONEDA = O.MONEDA           
            LEFT JOIN RECEPCIONMATERIALES R WITH(NOLOCK) ON R.COD_EMP = DO.COD_EMP AND R.COD_TEM = DO.COD_TEM AND R.ZON = DO.ZON_MAT AND R.ID_ORDEN = O.NRO_ORDEN AND R.SUBITEM = D.SUBITEM                 
            LEFT JOIN TIPO_PROGRAMA_APLICACION T WITH(NOLOCK)ON T.COD_EMP=D.COD_EMP AND T.COD_TEM=D.COD_TEM AND T.COD_TIPOPROG=D.COD_TIPOPROG                      
            LEFT JOIN SUBITEM_SERVICIOS W WITH(NOLOCK)ON W.COD_EMP=D.COD_EMP AND W.COD_TEM=D.COD_TEM AND W.SUBITEM=D.SUBITEM                                 
            LEFT JOIN APROBACION_SOLICITUD_DE_COMPRA A WITH(NOLOCK) ON A.COD_EMP = D.COD_EMP AND A.COD_TEM = D.COD_TEM AND A.NRO_SOLICITUD = D.NRO_SOLICITUD AND A.ZON = D.ZON AND A.CORREL = D.CORREL                                  
            LEFT JOIN APROBACION_ORDEN_GE_ADM AGE WITH(NOLOCK) ON AGE.COD_EMP = DO.COD_EMP AND AGE.COD_TEM = DO.COD_TEM AND AGE.ZON_MAT = DO.ZON_MAT AND AGE.NRO_ORDEN = DO.NRO_ORDEN                                  
            WHERE D.COD_EMP='{$COD_EMP}'   AND D.COD_TEM='{$COD_TEM}'  ".$sqlwhere." UNION ALL                                                                    
            SELECT  DISTINCT D.CORREL,C.NRO_SOLICITUD,[Cod. Material]= D.SUBITEM,[Descripcion Material]  = ISNULL(D.DESCRIPCION, W.DES_SITEM),CANTIDAD= D.CANTIDAD,CANTIDAD_APROBADA =(CASE WHEN ISNULL(A.CANTIDAD, 0)=0  THEN D.CANTIDAD  ELSE  ISNULL(A.CANTIDAD, 0) END),      
                [CANTIDAD OC]= ISNULL(DO.CANTIDAD,0),[CANTIDAD RECEPCIONADA] = ISNULL(R.CAN_REC, 0),D.COD_CENTROCOSTO,D.COD_SUBCENTRO,C.COD_EMP,C.ZON, C.COD_TEM, Z.NOM_ZON,
                Nombre_CentroCosto   = CC.DESCRIPCION ,Nombre_SubCentroCosto  = SCC.DESCRIPCION,ESTADO      = (CASE WHEN DO.COD_EMP IS NULL THEN 'Pendiente' ELSE 'Cerrada' END), NRO_ORDEN= O.NRO_ORDEN,             
                R.PLANILLA_REC,FECHA_SOLICITUD    =CONVERT(VARCHAR,C.FEC_SOLICITUD,23),FECHA_APROBACION_SOLICITUD =CONVERT(VARCHAR, A.FECHA,23),FECHA_ORDEN_COMPRA   =CONVERT(VARCHAR, O.FEC_ORDEN,23),FECHA_APROBACION_ORDEN  =CONVERT(VARCHAR, O.FECHA_ING,23),FECHA_APROBACION_ORDEN_ADM =CONVERT(VARCHAR, AGE.FECHA_APROB_ADM,23),                                  
                FECHA_APROBACION_ORDEN_GER =CONVERT(VARCHAR, AGE.FECHA_APROB_GER,23),APROBADO     = CASE WHEN A.APROBADO = 1 THEN 'SI' ELSE 'NO' END                         
            FROM SOLICITUD_DE_COMPRA C                                  
            --INNER JOIN EMPRESAS WITH(NOLOCK) ON EMPRESAS.COD_EMP = C.COD_EMP              
            INNER JOIN ZONAS Z WITH(NOLOCK) ON Z.ZON = C.ZON AND Z.COD_TEM = C.COD_TEM AND Z.COD_EMP = C.COD_EMP                 
            INNER JOIN DETALLE_SOLICITUD_DE_COMPRA_GEN D WITH(NOLOCK) ON C.COD_EMP = D.COD_EMP AND C.ZON = D.ZON AND C.NRO_SOLICITUD = D.NRO_SOLICITUD AND C.COD_TEM = D.COD_TEM              
            INNER JOIN EMPRESAS E  WITH(NOLOCK) ON E.COD_EMP = C.COD_EMP                
            INNER JOIN UNID_MED WITH(NOLOCK) ON D.UNID_MED = UNID_MED.COD_UNID AND D.COD_EMP = UNID_MED.COD_EMP AND D.COD_TEM = UNID_MED.COD_TEM                                     
            INNER JOIN RESPONSABLES RESP WITH(NOLOCK) ON RESP.COD_RESP = C.COD_RESP AND RESP.COD_TEM = C.COD_TEM AND RESP.COD_EMP = C.COD_EMP            
            INNER JOIN RESPONSABLES RESP_EMI WITH(NOLOCK) ON RESP_EMI.COD_RESP = C.COD_RESP_EM AND RESP_EMI.COD_TEM = C.COD_TEM AND RESP_EMI.COD_EMP = C.COD_EMP                
            LEFT JOIN CENTROCOSTO_CONT CC WITH(NOLOCK) ON CC.COD_EMP = D.COD_EMP AND CC.COD_CENTROCOSTO = D.COD_CENTROCOSTO                                                          
            LEFT JOIN SUB_CENTROCOSTO SCC WITH(NOLOCK) ON SCC.COD_EMP = D.COD_EMP AND SCC.COD_CENTROCOSTO = D.COD_CENTROCOSTO AND SCC.COD_SUBCENTRO = D.COD_SUBCENTRO                                                                                      
            LEFT JOIN DETALLEORDEN_GEN DO WITH(NOLOCK) ON DO.COD_EMP = D.COD_EMP AND DO.COD_TEM = D.COD_TEM AND DO.ZON_MAT = D.ZON AND D.NRO_SOLICITUD = DO.NRO_SOLICITUD AND DO.CORREL=D.CORREL AND (DO.SUBITEM = D.SUBITEM OR DO.SUBITEM IS NULL)            
            LEFT JOIN ORDEN O WITH(NOLOCK) ON O.COD_EMP = DO.COD_EMP AND O.COD_TEM = DO.COD_TEM AND O.ZON = DO.ZON AND O.NRO_ORDEN = DO.NRO_ORDEN            
            LEFT JOIN MONEDAS_CONT M WITH(NOLOCK) ON M.COD_EMP = O.COD_EMP AND M.COD_MONEDA = O.MONEDA              
            LEFT JOIN SUBITEM_SERVICIOS W WITH(NOLOCK)ON W.COD_EMP=D.COD_EMP AND W.COD_TEM=D.COD_TEM AND W.SUBITEM=D.SUBITEM   
            LEFT JOIN FAMILIA_SERVICIOS F WITH(NOLOCK) ON F.COD_EMP = W.COD_EMP AND F.COD_TEM = W.COD_TEM AND F.FAMILIA = W.FAMILIA            
            LEFT JOIN ITEM_SERVICIOS I WITH(NOLOCK) ON I.COD_EMP = W.COD_EMP AND I.COD_TEM = W.COD_TEM AND I.FAMILIA = W.FAMILIA AND I.ITEM = W.ITEM            
            LEFT JOIN RECEPCIONSERVICIOS R WITH(NOLOCK) ON R.COD_EMP = DO.COD_EMP AND R.COD_TEM = DO.COD_TEM AND R.ZON = DO.ZON_MAT AND R.ID_ORDEN = DO.NRO_ORDEN AND R.SUBITEM = DO.SUBITEM               
            LEFT JOIN MAQUINARIAS MAQ WITH(NOLOCK) ON MAQ.COD_EMP = D.COD_EMP AND MAQ.COD_TEM = D.COD_TEM AND MAQ.COD_MAQ = D.COD_MAQ                   
            LEFT JOIN APROBACION_SOLICITUD_DE_COMPRA_GEN A WITH(NOLOCK) ON A.COD_EMP = D.COD_EMP AND A.COD_TEM = D.COD_TEM AND A.NRO_SOLICITUD = D.NRO_SOLICITUD AND A.ZON = D.ZON AND A.CORREL = D.CORREL                                  
            LEFT JOIN APROBACION_ORDEN_GE_ADM AGE WITH(NOLOCK) ON AGE.COD_EMP = DO.COD_EMP AND AGE.COD_TEM = DO.COD_TEM AND AGE.ZON_MAT = DO.ZON_MAT AND AGE.NRO_ORDEN = DO.NRO_ORDEN                                  
            WHERE D.COD_EMP='{$COD_EMP}'  AND D.COD_TEM='$COD_TEM' ".$sqlwhere." ORDER BY C.NRO_SOLICITUD DESC , SI.DES_SITEM ASC  ";
             
       

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