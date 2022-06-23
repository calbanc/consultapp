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
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["COD_BOD"])&&isset($_GET["SUBITEM"])
    &&isset($_GET["TIPO"])&&isset($_GET["ING_ACTIVO"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $ZON=$_GET["ZON"];
        $COD_BOD=$_GET["COD_BOD"];
        $SUBITEM=$_GET["SUBITEM"];
        $TIPO=$_GET["TIPO"];
       
		$ING_ACTIVO=$_GET["ING_ACTIVO"];
        $sqlwhereR="";
        $sqlwhereD="";
        $consulta="";
	
		if($COD_EMP!='TODOS'){
            $sqlwhereR.=" AND TIT_R.COD_EMP='{$COD_EMP}'";
            $sqlwhereD.=" AND TIT_D.COD_EMP='{$COD_EMP}' ";
        }else{
            $sqlwhereR.=" AND e.SW_extranjera='1' ";
            $sqlwhereD.=" AND e.SW_extranjera='1' ";
        }

		if($COD_BOD!='TODOS'){
            $sqlwhereR.=" AND TIT_R.COD_BOD='{$COD_BOD}' ";
            $sqlwhereD.=" AND TIT_D.COD_BOD='{$COD_BOD}' ";

		}

		if($ING_ACTIVO!='TODOS'){
            $sqlwhereR.=" AND SI.ING_ACTIVO='{$ING_ACTIVO}' ";
            $sqlwhereD.=" AND SI.ING_ACTIVO='{$ING_ACTIVO}' ";
            
		}

		if($SUBITEM!='TODOS'){
            $sqlwhereR.=" AND SI.SUBITEM='{$SUBITEM}' ";
            $sqlwhereD.=" AND SI.SUBITEM='{$SUBITEM}' ";
		}
      
      
        if($TIPO=='1'){

            $consulta="SELECT [Codigo Material], [Nombre Material], [Bodega Stock] ,ISNULL(ING_ACTIVO,'') AS ING_ACTIVO,KARDEX.COD_BOD
            ,sum([Cant. Recepcionada] + [Cant. Despachada]) AS [Stock]     
           FROM      
           (SELECT RM.SUBITEM as [Codigo Material], SI.DES_SITEM AS [Nombre Material],       
             (BD.COD_BOD + ' ' + BD.NOM_BOD) AS [Bodega Stock],BD.COD_BOD as COD_BOD,       
            RM.CAN_REC AS [Cant. Recepcionada], 0 AS [Cant. Despachada], 0 AS [Devolución],  
             SI.ING_ACTIVO      
           FROM TIT_RECEPCIONMATERIALES TIT_R       
            INNER JOIN RECEPCIONMATERIALES RM ON  TIT_R.COD_EMP = RM.COD_EMP AND TIT_R.COD_TEM = RM.COD_TEM AND  TIT_R.ZON = RM.ZON AND TIT_R.PLANILLA_REC = RM.PLANILLA_REC       
            INNER JOIN SUBITEM SI ON  RM.COD_EMP = SI.COD_EMP AND RM.COD_TEM = SI.COD_TEM AND  RM.SUBITEM = SI.SUBITEM       
            LEFT JOIN BODEGAS BD ON  TIT_R.COD_BOD = BD.COD_BOD AND  TIT_R.COD_TEM = BD.COD_TEM AND TIT_R.COD_EMP = BD.COD_EMP       
            INNER JOIN EMPRESAS E ON E.COD_EMP=TIT_R.COD_EMP
           WHERE TIT_R.COD_TEM = '{$COD_TEM}' AND RM.CAN_REC>0".$sqlwhereR."      
           UNION ALL      
            SELECT dM.SUBITEM as [Codigo Material], SI.DES_SITEM AS [Nombre Material],       
             (BO.COD_BOD + ' ' + BO.NOM_BOD) AS [Bodega Stock],BO.COD_BOD as COD_BOD,         
            0 AS [Cant. Recepcionada],  (SUM((DM.CAN_DES)-ISNULL(DM.CANTIDAD_DEV,0)) * -1) AS [Cant. Despachada], ISNULL(DM.CANTIDAD_DEV,0) AS [Devolución],   
           SI.ING_ACTIVO      
            FROM TIT_DESPACHOMATERIALES TIT_D       
            INNER JOIN DESPACHOMATERIALES DM ON  TIT_D.COD_EMP = DM.COD_EMP AND TIT_D.COD_TEM = DM.COD_TEM AND  TIT_D.ZON = DM.ZON AND TIT_D.PLANILLA_DES = DM.PLANILLA_DES       
            INNER JOIN SUBITEM SI ON  SI.COD_EMP = DM.COD_EMP AND SI.COD_TEM = DM.COD_TEM AND SI.SUBITEM = DM.SUBITEM       
            LEFT JOIN BODEGAS BO ON  TIT_D.COD_EMP = BO.COD_EMP AND TIT_D.COD_TEM = BO.COD_TEM AND  TIT_D.COD_BOD = BO.COD_BOD
            INNER JOIN EMPRESAS E ON E.COD_EMP=TIT_D.COD_EMP
            WHERE   TIT_D.COD_TEM = '{$COD_TEM}' AND DM.CAN_DES > 0".$sqlwhereD."   
           
           GROUP BY  DM.SUBITEM, TIT_D.FECHA_DESPACHO, DM.PLANILLA_DES, TIT_D.COD_BOD,       
            SI.DES_SITEM, SI.COD_AGRUP, SI.COD_UNID, TIT_D.COD_MOV,       
            BO.COD_BOD, BO.NOM_BOD,             
            TIT_D.COD_EMP, TIT_D.COD_TEM, TIT_D.ZON, SI.COD_ESP, DM.CANTIDAD_DEV ,SI.ING_ACTIVO    
           )KARDEX 
           GROUP BY 
            [Codigo Material], [Nombre Material], [Bodega Stock] ,ING_ACTIVO,KARDEX.COD_BOD
            HAVING SUM([Cant. Recepcionada] + [Cant. Despachada]) <>0";
        

		
	
        }

        if($TIPO=='2'){
            $consulta="SELECT distinct [Codigo Material], [Nombre Material]
           FROM      
           (SELECT RM.SUBITEM as [Codigo Material], SI.DES_SITEM AS [Nombre Material],       
             (BD.COD_BOD + ' ' + BD.NOM_BOD) AS [Bodega Stock],BD.COD_BOD as COD_BOD,       
            RM.CAN_REC AS [Cant. Recepcionada], 0 AS [Cant. Despachada], 0 AS [Devolución],  
             SI.ING_ACTIVO      
           FROM TIT_RECEPCIONMATERIALES TIT_R       
            INNER JOIN RECEPCIONMATERIALES RM ON  TIT_R.COD_EMP = RM.COD_EMP AND TIT_R.COD_TEM = RM.COD_TEM AND  TIT_R.ZON = RM.ZON AND TIT_R.PLANILLA_REC = RM.PLANILLA_REC       
            INNER JOIN SUBITEM SI ON  RM.COD_EMP = SI.COD_EMP AND RM.COD_TEM = SI.COD_TEM AND  RM.SUBITEM = SI.SUBITEM       
            LEFT JOIN BODEGAS BD ON  TIT_R.COD_BOD = BD.COD_BOD AND  TIT_R.COD_TEM = BD.COD_TEM AND TIT_R.COD_EMP = BD.COD_EMP       
            INNER JOIN EMPRESAS E ON E.COD_EMP=TIT_R.COD_EMP
           WHERE TIT_R.COD_TEM = '{$COD_TEM}' AND RM.CAN_REC>0".$sqlwhereR."      
           UNION ALL      
            SELECT dM.SUBITEM as [Codigo Material], SI.DES_SITEM AS [Nombre Material],       
             (BO.COD_BOD + ' ' + BO.NOM_BOD) AS [Bodega Stock],BO.COD_BOD as COD_BOD,         
            0 AS [Cant. Recepcionada],  (SUM((DM.CAN_DES)-ISNULL(DM.CANTIDAD_DEV,0)) * -1) AS [Cant. Despachada], ISNULL(DM.CANTIDAD_DEV,0) AS [Devolución],   
           SI.ING_ACTIVO      
            FROM TIT_DESPACHOMATERIALES TIT_D       
            INNER JOIN DESPACHOMATERIALES DM ON  TIT_D.COD_EMP = DM.COD_EMP AND TIT_D.COD_TEM = DM.COD_TEM AND  TIT_D.ZON = DM.ZON AND TIT_D.PLANILLA_DES = DM.PLANILLA_DES       
            INNER JOIN SUBITEM SI ON  SI.COD_EMP = DM.COD_EMP AND SI.COD_TEM = DM.COD_TEM AND SI.SUBITEM = DM.SUBITEM       
            LEFT JOIN BODEGAS BO ON  TIT_D.COD_EMP = BO.COD_EMP AND TIT_D.COD_TEM = BO.COD_TEM AND  TIT_D.COD_BOD = BO.COD_BOD
            INNER JOIN EMPRESAS E ON E.COD_EMP=TIT_D.COD_EMP
            WHERE   TIT_D.COD_TEM = '{$COD_TEM}' AND DM.CAN_DES > 0".$sqlwhereD."   
           
           GROUP BY  DM.SUBITEM, TIT_D.FECHA_DESPACHO, DM.PLANILLA_DES, TIT_D.COD_BOD,       
            SI.DES_SITEM, SI.COD_AGRUP, SI.COD_UNID, TIT_D.COD_MOV,       
            BO.COD_BOD, BO.NOM_BOD,             
            TIT_D.COD_EMP, TIT_D.COD_TEM, TIT_D.ZON, SI.COD_ESP, DM.CANTIDAD_DEV ,SI.ING_ACTIVO    
           )KARDEX 
           GROUP BY 
            [Codigo Material], [Nombre Material], [Bodega Stock] ,ING_ACTIVO,KARDEX.COD_BOD
            HAVING SUM([Cant. Recepcionada] + [Cant. Despachada]) <>0";
        

        }
        if($TIPO=='3'){
            $consulta="SELECT distinct  ING_ACTIVO
            FROM      
            (SELECT RM.SUBITEM as [Codigo Material], SI.DES_SITEM AS [Nombre Material],       
              (BD.COD_BOD + ' ' + BD.NOM_BOD) AS [Bodega Stock],BD.COD_BOD as COD_BOD,       
             RM.CAN_REC AS [Cant. Recepcionada], 0 AS [Cant. Despachada], 0 AS [Devolución],  
              SI.ING_ACTIVO      
            FROM TIT_RECEPCIONMATERIALES TIT_R       
             INNER JOIN RECEPCIONMATERIALES RM ON  TIT_R.COD_EMP = RM.COD_EMP AND TIT_R.COD_TEM = RM.COD_TEM AND  TIT_R.ZON = RM.ZON AND TIT_R.PLANILLA_REC = RM.PLANILLA_REC       
             INNER JOIN SUBITEM SI ON  RM.COD_EMP = SI.COD_EMP AND RM.COD_TEM = SI.COD_TEM AND  RM.SUBITEM = SI.SUBITEM       
             LEFT JOIN BODEGAS BD ON  TIT_R.COD_BOD = BD.COD_BOD AND  TIT_R.COD_TEM = BD.COD_TEM AND TIT_R.COD_EMP = BD.COD_EMP       
             INNER JOIN EMPRESAS E ON E.COD_EMP=TIT_R.COD_EMP
            WHERE TIT_R.COD_TEM = '{$COD_TEM}' AND RM.CAN_REC>0".$sqlwhereR."      
            UNION ALL      
             SELECT dM.SUBITEM as [Codigo Material], SI.DES_SITEM AS [Nombre Material],       
              (BO.COD_BOD + ' ' + BO.NOM_BOD) AS [Bodega Stock],BO.COD_BOD as COD_BOD,         
             0 AS [Cant. Recepcionada],  (SUM((DM.CAN_DES)-ISNULL(DM.CANTIDAD_DEV,0)) * -1) AS [Cant. Despachada], ISNULL(DM.CANTIDAD_DEV,0) AS [Devolución],   
            SI.ING_ACTIVO      
             FROM TIT_DESPACHOMATERIALES TIT_D       
             INNER JOIN DESPACHOMATERIALES DM ON  TIT_D.COD_EMP = DM.COD_EMP AND TIT_D.COD_TEM = DM.COD_TEM AND  TIT_D.ZON = DM.ZON AND TIT_D.PLANILLA_DES = DM.PLANILLA_DES       
             INNER JOIN SUBITEM SI ON  SI.COD_EMP = DM.COD_EMP AND SI.COD_TEM = DM.COD_TEM AND SI.SUBITEM = DM.SUBITEM       
             LEFT JOIN BODEGAS BO ON  TIT_D.COD_EMP = BO.COD_EMP AND TIT_D.COD_TEM = BO.COD_TEM AND  TIT_D.COD_BOD = BO.COD_BOD
             INNER JOIN EMPRESAS E ON E.COD_EMP=TIT_D.COD_EMP
             WHERE   TIT_D.COD_TEM = '{$COD_TEM}' AND DM.CAN_DES > 0".$sqlwhereD."   
            
            GROUP BY  DM.SUBITEM, TIT_D.FECHA_DESPACHO, DM.PLANILLA_DES, TIT_D.COD_BOD,       
             SI.DES_SITEM, SI.COD_AGRUP, SI.COD_UNID, TIT_D.COD_MOV,       
             BO.COD_BOD, BO.NOM_BOD,             
             TIT_D.COD_EMP, TIT_D.COD_TEM, TIT_D.ZON, SI.COD_ESP, DM.CANTIDAD_DEV ,SI.ING_ACTIVO    
            )KARDEX 
            GROUP BY 
             [Codigo Material], [Nombre Material], [Bodega Stock] ,ING_ACTIVO,KARDEX.COD_BOD
             HAVING SUM([Cant. Recepcionada] + [Cant. Despachada]) <>0";
        }
     

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