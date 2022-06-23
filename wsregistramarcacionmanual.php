<?PHP

$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

$usuario=$_GET["usuario"];
$clave=$_GET["clave"];
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
    if($conexion){
        $data=array();
        if(isset($_GET["IdEmpresa"])&&isset($_GET["Fecha"])&&isset($_GET["IdTrabajador"])&&isset($_GET["Cod_trp"])&&isset($_GET["Cod_bus"])
        &&isset($_GET["Hora_entrada"])&&isset($_GET["Hora_salida"])&&isset($_GET["IdMotivo"])&&isset($_GET["Patente"])){
            
        
            $IdEmpresa=$_GET["IdEmpresa"];
            $Fecha=$_GET["Fecha"];
            $IdTrabajador=$_GET["IdTrabajador"];
            $Cod_trp=$_GET["Cod_trp"];
            $Cod_bus=$_GET["Cod_bus"];
            $Hora_entrada=$_GET["Hora_entrada"];
            $Hora_salida=$_GET["Hora_salida"];
            $IdMotivo=$_GET["IdMotivo"];
            $Patente=$_GET["Patente"];
            $Zona=$_GET["ZONA"];
            
            date_default_timezone_set('America/Lima');
            $Fechareg=date('d/m/Y H:i:s',time());
            if(!($Hora_entrada=='CON MARCACION' && $Hora_salida=='CON MARCACION')){
               
                $sql="INSERT INTO LecturasSmart(IDEMPRESA,FECHA,IDTRABAJADOR,HORAINICIO,EstacionInicio,HORAFINAL,EstacionFinal,
                HraIniEstimado,HraFinEstimado,PATENTE,COD_TRP,COD_BUS,SW_GENERADO,IdMotivo,IdZona,UsuarioReg,FechaReg)
                VALUES ('{$IdEmpresa}','{$Fecha}','{$IdTrabajador}','{$Hora_entrada}','MARCACION MANUAL APP','{$Hora_salida}','MARCACION MANUAL APP',
                '{$Hora_entrada}','{$Hora_salida}','{$Patente}','{$Cod_trp}','{$Cod_bus}','1','{$IdMotivo}','{$Zona}','{$usuario}','{$Fechareg}')";

                $horario="EXEC SPC_LECTURAS_SMART_CALCULAR @IDEMPRESA='{$IdEmpresa}' ,@Fecha='{$Fecha}' ,@IdTrabajador='{$IdTrabajador}'";
                


            }

            if($Hora_entrada!='CON MARCACION' && $Hora_salida=='CON MARCACION'){
                    //actualizamos marcacion entrada
                $sql="UPDATE LecturasSmart SET PATENTE='{$Patente}' ,COD_TRP='{$Cod_trp}',COD_BUS='{$Cod_bus}' , HORAINICIO='{$Hora_entrada}',EstacionInicio='MARCACION MANUAL APP',HraIniEstimado='{$Hora_entrada}',IdMotivo='{$IdMotivo}',IdZona='{$Zona}',UsuarioReg='{$usuario}',FechaReg='{$Fechareg}',SW_GENERADO='1' 
                WHERE IdEmpresa='{$IdEmpresa}' and Fecha='{$Fecha}' and IdTrabajador='{$IdTrabajador}' ";
                $tipo="ACTUALIZACION";
              
            }
            if($Hora_entrada=='CON MARCACION' && $Hora_salida!='CON MARCACION'){
                        //actualizamos marcacion salida
                $sql="UPDATE LecturasSmart SET PATENTE='{$Patente}' ,COD_TRP='{$Cod_trp}',COD_BUS='{$Cod_bus}' , HORAFINAL='{$Hora_salida}',EstacionFinal='MARCACION MANUAL APP',HraIniEstimado='{$Hora_salida}',IdMotivo='{$IdMotivo}',IdZona='{$Zona}',UsuarioReg='{$usuario}',FechaReg='{$Fechareg}',SW_GENERADO='1' 
                WHERE IdEmpresa='{$IdEmpresa}' and Fecha='{$Fecha}' and IdTrabajador='{$IdTrabajador}' ";
                $tipo="ACTUALIZACION";

            }   
            
           
            $resultado=sqlsrv_query($conexion,$sql);
            $resultado2=sqlsrv_query($conexion,$horario);


            
           

            if($resultado){
                $data=array(
                    'REGISTRADO'=>'REGISTRADO'
                );
            }else{
                if($tipo=='ACTUALIZACION'){
                    $data=array(
                        'REGISTRADO'=>'REGISTRADO'
                    );  
                }else{

                    $data=array(
                        'REGISTRADO'=>'NO REGISTRADO'
                    );
                }
            }
            $json[]=$data;

            echo json_encode($json);


            

           // $resultado=sqlsrv_query($conexion,$horario);
            

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
