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
    if(isset($_GET["ZON"])   
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["COD_EMP"])
    &&isset($_GET["FECHA"])
    &&isset($_GET["LOTE"])
    &&isset($_GET["HORA"])
    &&isset($_GET["IDUSUARIO"])
    &&isset($_GET["PISO"])
    &&isset($_GET["COD_FRI"])
    &&isset($_GET["FILA"])
    &&isset($_GET["COD_BANDA"])
    &&isset($_GET["COD_CAM"])
    &&isset($_GET["TEMP"])){
        
       
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        $ZON=$_GET["ZON"];
        $FECHA=$_GET["FECHA"];
        $LOTE=$_GET["LOTE"];
        $CANTIDAD=$_GET["CANTIDAD"];
        $PISO=$_GET["PISO"];
        $IDUSUARIO=$_GET["IDUSUARIO"];
        $TEMP=$_GET["TEMP"];
        $COD_PRO=$_GET["COD_PRO"];
        $COD_FRI=$_GET["COD_FRI"];
        $FILA=$_GET["FILA"];
        $COD_BANDA=$_GET["COD_BANDA"];
        $COD_CAM=$_GET["COD_CAM"];
        $HORA=$_GET["HORA"];
        $SW_BINS=$_GET["SW_BINS"];
       
        

        if($SW_BINS=='1'){


            $nlote=explode("-",$LOTE);
            $LOTE=$nlote[0];
            $UNIDAD=$nlote[1];
           
           
            $consulta="INSERT INTO ANDROID_ESTIBA_BINS (COD_EMP, COD_TEM, ZON, COD_FRI, COD_CAM, COD_BANDA, FILA, PISO, LOTE, UNIDAD,FECHA, HORA, TEMP, IDUSUARIO, SW_ENVIADO)  
            VALUES('{$COD_EMP}', '{$COD_TEM}', '{$ZON}', '{$COD_FRI}', '{$COD_CAM}', '{$COD_BANDA}', '{$FILA}', '{$PISO}', '{$LOTE}', '{$UNIDAD}','{$FECHA}', '{$HORA}', '{$TEMP}', '{$IDUSUARIO}',0)";   
            
           
            $resultado=sqlsrv_query($conexion,$consulta);
         
                 
            if($resultado){
                $resulta["id"]='REGISTRA';
                $json[]=$resulta;
                echo json_encode($json);
               $consultainsertado="IF EXISTS(SELECT LOTE,UNIDAD,COD_EMP,COD_TEM,ZON FROM EXISPACK_ESTIBA WHERE COD_EMP = '{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND ZON='{$ZON}' AND LOTE='{$LOTE}' AND UNIDAD='{$UNIDAD}')
               UPDATE EXISPACK_ESTIBA SET COD_FRI = '{$COD_FRI}' , COD_CAM='{$COD_CAM}' , COD_BANDA='{$COD_BANDA}' , FILA='{$FILA}', PISO='{$PISO}',FECHA='{$FECHA}', HORA='{$HORA}',IDUSUARIO='{$IDUSUARIO}'  WHERE COD_EMP = '{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND ZON='{$ZON}' AND LOTE='{$LOTE}' AND UNIDAD='{$UNIDAD}'
               ELSE
               INSERT INTO EXISPACK_ESTIBA (COD_EMP, COD_TEM, ZON, COD_FRI, COD_CAM, COD_BANDA, FILA, PISO, LOTE, UNIDAD,FECHA, HORA, TEMP, IDUSUARIO)  
               VALUES('{$COD_EMP}', '{$COD_TEM}', '{$ZON}', '{$COD_FRI}', '{$COD_CAM}', '{$COD_BANDA}', '{$FILA}', '{$PISO}', '{$LOTE}', '{$UNIDAD}','{$FECHA}', '{$HORA}', '{$TEMP}', '{$IDUSUARIO}')";
             
               $resultadoexistencia=sqlsrv_query($conexion,$consultainsertado);


            }else{
                    $resulta["id"]='NO REGISTRA';
                    $json[]=$resulta;
                    echo json_encode($json);
            } 
        }else{
            
            $insertado="SELECT LOTE FROM ANDROID_ESTIBA WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND ZON='{$ZON}' AND  COD_FRI='{$COD_FRI}' AND COD_CAM='{$COD_CAM}' AND COD_BANDA='{$COD_BANDA}' AND FILA='{$FILA}' AND  PISO='{$PISO}' AND LOTE='{$LOTE}' AND FECHA='{$FECHA}' AND HORA='{$HORA}' ";
            $resultadoantes=sqlsrv_query($conexion,$insertado);
            
            if($respuestantes=sqlsrv_fetch_array($resultadoantes)){
                $loterespuesta=$respuestantes['LOTE'];
                
                if ($loterespuesta==$LOTE){
                    $resulta["id"]='REGISTRA';
                    $json[]=$resulta;
                    echo json_encode($json);
                }
            }else{

                $consulta="INSERT INTO ANDROID_ESTIBA (COD_EMP, COD_TEM, ZON, COD_FRI, COD_CAM, COD_BANDA, FILA, PISO, LOTE, FECHA, HORA, TEMP, IDUSUARIO, SW_ENVIADO)  
                VALUES('{$COD_EMP}', '{$COD_TEM}', '{$ZON}', '{$COD_FRI}', '{$COD_CAM}', '{$COD_BANDA}', '{$FILA}', '{$PISO}', '{$LOTE}', '{$FECHA}', '{$HORA}', '{$TEMP}', '{$IDUSUARIO}',0)";
    
              
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

          
         
        }   
        
      
		
		

    }else{
        $resultar["id"]='FALTAN DATOS';
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
    if(isset($_GET["ZON"])   
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["COD_EMP"])
    &&isset($_GET["FECHA"])
    &&isset($_GET["LOTE"])
    &&isset($_GET["HORA"])
    &&isset($_GET["IDUSUARIO"])
    &&isset($_GET["PISO"])
    &&isset($_GET["COD_FRI"])
    &&isset($_GET["FILA"])
    &&isset($_GET["COD_BANDA"])
    &&isset($_GET["COD_CAM"])
    &&isset($_GET["TEMP"])){
        
       
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        $ZON=$_GET["ZON"];
        $FECHA=$_GET["FECHA"];
        $LOTE=$_GET["LOTE"];
        $CANTIDAD=$_GET["CANTIDAD"];
        $PISO=$_GET["PISO"];
        $IDUSUARIO=$_GET["IDUSUARIO"];
        $TEMP=$_GET["TEMP"];
        $COD_PRO=$_GET["COD_PRO"];
        $COD_FRI=$_GET["COD_FRI"];
        $FILA=$_GET["FILA"];
        $COD_BANDA=$_GET["COD_BANDA"];
        $COD_CAM=$_GET["COD_CAM"];
        $HORA=$_GET["HORA"];
        $SW_BINS=$_GET["SW_BINS"];
       
        

        if($SW_BINS=='1'){


            $nlote=explode("-",$LOTE);
            $LOTE=$nlote[0];
            $UNIDAD=$nlote[1];
           
           
            $consulta="INSERT INTO ANDROID_ESTIBA_BINS (COD_EMP, COD_TEM, ZON, COD_FRI, COD_CAM, COD_BANDA, FILA, PISO, LOTE, UNIDAD,FECHA, HORA, TEMP, IDUSUARIO, SW_ENVIADO)  
            VALUES('{$COD_EMP}', '{$COD_TEM}', '{$ZON}', '{$COD_FRI}', '{$COD_CAM}', '{$COD_BANDA}', '{$FILA}', '{$PISO}', '{$LOTE}', '{$UNIDAD}','{$FECHA}', '{$HORA}', '{$TEMP}', '{$IDUSUARIO}',0)";   
            
            /* $consulta2="UPDATE E SET E.COD_FRI=A.COD_FRI, E.COD_CAM=A.COD_CAM, E.COD_BANDA=A.COD_BANDA
            FROM EXISPACK E
            INNER JOIN ANDROID_ESTIBA_BINS A ON A.COD_EMP=E.COD_EMP AND A.COD_TEM=E.COD_TEM AND A.LOTE=E.LOTE
            WHERE A.COD_EMP='{$COD_EMP}' AND A.COD_TEM='{$COD_TEM}' AND A.IDUSUARIO='{$IDUSUARIO}' AND A.SW_ENVIADO=0";
             */
            $resultado=sqlsrv_query($conexion,$consulta);
            //$resultado2=sqlsrv_query($conexion,$consulta2);
                 
            if($resultado){
                $resulta["id"]='REGISTRA';
                $json[]=$resulta;
                echo json_encode($json);
               $consultainsertado="IF EXISTS(SELECT LOTE,UNIDAD,COD_EMP,COD_TEM,ZON FROM EXISPACK_ESTIBA WHERE COD_EMP = '{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND ZON='{$ZON}' AND LOTE='{$LOTE}' AND UNIDAD='{$UNIDAD}')
               UPDATE EXISPACK_ESTIBA SET COD_FRI = '{$COD_FRI}' , COD_CAM='{$COD_CAM}' , COD_BANDA='{$COD_BANDA}' , FILA='{$FILA}', PISO='{$PISO}',FECHA='{$FECHA}', HORA='{$HORA}',IDUSUARIO='{$IDUSUARIO}'  WHERE COD_EMP = '{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND ZON='{$ZON}' AND LOTE='{$LOTE}' AND UNIDAD='{$UNIDAD}'
               ELSE
               INSERT INTO EXISPACK_ESTIBA (COD_EMP, COD_TEM, ZON, COD_FRI, COD_CAM, COD_BANDA, FILA, PISO, LOTE, UNIDAD,FECHA, HORA, TEMP, IDUSUARIO)  
               VALUES('{$COD_EMP}', '{$COD_TEM}', '{$ZON}', '{$COD_FRI}', '{$COD_CAM}', '{$COD_BANDA}', '{$FILA}', '{$PISO}', '{$LOTE}', '{$UNIDAD}','{$FECHA}', '{$HORA}', '{$TEMP}', '{$IDUSUARIO}')";
             
               $resultadoexistencia=sqlsrv_query($conexion,$consultainsertado);


            }else{
                    $resulta["id"]='NO REGISTRA';
                    $json[]=$resulta;
                    echo json_encode($json);
            } 
        }else{
            $consulta="INSERT INTO ANDROID_ESTIBA (COD_EMP, COD_TEM, ZON, COD_FRI, COD_CAM, COD_BANDA, FILA, PISO, LOTE, FECHA, HORA, TEMP, IDUSUARIO, SW_ENVIADO)  
            VALUES('{$COD_EMP}', '{$COD_TEM}', '{$ZON}', '{$COD_FRI}', '{$COD_CAM}', '{$COD_BANDA}', '{$FILA}', '{$PISO}', '{$LOTE}', '{$FECHA}', '{$HORA}', '{$TEMP}', '{$IDUSUARIO}',0)";
    
            $consulta2="UPDATE E SET E.COD_FRI=A.COD_FRI, E.COD_CAM=A.COD_CAM, E.COD_BANDA=A.COD_BANDA, E.FILA=A.FILA, E.PISO=A.PISO, E.FECHA=A.FECHA, E.HORA=A.HORA 
            FROM EXISTENCIA E
            INNER JOIN ANDROID_ESTIBA A ON A.COD_EMP=E.COD_EMP AND A.COD_TEM=E.COD_TEM AND A.LOTE=E.LOTE
            WHERE A.COD_EMP='{$COD_EMP}' AND A.COD_TEM='{$COD_TEM}' AND A.IDUSUARIO='{$IDUSUARIO}' AND A.SW_ENVIADO=0";
    
            $consulta3="UPDATE E SET E.COD_FRI=A.COD_FRI, E.COD_CAM=A.COD_CAM, E.COD_BANDA=A.COD_BANDA, E.FILA=A.FILA, E.PISO=A.PISO, E.FECHA=A.FECHA, E.HORA=A.HORA 
            FROM MIXEXISTENCIA E
            INNER JOIN ANDROID_ESTIBA A ON A.COD_EMP=E.COD_EMP AND A.COD_TEM=E.COD_TEM AND A.LOTE=E.LOTE
            WHERE A.COD_EMP='{$COD_EMP}' AND A.COD_TEM='{$COD_TEM}' AND A.IDUSUARIO='{$IDUSUARIO}' AND A.SW_ENVIADO=0";
           
            $consulta4="UPDATE ANDROID_ESTIBA SET SW_ENVIADO=1
            WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND IDUSUARIO='{$IDUSUARIO}'";
            $resultado=sqlsrv_query($conexion,$consulta);
            $resultado2=sqlsrv_query($conexion,$consulta2);
            $resultado3=sqlsrv_query($conexion,$consulta3);
            $resultado4=sqlsrv_query($conexion,$consulta4);
    
                      
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
        $resultar["id"]='FALTAN DATOS';
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