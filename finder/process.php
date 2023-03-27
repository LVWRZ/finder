<?php

    require_once 'class/finder.class.php';

    /* validación de los POST recibidos */
    if (
            isset($_POST['submit_ejecutar']) &&
            isset($_POST['folder']) &&
            isset($_POST['findme']) &&
            isset($_POST['extension']) &&
            $_POST['submit_ejecutar'] == 'Ejecutar' && 
            $_POST['folder'] != '' && 
            $_POST['findme'] != '' && 
            count($_POST['extension']) > 0
        ) {
        
        $folder = Finder::sanitizer($_POST['folder']);
        $findme = Finder::sanitizer($_POST['findme']);
        $extension = $_POST['extension'];
    }


	// inclusión
	require_once __DIR__ . '/class/finder.class.php';

     
    // instancia
    $finder = new Finder();
     
    // indicar el directorio inicial para la búsqueda
    $finder->setFolder( $folder );
     
    // indicar con un ARRAY, las extensión donde quiero que realice las búsquedas
    $finder->setExtension( $extension );
     
    // indicar el texto a buscar
    $finder->setFindme( $findme );

    // executar
    $archivosEncontrador = $finder->getResultado();


    /* fill con datos el registros_encontrados */
    $rowFound = '';
    $openFile = '';

    if (count($archivosEncontrador) > 0) {
        
        foreach ($archivosEncontrador as $key => $value) {

            $fileName = $value['fileName'];
            $fileName = str_replace('vendors\finder\class/../..\\', '', $fileName);
            
            $openFile = 'app.php?fileName='.Finder::base64url_encode($fileName).'&lineNumber='.$value['lineNumber'];

            $rowFound .= file_get_contents('views/registros_encontrados.html');
            $rowFound = str_replace('{{ line_number }}', $value['lineNumber'], $rowFound);
            $rowFound = str_replace('{{ file_name }}', $fileName, $rowFound);
            $rowFound = str_replace('{{ line_data }}', $value['lineData'], $rowFound);
            $rowFound = str_replace('{{ url }}', $openFile, $rowFound);
        }

    }else{
        
            $rowFound .= file_get_contents('views/registros_encontrados.html');
            $rowFound = str_replace('{{ file_name }}', 'NO se han encontrado archivos que coincidan el criterio de búsqueda', $rowFound);
            $rowFound = str_replace('{{ line_number }}', '', $rowFound);
            $rowFound = str_replace('{{ line_data }}', '', $rowFound);


    }
        



    /* abro la vista show_data_found e inserto los datos encontrados de rowfound */
    $showDataFound = file_get_contents('views/show_data_found.html');
    $showDataFound = str_replace('{{ registros_encontrados }}', $rowFound, $showDataFound);
    $showDataFound = str_replace('{{ findme }}', $findme, $showDataFound);
    $showDataFound = str_replace('{{ extension }}', implode(', ', $extension), $showDataFound);
    $showDataFound = str_replace('{{ folder }}', $folder, $showDataFound);
    $showDataFound = str_replace('{{ url_back }}', 'index.php', $showDataFound);
    $showDataFound = str_replace('{{ text_back }}', 'Ir a Inicio', $showDataFound);


    


    /* abro el home para luego incorporar archivos encontrados */
    $home = file_get_contents('views/home.html');
    $home = str_replace('{{ formulario }}', '', $home);
    $home = str_replace('{{ show_data_found }}', $showDataFound, $home);

    echo $home;
    

?>
 