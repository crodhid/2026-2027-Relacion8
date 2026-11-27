<?php
error_reporting(0);
define("RUTABASE", dirname(__FILE__));
//define("MODO_TRABAJO","produccion"); //en "produccion o en desarrollo
define("MODO_TRABAJO", "desarrollo"); //en "produccion o en desarrollo

if (MODO_TRABAJO == "produccion")
    error_reporting(0);
else
    error_reporting(E_ALL);

spl_autoload_register(function ($clase) {
    $carpetas = [
        RUTABASE . "/scripts/clases/",
        RUTABASE . "/aplicacion/clases/",
    ];

    foreach ($carpetas as $carpeta) {
        $fichero = $carpeta . "$clase.php";
        if (file_exists($fichero)) {
            require_once($fichero);
            return;
        }
    }
});

//Para empezar con las sesiones (después de registrar la autocarga)
session_start();

include(RUTABASE . "/aplicacion/plantilla/plantilla.php");
include(RUTABASE . "/scripts/librerias/Validacion.php");

//creo mis constantes de colores
const COLORESFONDO = [
    "rojo" => "red",
    "verde" => "green",
    "azul" => "blue",
    "negro" => "black",
    "blanco" => "white"
];

const COLORESTEXTO = [
    "rojo" => "red",
    "verde" => "green",
    "azul" => "blue",
    "negro" => "black",
    "blanco" => "white"
];

/**
 * Función que me devuelve el color actual que esta utilizando mi aplicación
 *
 * @return array
 */
function colorActual(): array
{
    $fondo = $_COOKIE["colorFondo"] ?? "blanco";
    $texto = $_COOKIE["colorTexto"] ?? "negro";

    if (!is_string($fondo) || !array_key_exists($fondo, COLORESFONDO)) $fondo = "blanco";
    if (!is_string($texto) || !array_key_exists($texto, COLORESTEXTO)) $texto = "negro";

    return [$fondo, $texto];
}