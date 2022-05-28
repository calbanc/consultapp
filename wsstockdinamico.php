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
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["ZON"])&&isset($_GET["COD_BOD"])&&isset($_GET["SUBITEM"])
    &&isset($_GET["TIPO"])&&isset($_GET["CODAGRUP"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $ZON=$_GET["ZON"];
        $COD_BOD=$_GET["COD_BOD"];
        $SUBITEM=$_GET["SUBITEM"];
        $TIPO=$_GET["TIPO"];
		$CODAGRUP=$_GET["CODAGRUP"];
        $sqlwhere="";
        $consulta="";
	
		
		if($ZON!='TODOS'){
			$sqlwhere.=",@ZON='{$ZON}'";

		}

		if($COD_BOD!='TODOS'){
			$sqlwhere.=",@COD_BOD='{$COD_BOD}'";
		}

		if($CODAGRUP!='TODOS'){
			$sqlwhere.=",@COD_AGRUP='{$CODAGRUP}'";
		}

		if($SUBITEM!='TODOS'){
			$sqlwhere.=",@SUBITEM='{$SUBITEM}'";
		}

        if($TIPO=='1'){
            $consulta="SELECT [COD_AGRUP],[DESCRIPCION] FROM [erpfrusys].[dbo].[AGRUPACION] WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND  SW_INSUMO=1 ";
        }

		if($TIPO=='2'){
			//$consulta="SPC_STOCK_DINAMICO @COD_EMP='{$COD_EMP}', @COD_TEM='{$COD_TEM}' ".$sqlwhere;

		 	$consulta="SELECT DISTINCT 
			[Codigo Material], [Nombre Material]  
		   FROM      
		   (      
		   SELECT  SI.FAMILIA AS [Codigo Familia], F.DESC_FAM AS [Nombre Familia],       
			SI.ITEM AS [Codigo SubFamilia], I.DESC_ITEM AS [Nombre SubFamilia],      
			RM.SUBITEM as [Codigo Material], SI.DES_SITEM AS [Nombre Material],       
			SI.COD_AGRUP AS [Agrupación Material], SI.COD_UNID AS [Unidad Medida],       
			 (BD.COD_BOD + ' ' + BD.NOM_BOD) AS [Bodega Stock],BD.COD_BOD as COD_BOD,       
			RM.CAN_REC AS [Cant. Recepcionada], 0 AS [Cant. Despachada], 0 AS [Devolución],  
			TIT_R.ZON AS [Cod. Zona], Z.NOM_ZON AS [Zona] ,SI.ING_ACTIVO      
		   FROM TIT_RECEPCIONMATERIALES TIT_R       
			INNER JOIN RECEPCIONMATERIALES RM ON  TIT_R.COD_EMP = RM.COD_EMP AND TIT_R.COD_TEM = RM.COD_TEM AND  TIT_R.ZON = RM.ZON AND TIT_R.PLANILLA_REC = RM.PLANILLA_REC       
			INNER JOIN SUBITEM SI ON  RM.COD_EMP = SI.COD_EMP AND RM.COD_TEM = SI.COD_TEM AND  RM.SUBITEM = SI.SUBITEM       
			INNER JOIN ITEM I ON  I.COD_EMP = SI.COD_EMP AND I.COD_TEM = SI.COD_TEM AND I.FAMILIA = SI.FAMILIA AND I.ITEM = SI.ITEM      
			INNER JOIN FAMILIA F ON  F.COD_EMP = SI.COD_EMP AND F.COD_TEM = SI.COD_TEM AND F.FAMILIA = SI.FAMILIA       
			LEFT JOIN BODEGAS BD ON  TIT_R.COD_BOD = BD.COD_BOD AND  TIT_R.COD_TEM = BD.COD_TEM AND TIT_R.COD_EMP = BD.COD_EMP       
			INNER JOIN ZONAS Z ON TIT_R.COD_TEM = Z.COD_TEM AND TIT_R.COD_EMP = Z.COD_EMP AND TIT_R.ZON = Z.ZON       
		   WHERE  TIT_R.COD_EMP = '{$COD_EMP}' AND TIT_R.COD_TEM = '{$COD_TEM}' AND RM.CAN_REC>0      
			AND (TIT_R.ZON=NULL OR NULL IS NULL) 
			AND (TIT_R.COD_BOD=NULL OR NULL IS NULL)
			AND (RM.SUBITEM=NULL OR NULL IS NULL) 
			AND (SI.COD_AGRUP=NULL OR NULL IS NULL) 
			AND (TIT_R.FECHA_RECEPCION BETWEEN NULL AND NULL OR NULL IS NULL)
				 
		   UNION ALL      
				 
		   SELECT  SI.FAMILIA AS [Codigo Familia], F.DESC_FAM AS [Nombre Familia],       
			SI.ITEM AS [Codigo SubFamilia], I.DESC_ITEM AS [Nombre SubFamilia],      
			dM.SUBITEM as [Codigo Material], SI.DES_SITEM AS [Nombre Material],       
			SI.COD_AGRUP AS [Agrupación Material], SI.COD_UNID AS [Unidad Medida],       
			(BO.COD_BOD + ' ' + BO.NOM_BOD) AS [Bodega Stock],BO.COD_BOD as COD_BOD,         
			0 AS [Cant. Recepcionada],  (SUM((DM.CAN_DES)-ISNULL(DM.CANTIDAD_DEV,0)) * -1) AS [Cant. Despachada], ISNULL(DM.CANTIDAD_DEV,0) AS [Devolución],   
			TIT_D.ZON AS [Cod. Zona], Z.NOM_ZON AS [Zona]  ,SI.ING_ACTIVO      
			FROM TIT_DESPACHOMATERIALES TIT_D       
			INNER JOIN DESPACHOMATERIALES DM ON  TIT_D.COD_EMP = DM.COD_EMP AND TIT_D.COD_TEM = DM.COD_TEM AND  TIT_D.ZON = DM.ZON AND TIT_D.PLANILLA_DES = DM.PLANILLA_DES       
			INNER JOIN SUBITEM SI ON  SI.COD_EMP = DM.COD_EMP AND SI.COD_TEM = DM.COD_TEM AND SI.SUBITEM = DM.SUBITEM       
			INNER JOIN ITEM I ON  I.COD_EMP = SI.COD_EMP AND I.COD_TEM = SI.COD_TEM AND I.FAMILIA = SI.FAMILIA AND I.ITEM = SI.ITEM      
			INNER JOIN FAMILIA F ON F.COD_EMP = SI.COD_EMP AND F.COD_TEM = SI.COD_TEM AND F.FAMILIA = SI.FAMILIA       
			INNER JOIN ZONAS Z ON TIT_D.COD_TEM = Z.COD_TEM AND TIT_D.COD_EMP = Z.COD_EMP AND TIT_D.ZON = Z.ZON       
			LEFT JOIN BODEGAS BO ON  TIT_D.COD_EMP = BO.COD_EMP AND TIT_D.COD_TEM = BO.COD_TEM AND  TIT_D.COD_BOD = BO.COD_BOD        
			WHERE  TIT_D.COD_EMP = '{$COD_EMP}' AND TIT_D.COD_TEM = '{$COD_TEM}' AND DM.CAN_DES > 0   
			AND (TIT_D.ZON=NULL OR NULL IS NULL) 
			AND (TIT_D.COD_BOD=NULL OR NULL IS NULL)
			AND (DM.SUBITEM=NULL OR NULL IS NULL) 
			AND (SI.COD_AGRUP=NULL OR NULL IS NULL) 
			AND (TIT_D.FECHA_DESPACHO BETWEEN NULL AND NULL OR NULL IS NULL)
		   GROUP BY SI.FAMILIA, F.DESC_FAM, SI.ITEM, I.DESC_ITEM,  DM.SUBITEM, TIT_D.FECHA_DESPACHO, DM.PLANILLA_DES, TIT_D.COD_BOD,       
			SI.DES_SITEM, SI.COD_AGRUP, SI.COD_UNID, TIT_D.COD_MOV,       
			Z.NOM_ZON, BO.COD_BOD, BO.NOM_BOD,             
			TIT_D.COD_EMP, TIT_D.COD_TEM, TIT_D.ZON, SI.COD_ESP, DM.CANTIDAD_DEV ,SI.ING_ACTIVO    
		   )KARDEX 
		   LEFT JOIN DISPONIBILIDAD_TRASLADOS D ON D.COD_EMP='{$COD_EMP}' AND '{$COD_TEM}' = D.COD_TEM AND KARDEX.[Codigo Material] = D.SUBITEM AND KARDEX.[Cod. Zona]=D.ZON AND KARDEX.COD_BOD=D.COD_BOD 
			 
		   GROUP BY [Codigo Familia],[Nombre Familia], [Codigo SubFamilia], [Nombre SubFamilia],      
			[Codigo Material], [Nombre Material],[Agrupación Material], [Unidad Medida], [Bodega Stock] ,[Zona],ING_ACTIVO,KARDEX.COD_BOD,KARDEX.[Cod. Zona],D.CANTIDAD
			HAVING SUM([Cant. Recepcionada] + [Cant. Despachada]) <>0
		   
		   "; 
		}

		if($TIPO=='3'){
			$consulta="SPC_STOCK_DINAMICO @COD_EMP='{$COD_EMP}', @COD_TEM='{$COD_TEM}' ".$sqlwhere;
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