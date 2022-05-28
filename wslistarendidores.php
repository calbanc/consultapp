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
            if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["MES"])&&isset($_GET["ANIO"]) ){
                
                $COD_EMP=$_GET["COD_EMP"];
                $COD_TEM=$_GET["COD_TEM"];
                $MES=$_GET["MES"];
                $ANIO=$_GET["ANIO"];

                $consulta="SELECT distinct [Id Rendidor]=R.IDTRABAJADOR, [Rendidor]=T.NOMBRE+' '+T.APELLIDOPATERNO+' '+T.APELLIDOMATERNO
                FROM APP_TRANSRENDICIONESCHOFERES R      
                INNER JOIN TransManGASTOS_OT G ON G.COD_EMP=R.COD_EMP AND G.COD_TEM=R.COD_TEM AND G.IDMANGASTO=R.IDMANGASTO   
                LEFT JOIN CUENTA_CONT B  ON G.COD_EMP = B.COD_EMP AND G.COD_FAM = B.COD_FAM AND G.COD_SUBFAM = B.COD_SUBFAM AND G.COD_CUENTA = B.COD_CUENTA    
                INNER JOIN EMPRESAS E ON E.COD_EMP=R.COD_EMP              
                INNER JOIN Bsis_Rem_Afr.dbo.Trabajador T ON T.IDEMPRESA=E.ID_EMPRESA_REM AND T.IDTRABAJADOR=R.IDTRABAJADOR      
                INNER JOIN Bsis_Rem_Afr.dbo.Contratos C WITH(NOLOCK) ON T.IdTrabajador = C.IdTrabajador AND T.IdEmpresa = C.IdEmpresa  and r.fecha BETWEEN c.fechainicio and isnull(c.fechatermino,isnull(c.fechaterminoc,getDATE())) 
                left JOIN BSIS_REM_AFR.DBO.TRABAJADOR JD WITH(NOLOCK) ON c.IDEMPRESA_JEFEDIRECTO=JD.IDEMPRESA AND c.IDJEFEDIRECTO=JD.IDTRABAJADOR
                LEFT JOIN Bsis_Rem_Afr.dbo.Zona ON c.IdEmpresa = Zona.IdEmpresa AND c.IdZona = Zona.IdZona          
                LEFT JOIN Bsis_Rem_Afr.dbo.Cuartel ON c.IdEmpresa = Cuartel.IdEmpresa AND c.IdZona = Cuartel.IdZona AND c.IdCuartel = Cuartel.IdCuartel          
                LEFT JOIN CENTROCOSTO_CONT CC ON CC.COD_EMP=R.COD_EMP AND CC.COD_CENTROCOSTO=zona.COD_CENTROCOSTO    
                LEFT JOIN SUB_CENTROCOSTO SB ON SB.COD_EMP=CC.COD_EMP AND SB.COD_CENTROCOSTO=CC.COD_CENTROCOSTO AND SB.COD_SUBCENTRO=cuartel.COD_SUBCENTRO    
                LEFT JOIN DOLAR D ON D.COD_PAIS=E.COD_PAIS AND D.FECHA=R.FECHA  
                WHERE R.COD_EMP='{$COD_EMP}' AND R.COD_TEM='{$COD_TEM}'  and JD.UsuarioSis='{$usuario}' and R.APROBACION='0' and YEAR(R.FECHA)='{$ANIO}' and MONTH(R.FECHA)='{$MES}' ";


                $resultado=sqlsrv_query($conexion,$consulta);
                
                while($registro =sqlsrv_fetch_array($resultado)){
                    $json['rendiciones'][]=$registro;
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