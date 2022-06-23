<?php

//Variables de configuracion

$host = '192.168.2.214';
$usuario = 'android';
$password = 'abc.123';
$workgroup = 'VERFRUT.CL';
$share_folder = 'share/TemporalSDT/Reportes/Fotos';

$uri = 'smb://'.$host.'/'.$share_folder;
$state = smbclient_state_new();

if (isset($_POST['nombrepdf']) && isset($_POST['pdf']))
{
    $pdf=$_POST["pdf"];
    $nombrepdf=$_POST["nombrepdf"];

    echo $nombrepdf;
        //Sanitizacion de parametros
    
        //Recrear la imagen por motivos de seguridad
        $ruta_archivo = '/tmp/'.$_POST['nombrepdf'].'.pdf';
        file_put_contents($ruta_archivo,base64_decode($pdf));

        //Se conecta al servidor SMB
        if (smbclient_state_init($state, $workgroup, $usuario, $password))
        {
                $nombre_archivo = $uri.'/'.$_POST['nombrepdf'].'.pdf';
                $archivo = smbclient_creat($state, $nombre_archivo);
                $retorno = smbclient_write($state, $archivo, file_get_contents($ruta_archivo));
                echo("registra");
        }
        else
        {
                echo("[-] Ha ocurrido un error al conectarse al servidor SMB.");
        }
}else{
        echo 'fallao en envio de datos';

}
?>
