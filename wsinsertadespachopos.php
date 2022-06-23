<?PHP
$hostname_localhost="192.168.2.210";


if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	 

	$info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["TIP_TRA"])&&isset($_GET["NRO_ORDEN"])&&isset($_GET["COD_REC"])&&isset($_GET["PATENTE"])&&
    isset($_GET["LOTE"])&&isset($_GET["FECHA"])&&isset($_GET["HORA"])&&isset($_GET["TEMP"])&&isset($_GET["NRO_TER"])&&isset($_GET["IDUSUARIO"])&&isset($_GET["LADO"])&&isset($_GET["POSICION"])){
        

        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $TIP_TRA=$_GET["TIP_TRA"];
        $NRO_ORDEN=$_GET["NRO_ORDEN"];
        $COD_REC=$_GET["COD_REC"];
        $PATENTE=$_GET["PATENTE"];
        $LOTE=$_GET["LOTE"];    
        $FECHA=$_GET["FECHA"];
        $HORA=$_GET["HORA"];
        $TEMP=$_GET["TEMP"];
        $NRO_TER=$_GET["NRO_TER"];
        $IDUSUARIO=$_GET["IDUSUARIO"];
        $LADO=$_GET["LADO"];
        $POSICION=$_GET["POSICION"];
      
        
        $consultaantes="SELECT LOTE FROM ANDROID_DESPACHO WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND LOTE='{$LOTE}' ";

       
        $PATENTE=str_replace(' ','',$PATENTE);
       
        
        
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        if($registro=sqlsrv_fetch_array($resultadoantes)){
            if($registro['LOTE']==$LOTE){
                $data=array('id'=>'REGISTRA'); 
                $json[]=$data;
                echo json_encode($json);
            }
        }else{
            $consulta="INSERT INTO ANDROID_DESPACHO (COD_EMP, COD_TEM, TIP_TRA, NRO_ORDEN, COD_REC, PATENTE, LOTE, FECHA, HORA, TEMP, NRO_TER, IDUSUARIO,SW_ENVIADO, LADO,POSICION)          
            VALUES('{$COD_EMP}', '{$COD_TEM}', '{$TIP_TRA}', '{$NRO_ORDEN}', '{$COD_REC}', '{$PATENTE}', '{$LOTE}', '{$FECHA}', '{$HORA}', '{$TEMP}', '{$NRO_TER}', '{$IDUSUARIO}',0,'{$LADO}','{$POSICION}')";
        

            $resultado=sqlsrv_query($conexion,$consulta);
            
             if($resultado){
                $resulta["id"]='REGISTRA';
                $json[]=$resulta;
                echo json_encode($json);
            }
            else{
                $resulta["id"]='NO REGISTRA';
                $json[]=$resulta;
                echo json_encode($json);
            }
        }
        
        
        		
		
		

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
