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
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["IDTRABAJADOR"])&&isset($_GET["IDMANGASTOS"])&&isset($_GET["FECHA"])
    &&isset($_GET["NREPORT"])&&isset($_GET["NRENDICION"])&&isset($_GET["TOTAL"])&&isset($_GET["OBSERVACION"])&&isset($_GET["CODIGOCLIENTE"])
    &&isset($_GET["COD_MAQ"])&&isset($_GET["SUBITEM"])&&isset($_GET["CANTIDAD"])&&isset($_GET["VALOR"])&&isset($_GET["ODOMETRO"])
    &&isset($_GET["HOROMETRO"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $IDTRABAJADOR=$_GET["IDTRABAJADOR"];
        $IDMANGASTOS=$_GET["IDMANGASTOS"];
        $FECHA=$_GET["FECHA"];
        $NREPORT=$_GET["NREPORT"];
        $NRENDICION=$_GET["NRENDICION"];
        $TOTAL=$_GET["TOTAL"];
        $OBSERVACION=$_GET["OBSERVACION"];
        $CODIGOCLIENTE=$_GET["CODIGOCLIENTE"];
        $COD_MAQ=$_GET["COD_MAQ"];
        $SUBITEM=$_GET["SUBITEM"];
        $CANTIDAD=$_GET["CANTIDAD"];
        $VALOR=$_GET["VALOR"];
        $ODOMETRO=$_GET["ODOMETRO"];
        $HOROMETRO=$_GET["HOROMETRO"];
       


        
        $ENTREGADINERO="0";

        if($IDMANGASTOS=='5'){
            $ENTREGADINERO="1";
        }    

         if($CODIGOCLIENTE==''){
            $CODIGOCLIENTE='NULL';
        }
 
        if($COD_MAQ==''){
            $COD_MAQ='NULL';
        }

        if($SUBITEM==''){
            $SUBITEM='NULL';
        }

        if($CANTIDAD==0){
            $CANTIDAD='NULL';
        }

        if($VALOR==0){
            $VALOR='NULL';
        }

        if($HOROMETRO==0){
            $HOROMETRO='NULL';
        }

        if($ODOMETRO==0){
            $ODOMETRO='NULL';
        }
 
        $nuevafecha=str_replace('/','',$FECHA);


        $IDFOTO=$COD_EMP.$COD_TEM.$IDTRABAJADOR.$IDMANGASTOS.$nuevafecha.$ENTREGADINERO.$NREPORT;    
        $hoy = date("d-m-Y H:i:s",time());    




        $SQL1="SELECT ISNULL(MAX(CONVERT(INT,NRENDICION)),0) +1 AS NRENDICION FROM APP_TransRENDICIONESCHOFERES WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' ";
       
        $resultadosql=sqlsrv_query($conexion,$SQL1);
        if($registross=sqlsrv_fetch_array($resultadosql)){
            if($registross['NRENDICION']==$NRENDICION){
                if($COD_MAQ=='NULL'){
                    $sql="INSERT INTO APP_TransRENDICIONESCHOFERES(COD_EMP,COD_TEM,IDTRABAJADOR,IDMANGASTO,FECHA,ENTREGADINERO,NREPORT,    
                    NRENDICION,TOTAL,OBSERVACION,IDFOTO,APROBACION,IMPORTADO,USUARIO,FECHASISTEMA)
                    VALUES ('{$COD_EMP}','{$COD_TEM}','{$IDTRABAJADOR}','{$IDMANGASTOS}','{$FECHA}','{$ENTREGADINERO}','{$NREPORT}','{$NRENDICION}','{$TOTAL}','{$OBSERVACION}','{$IDFOTO}',0,0,'{$usuario}','{$hoy}')";
                  
                }else{
                    $sql="INSERT INTO APP_TransRENDICIONESCHOFERES(COD_EMP,COD_TEM,IDTRABAJADOR,IDMANGASTO,FECHA,ENTREGADINERO,NREPORT,    
                    NRENDICION,TOTAL,OBSERVACION,IDFOTO,APROBACION,IMPORTADO,CODIGOCLIENTE,COD_MAQ,SUBITEM,CANTIDAD,VALOR,ODOMETRO,HOROMETRO,USUARIO,FECHASISTEMA)
                    VALUES ('{$COD_EMP}','{$COD_TEM}','{$IDTRABAJADOR}','{$IDMANGASTOS}','{$FECHA}','{$ENTREGADINERO}','{$NREPORT}','{$NRENDICION}','{$TOTAL}','{$OBSERVACION}','{$IDFOTO}',0,0,'{$CODIGOCLIENTE}','{$COD_MAQ}','{$SUBITEM}',{$CANTIDAD},{$VALOR},{$ODOMETRO},{$HOROMETRO},'{$usuario}','{$hoy}')";
                }
                      
            }else{
                $SQL2="SELECT MAX(CONVERT(INT,NRENDICION)) AS NRENDICION FROM APP_TransRENDICIONESCHOFERES WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND IDTRABAJADOR='{$IDTRABAJADOR}' ";
                $resultadosql2=sqlsrv_query($conexion,$SQL2);
                if($registross2=sqlsrv_fetch_array($resultadosql2)){
                    if($registross2['NRENDICION']==$NRENDICION){
                        if($COD_MAQ=='NULL'){
                            $sql="INSERT INTO APP_TransRENDICIONESCHOFERES(COD_EMP,COD_TEM,IDTRABAJADOR,IDMANGASTO,FECHA,ENTREGADINERO,NREPORT,    
                            NRENDICION,TOTAL,OBSERVACION,IDFOTO,APROBACION,IMPORTADO,USUARIO,FECHASISTEMA)
                            VALUES ('{$COD_EMP}','{$COD_TEM}','{$IDTRABAJADOR}','{$IDMANGASTOS}','{$FECHA}','{$ENTREGADINERO}','{$NREPORT}','{$NRENDICION}','{$TOTAL}','{$OBSERVACION}','{$IDFOTO}',0,0,'{$usuario}','{$hoy}')";
                          
                        }else{
                            $sql="INSERT INTO APP_TransRENDICIONESCHOFERES(COD_EMP,COD_TEM,IDTRABAJADOR,IDMANGASTO,FECHA,ENTREGADINERO,NREPORT,    
                            NRENDICION,TOTAL,OBSERVACION,IDFOTO,APROBACION,IMPORTADO,CODIGOCLIENTE,COD_MAQ,SUBITEM,CANTIDAD,VALOR,ODOMETRO,HOROMETRO,USUARIO,FECHASISTEMA)
                            VALUES ('{$COD_EMP}','{$COD_TEM}','{$IDTRABAJADOR}','{$IDMANGASTOS}','{$FECHA}','{$ENTREGADINERO}','{$NREPORT}','{$NRENDICION}','{$TOTAL}','{$OBSERVACION}','{$IDFOTO}',0,0,'{$CODIGOCLIENTE}','{$COD_MAQ}','{$SUBITEM}',{$CANTIDAD},{$VALOR},{$ODOMETRO},{$HOROMETRO},'{$usuario}','{$hoy}')";
                        } 
                    }else{
                        $maximo="SELECT ISNULL(MAX(CONVERT(INT,NRENDICION)),0) +1 AS NRENDICION FROM APP_TransRENDICIONESCHOFERES WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' ";
                        $resultadomaximo=sqlsrv_query($conexion,$maximo);
                        $registrosmaximo=sqlsrv_fetch_array($resultadomaximo);
                        $NRENDICION=$registrosmaximo['NRENDICION'];
                    
                        if($COD_MAQ=='NULL'){
                            $sql="INSERT INTO APP_TransRENDICIONESCHOFERES(COD_EMP,COD_TEM,IDTRABAJADOR,IDMANGASTO,FECHA,ENTREGADINERO,NREPORT,    
                            NRENDICION,TOTAL,OBSERVACION,IDFOTO,APROBACION,IMPORTADO,USUARIO,FECHASISTEMA)
                            VALUES ('{$COD_EMP}','{$COD_TEM}','{$IDTRABAJADOR}','{$IDMANGASTOS}','{$FECHA}','{$ENTREGADINERO}','{$NREPORT}','{$NRENDICION}','{$TOTAL}','{$OBSERVACION}','{$IDFOTO}',0,0,'{$usuario}','{$hoy}')";
                          
                        }else{
                            $sql="INSERT INTO APP_TransRENDICIONESCHOFERES(COD_EMP,COD_TEM,IDTRABAJADOR,IDMANGASTO,FECHA,ENTREGADINERO,NREPORT,    
                            NRENDICION,TOTAL,OBSERVACION,IDFOTO,APROBACION,IMPORTADO,CODIGOCLIENTE,COD_MAQ,SUBITEM,CANTIDAD,VALOR,ODOMETRO,HOROMETRO,USUARIO,FECHASISTEMA)
                            VALUES ('{$COD_EMP}','{$COD_TEM}','{$IDTRABAJADOR}','{$IDMANGASTOS}','{$FECHA}','{$ENTREGADINERO}','{$NREPORT}','{$NRENDICION}','{$TOTAL}','{$OBSERVACION}','{$IDFOTO}',0,0,'{$CODIGOCLIENTE}','{$COD_MAQ}','{$SUBITEM}',{$CANTIDAD},{$VALOR},{$ODOMETRO},{$HOROMETRO},'{$usuario}','{$hoy}')";
                        } 

                        
                    }
                }

            }
        }


    
 
            

        $resultado=sqlsrv_query($conexion,$sql);
        
        if($resultado){
            $resultar["message"]='OK';
            $resultar["nrendicion"]=$NRENDICION;
            $json[]=$resultar; ;
           
        }else{
            $resultar["message"]='ERROR';
            $resultar["nrendicion"]='error';
            $json[]=$resultar; ;
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