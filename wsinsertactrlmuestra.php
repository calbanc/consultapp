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
                


                if(isset($_GET["LLAVE"])&&isset($_GET["COD_TEM"])&&isset($_GET["COD_EMP"])&&isset($_GET["ZON"])&&
                isset($_GET["TIPO"])&&isset($_GET["PLANILLA_PROCESO"])&&isset($_GET["COL"])&&isset($_GET["ROW"])&&
                isset($_GET["DESCRIPCION"])&&isset($_GET["GRILLA"])&&isset($_GET["ITEM"])&&isset($_GET["GRUPO"])&&
                isset($_GET["COD_FAMILIA"])){

                    $LLAVE=$_GET["LLAVE"];
                    $COD_EMP=$_GET["COD_EMP"];
                    $COD_TEM=$_GET["COD_TEM"];
                    $ZON=$_GET["ZON"];
                    $TIPO=$_GET["TIPO"];
                    $PLANILLA_PROCESO=$_GET["PLANILLA_PROCESO"];
                    $COL=$_GET["COL"];
                    $ROW=$_GET["ROW"];
                    $DESCRIPCION=$_GET["DESCRIPCION"];
                    $GRILLA=$_GET["GRILLA"];
                    $ITEM=$_GET["ITEM"];
                    $GRUPO=$_GET["GRUPO"];
                    $COD_FAMILIA=$_GET["COD_FAMILIA"];
                    
                    $consultaantes="SELECT LLAVE FROM CTRL_MUESTRAS_ANDROID WHERE LLAVE='{$LLAVE}'";
                    $resultadoantes=sqlsrv_query($conexion,$consultaantes);
                    if($registross=sqlsrv_fetch_array($resultadoantes)){
                            if($registross['Llave']==$Llave){
                                $data=array('id'=>'REGISTRA'); 
                                $json[]=$data;
                                echo json_encode($json);
                            }else{        
                                $data=array('id'=>'REGISTRA'); 
                                $json[]=$data;
                                echo json_encode($json);
                                            
                            }
                    
                    }else{

                        if($GRILLA =='1' ){
                    
                            $consulta="INSERT INTO CTRL_MUESTRAS_ANDROID(LLAVE,COD_TEM,COD_EMP,ZON,TIPO,PLANILLA_PROCESO,COL,ROW,DESCRIPCION,GRILLA)
                            VALUES ('{$LLAVE}','{$COD_TEM}','{$COD_EMP}','{$ZON}','{$TIPO}','{$PLANILLA_PROCESO}','{$COL}','{$ROW}','{$DESCRIPCION}','{$GRILLA}')";
                        
                        }else{
                            $consulta="INSERT INTO CTRL_MUESTRAS_ANDROID(LLAVE,COD_TEM,COD_EMP,ZON,TIPO,PLANILLA_PROCESO,COL,ROW,DESCRIPCION,GRILLA,ITEM,GRUPO,COD_FAMILIA)
                            VALUES ('{$LLAVE}','{$COD_TEM}','{$COD_EMP}','{$ZON}','{$TIPO}','{$PLANILLA_PROCESO}','{$COL}','{$ROW}','{$DESCRIPCION}','{$GRILLA}','{$ITEM}','{$GRUPO}','{$COD_FAMILIA}')";
                            
                        }
                        
                
                
                    
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