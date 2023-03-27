<?php 
    
    require_once 'class/finder.class.php';

    $fileName = Finder::base64url_decode($_GET['fileName']);

    exec('"C:\Program Files\Sublime Text\sublime_text.exe" '.$fileName.':'.$_GET['lineNumber']); 
?>

<script type="text/javascript">
    window.close();
</script>