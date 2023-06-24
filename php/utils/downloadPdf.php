<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Verificar que el archivo exista
    if (file_exists($file)) {
        // Establecer las cabeceras para descargar el archivo
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        header('Pragma: public');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        readfile($file);

        // Eliminar el archivo después de la descarga
        unlink($file);

        exit;
    } else {
        echo 'El archivo no existe.';
    }
} else {
    echo 'No se proporcionó un archivo para descargar.';
}
?>
