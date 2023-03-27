<?php


	$formulario = file_get_contents('views/formulario.html');


	/* abro el home para luego incorporar archivos encontrados */
    $home = file_get_contents('views/home.html');
    $home = str_replace('{{ formulario }}', $formulario, $home);
    $home = str_replace('{{ show_data_found }}', '', $home);

    echo $home;

?>