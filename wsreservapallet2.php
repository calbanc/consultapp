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
    if(isset($_GET["COD_EMP"])
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["GLOSA"])
   
    &&isset($_GET["LOTE"])
    &&isset($_GET["FECHA"])
    &&isset($_GET["HORA"])
    &&isset($_GET["TEMP"])
    &&isset($_GET["IDUSUARIO"])
    &&isset($_GET["SW_ENVIADO"])
  ){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
      
        $LOTE=$_GET["LOTE"];
        $GLOSA=$_GET["GLOSA"];
        $ZON=$_GET["ZON"];
        $FECHA=$_GET["FECHA"];
        $HORA=$_GET["HORA"];
        $COD_CAM=$_GET["COD_CAM"];
        $COD_BANDA=$_GET["COD_BANDA"];
        $COD_FRI=$_GET["COD_FRI"];
        $TEMP=$_GET["TEMP"];
        $IDUSUARIO=$_GET["IDUSUARIO"];
        $SW_ENVIADO=$_GET["SW_ENVIADO"];
     

      
		
		$consulta="INSERT INTO ANDROID_RESERVA(COD_EMP, COD_TEM, GLOSA, LOTE, FECHA, HORA, TEMP, IDUSUARIO, SW_ENVIADO)          
        VALUES('{$COD_EMP}', '{$COD_TEM}', '{$GLOSA}','{$LOTE}', '{$FECHA}', '{$HORA}', '{$TEMP}', '{$IDUSUARIO}','{$SW_ENVIADO}')";
        $resultado=sqlsrv_query($conexion,$consulta);
        if(!empty($COD_CAM)){
            $consulta2="INSERT INTO ANDROID_ESTIBA (COD_EMP, COD_TEM, ZON, COD_FRI, COD_CAM, COD_BANDA,LOTE, FECHA, HORA, TEMP, IDUSUARIO, SW_ENVIADO)  
            VALUES('{$COD_EMP}', '{$COD_TEM}', '{$ZON}', '{$COD_FRI}', '{$COD_CAM}', '{$COD_BANDA}', '{$LOTE}', '{$FECHA}', '{$HORA}', '{$TEMP}', '{$IDUSUARIO}',0) ";
            $resultado2=sqlsrv_query($conexion,$consulta2);
            
            $consulta3="UPDATE E SET E.COD_FRI=A.COD_FRI, E.COD_CAM=A.COD_CAM, E.COD_BANDA=A.COD_BANDA, E.FILA=A.FILA, E.PISO=A.PISO, E.FECHA=A.FECHA, E.HORA=A.HORA 
            FROM EXISTENCIA E
            INNER JOIN ANDROID_ESTIBA A ON A.COD_EMP=E.COD_EMP AND A.COD_TEM=E.COD_TEM AND A.LOTE=E.LOTE
            WHERE A.COD_EMP='{$COD_EMP}' AND A.COD_TEM='{$COD_TEM}' AND A.IDUSUARIO='{$IDUSUARIO}' AND A.SW_ENVIADO=0";
            $resultado3=sqlsrv_query($conexion,$consulta3);
            
            $consulta4="UPDATE E SET E.COD_FRI=A.COD_FRI, E.COD_CAM=A.COD_CAM, E.COD_BANDA=A.COD_BANDA, E.FILA=A.FILA, E.PISO=A.PISO, E.FECHA=A.FECHA, E.HORA=A.HORA 
            FROM MIXEXISTENCIA E
            INNER JOIN ANDROID_ESTIBA A ON A.COD_EMP=E.COD_EMP AND A.COD_TEM=E.COD_TEM AND A.LOTE=E.LOTE
            WHERE A.COD_EMP='{$COD_EMP}' AND A.COD_TEM='{$COD_TEM}' AND A.IDUSUARIO='{$IDUSUARIO}' AND A.SW_ENVIADO=0";
            $resultado4=sqlsrv_query($conexion,$consulta4);
          
            $consulta5="UPDATE ANDROID_ESTIBA SET SW_ENVIADO=1
            WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND IDUSUARIO='{$IDUSUARIO}'";
            $resultado5=sqlsrv_query($conexion,$consulta5);
        }   
        
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