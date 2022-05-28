<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_POST["USUARIO"])&&isset($_POST["CLAVE"])){

	$usuario=$_POST["USUARIO"];
    $clave=$_POST["CLAVE"];
    
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    

    $conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_POST["COD_EMP"])&&isset($_POST["COD_TEM"])&&isset($_POST["IDTRABAJADOR"])&&isset($_POST["IDMANGASTOS"])&&isset($_POST["FECHA"])
    &&isset($_POST["NREPORT"])&&isset($_POST["NRENDICION"])&&isset($_POST["TOTAL"])&&isset($_POST["OBSERVACION"])&&isset($_POST["CODIGOCLIENTE"])
    &&isset($_POST["COD_MAQ"])&&isset($_POST["SUBITEM"])&&isset($_POST["CANTIDAD"])&&isset($_POST["VALOR"])&&isset($_POST["ODOMETRO"])
    &&isset($_POST["HOROMETRO"])){
        
        $COD_EMP=$_POST["COD_EMP"];
        $COD_TEM=$_POST["COD_TEM"];
        $IDTRABAJADOR=$_POST["IDTRABAJADOR"];
        $IDMANGASTOS=$_POST["IDMANGASTOS"];
        $FECHA=$_POST["FECHA"];
        $NREPORT=$_POST["NREPORT"];
        $NRENDICION=$_POST["NRENDICION"];
        $TOTAL=$_POST["TOTAL"];
        $OBSERVACION=$_POST["OBSERVACION"];
        $CODIGOCLIENTE=$_POST["CODIGOCLIENTE"];
        $COD_MAQ=$_POST["COD_MAQ"];
        $SUBITEM=$_POST["SUBITEM"];
        $CANTIDAD=$_POST["CANTIDAD"];
        $VALOR=$_POST["VALOR"];
        $ODOMETRO=$_POST["ODOMETRO"];
        $HOROMETRO=$_POST["HOROMETRO"];
       


        
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




        

        if($COD_MAQ=='NULL'){
            $sql="INSERT INTO APP_TransRENDICIONESCHOFERES(COD_EMP,COD_TEM,IDTRABAJADOR,IDMANGASTO,FECHA,ENTREGADINERO,NREPORT,    
            NRENDICION,TOTAL,OBSERVACION,IDFOTO,APROBACION,IMPORTADO,USUARIO,FECHASISTEMA)
            VALUES ('{$COD_EMP}','{$COD_TEM}','{$IDTRABAJADOR}','{$IDMANGASTOS}','{$FECHA}','{$ENTREGADINERO}','{$NREPORT}','{$NRENDICION}','{$TOTAL}','{$OBSERVACION}','{$IDFOTO}',0,0,'{$usuario}','{$hoy}')";
    
        }else{
            $sql="INSERT INTO APP_TransRENDICIONESCHOFERES(COD_EMP,COD_TEM,IDTRABAJADOR,IDMANGASTO,FECHA,ENTREGADINERO,NREPORT,    
            NRENDICION,TOTAL,OBSERVACION,IDFOTO,APROBACION,IMPORTADO,CODIGOCLIENTE,COD_MAQ,SUBITEM,CANTIDAD,VALOR,ODOMETRO,HOROMETRO,USUARIO,FECHASISTEMA)
            VALUES ('{$COD_EMP}','{$COD_TEM}','{$IDTRABAJADOR}','{$IDMANGASTOS}','{$FECHA}','{$ENTREGADINERO}','{$NREPORT}','{$NRENDICION}','{$TOTAL}','{$OBSERVACION}','{$IDFOTO}',0,0,'{$CODIGOCLIENTE}','{$COD_MAQ}','{$SUBITEM}',{$CANTIDAD},{$VALOR},{$ODOMETRO},{$HOROMETRO},'{$usuario}','{$hoy}')";
    
        }
                
        
        
            

        $resultado=sqlsrv_query($conexion,$sql);
        
        if($resultado){
                echo 'registra';
        }else{
                echo 'no registra';
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