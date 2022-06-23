<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
    if(isset($_GET["COD_EMP"])
    &&isset($_GET["COD_TEM"])   
    &&isset($_GET["PLANILLA"])
    &&isset($_GET["LOTE"])
    &&isset($_GET["CANTIDAD"])
    &&isset($_GET["CHOFER"])
    &&isset($_GET["PATENTE"])
    &&isset($_GET["ZON"])
    &&isset($_GET["TIP_MOV"])
    &&isset($_GET["ZON_DEST"])
    &&isset($_GET["COD_FRIO_DEST"])
    &&isset($_GET["COD_REC"])
    &&isset($_GET["RUT_CHOFER"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $PLANILLA=$_GET["PLANILLA"];
        $LOTE=$_GET["LOTE"];
        $CANTIDAD=$_GET["CANTIDAD"];
        $CHOFER=$_GET["CHOFER"];
        $PATENTE=$_GET["PATENTE"];
        $COD_REC=$_GET["COD_REC"];
        $ZON=$_GET["ZON"];
        $RUT_CHOFER=$_GET["RUT_CHOFER"];
        $TIP_MOV=$_GET["TIP_MOV"];
        $ZON_DEST=$_GET["ZON_DEST"];
        $COD_FRIO_DEST=$_GET["COD_FRIO_DEST"];
        $COD_TRP=$_GET["COD_TRP"];


        $consulta1="SELECT ZON,COD_PACK,COD_FRI FROM PACKINGS_PARAMETROS WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND IDUSUARIO='{$usuario}' ";
  
       
        $resultado2=sqlsrv_query($conexion,$consulta1);
        $registros=sqlsrv_fetch_array($resultado2);
     
        $COD_PACK=$registros['COD_PACK'];
        $COD_FRI=$registros['COD_FRI'];


        


        $consultaantes="SELECT LOTE,PLANILLA FROM ANDROID_DESPACK WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}'  AND PLANILLA='{$PLANILLA}' AND LOTE='{$LOTE}' AND ZON='{$ZON}'  " ;
       
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        if($registross=sqlsrv_fetch_array($resultadoantes)){
            $loteservidor=$registross['LOTE'];  
            if($loteservidor==$LOTE){
               $json[]=$registross;
                echo json_encode($json);
            }			
        }else{

            if($TIP_MOV=='T'){
                $consulta="INSERT INTO ANDROID_DESPACK(COD_EMP,COD_TEM,PLANILLA,COD_PACK,COD_FRI,LOTE,ZON,CANTIDAD,CHOFER,PATENTE,RUT_CHOFER,TIP_MOV,ZON_DEST,COD_FRIO_DEST,COD_TRP)
                VALUES('{$COD_EMP}','{$COD_TEM}','{$PLANILLA}','{$COD_PACK}','{$COD_FRI}','{$LOTE}','{$ZON}','{$CANTIDAD}','{$CHOFER}','{$PATENTE}','{$RUT_CHOFER}','{$TIP_MOV}','{$ZON_DEST}','{$COD_FRIO_DEST}','{$COD_TRP}')";
          
            }else{
                $consulta="INSERT INTO ANDROID_DESPACK(COD_EMP,COD_TEM,PLANILLA,COD_PACK,COD_FRI,LOTE,ZON,CANTIDAD,CHOFER,PATENTE,TIP_REC,COD_REC,RUT_CHOFER,TIP_MOV,COD_TRP)
                VALUES('{$COD_EMP}','{$COD_TEM}','{$PLANILLA}','{$COD_PACK}','{$COD_FRI}','{$LOTE}','{$ZON}','{$CANTIDAD}','{$CHOFER}','{$PATENTE}','C','{$COD_REC}','{$RUT_CHOFER}','{$TIP_MOV}','{$COD_TRP}')";
          
            }

         
              
                    $resultado=sqlsrv_query($conexion,$consulta);

                    if($resultado){

                       $consultadespues="SELECT LOTE,PLANILLA FROM ANDROID_DESPACK WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}'  AND PLANILLA='{$PLANILLA}' AND LOTE='{$LOTE}' AND ZON='{$ZON}'  " ;
                       $resultadodespues=sqlsrv_query($conexion,$consultadespues);
                       if($registrosdespues=sqlsrv_fetch_array($resultadodespues)){
                            $json[]=$registrosdespues;
                            echo json_encode($json);
                       }
       
                    }else{
                        $data=array(
                            'id'=>'NO REGISTRADO'
                        );
                        $json[]=$data;
                        echo json_encode($json);
                    }
    

            
            

        
    }
		
		

	}else{
		$resultar["message"]='faltan datos';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	$data=array(
        'id'=>'CONEXION'
    );  
    $json[]=$data;
    echo json_encode($json);
}
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
} 
	
?>