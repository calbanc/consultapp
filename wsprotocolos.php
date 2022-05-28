<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	 
	$info=array("Database"=>"bpriv","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    $inforemuneracion=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    $infoerpfrusys=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    $inforegistro=array("Database"=>"registro","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
   
    $conexion = sqlsrv_connect($hostname_localhost,$info);
    $conexion2= sqlsrv_connect($hostname_localhost,$inforemuneracion);
    $conexion3= sqlsrv_connect($hostname_localhost,$infoerpfrusys);
    $conexion4= sqlsrv_connect($hostname_localhost,$inforegistro);

        if($conexion){
            $json=array();
            if(isset($_GET["IDUSUARIO"])&&isset($_GET["ACTIVO"])&&isset($_GET["REESTABLECER"])&&isset($_GET["CLAVE"])){
                
            
                $IDUSUARIO=$_GET["IDUSUARIO"];
                $ACTIVO=$_GET["ACTIVO"];
                $REESTABLECER=$_GET["REESTABLECER"];
                $CLAVE=$_GET["CLAVE"];
                $fecha_activacion=date('d/m/Y H:i:s',time());
            
                if($CLAVE=='TODOS'){
                    $consulta="UPDATE  PROTOCOLOS_USUARIOS SET FECHA_ACTIVACION='{$fecha_activacion}', ACTIVO='{$ACTIVO}' , RESTABLECER='{$REESTABLECER}'  where IDUSUARIO='{$IDUSUARIO}'  ";
                    $consulta2="INSERT INTO MOVIMIENTOS_PROTOCOLOS(IDUSUARIO, IDADMINISTRADOR, FECHA_HORA,TIPO_MOV, SISTEMA)VALUES('{$IDUSUARIO}','{$IDUSUARIO}','{$fecha_activacion}','Activa Usuario','AppPriv')";
                    $resultado2=sqlsrv_query($conexion,$consulta2);            
                }else{
                    $consulta="UPDATE  PROTOCOLOS_USUARIOS SET CLAVE='{$CLAVE}',FECHA_ACTIVACION='{$fecha_activacion}', ACTIVO='{$ACTIVO}' , RESTABLECER='{$REESTABLECER}'  where IDUSUARIO='{$IDUSUARIO}'  ";
                    $consulta2="sp_password @loginame = '{$IDUSUARIO}', @new='{$CLAVE}'";
                    $consulta3="INSERT INTO MOVIMIENTOS_PROTOCOLOS(IDUSUARIO, IDADMINISTRADOR, FECHA_HORA,TIPO_MOV, SISTEMA)VALUES('{$IDUSUARIO}','{$IDUSUARIO}','{$fecha_activacion}','Cambio Clave','AppPriv')";
                    $consulta4="UPDATE PERFIL SET CLAVE='{$CLAVE}' , PRECIO_ESTIMADO='0' WHERE IDUSUARIO='{$IDUSUARIO}'  ";
                    $consulta5="INSERT INTO PASSWORD(IDUSUARIO, FECHA_HORA,CLAVE, SISTEMA) VALUES('{$IDUSUARIO}','{$fecha_activacion    }','{$CLAVE}','APPPRIV')";
                    $consulta6="UPDATE ERPFRUSYS.DBO.OPERADORES SET PWD='{$CLAVE}' WHERE CODIGO='{IDUSUARIO}'";
                    $consulta7="EXEC sp_change_users_login 'Update_One','{$IDUSUARIO}','{$IDUSUARIO}'";
                    
                    $resultado2=sqlsrv_query($conexion,$consulta2);
                    $resultado3=sqlsrv_query($conexion,$consulta3);
                    $resultado4=sqlsrv_query($conexion,$consulta4);
                    $resultado5=sqlsrv_query($conexion,$consulta5);
                    $resultado6=sqlsrv_query($conexion,$consulta6);
                    $resultado7=sqlsrv_query($conexion,$consulta7);
                    

                    if($conexion2){
                        $consulta8="sp_password @loginame = '{$IDUSUARIO}', @new='{$CLAVE}'";
                        $consulta9="EXEC sp_change_users_login 'Update_One','{$IDUSUARIO}','{$IDUSUARIO}'";
                        $resultado8=sqlsrv_query($conexion,$consulta8);
                        $resultado9=sqlsrv_query($conexion,$consulta9);
                
                    }else{
                        echo "REMUNERACION";
                    }
                    if($conexion3){
                        $consulta8="sp_password @loginame = '{$IDUSUARIO}', @new='{$CLAVE}'";
                        $consulta9="EXEC sp_change_users_login 'Update_One','{$IDUSUARIO}','{$IDUSUARIO}'";
                        $resultado8=sqlsrv_query($conexion,$consulta8);
                        $resultado9=sqlsrv_query($conexion,$consulta9);
                
                    }else{
                        echo "ERPFRUSYS";
                    }

                    if($conexion4){
                        $consulta8="sp_password @loginame = '{$IDUSUARIO}', @new='{$CLAVE}'";
                        $consulta9="EXEC sp_change_users_login 'Update_One','{$IDUSUARIO}','{$IDUSUARIO}'";
                        $resultado8=sqlsrv_query($conexion,$consulta8);
                        $resultado9=sqlsrv_query($conexion,$consulta9);
                
                    }else{
                        echo "ERPFRUSYS";
                    }

                }

               

                
           
                $resultado=sqlsrv_query($conexion,$consulta);
                
                if($resultado){
                    $data=array(
                        'id'=>'REGISTRA'
                    ); 
                    $json[]=$data;
                    echo json_encode($json);
            
                               
                }else{
                           $data=array(
                               'id'=>'NO REGISTRA'
                           );
                           $json[]=$data;
                           echo json_encode($json);
                       }
                       
               
        
           }else{
               $resultar["id"]='Ws no Retorna';
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