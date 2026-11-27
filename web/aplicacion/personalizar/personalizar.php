<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

mb_internal_encoding("UTF-8");

// ---- Controlador ----

$ubicacion = [
    "pagina principal" => "../../../index.php",
    "personalizar" => "./personalizar.php"
];

// Procesar el formulario (antes de cualquier salida HTML, por las cookies)
if (isset($_POST["colorFondo"], $_POST["colorTexto"])) {
    $fondo = is_string($_POST["colorFondo"]) ? $_POST["colorFondo"] : "";
    $texto = is_string($_POST["colorTexto"]) ? $_POST["colorTexto"] : "";

    if (array_key_exists($fondo, COLORESFONDO) && array_key_exists($texto, COLORESTEXTO)) {
        $caduca = time() + 60 * 60 * 24 * 30; // 30 días
        setcookie("colorFondo", $fondo, $caduca, "/");
        setcookie("colorTexto", $texto, $caduca, "/");

        // Para que se vea ya en esta misma petición
        $_COOKIE["colorFondo"] = $fondo;
        $_COOKIE["colorTexto"] = $texto;
    }
}

// Colores actuales (cookies o valores por defecto)
[$fondoSel, $textoSel] = colorActual();
$fondoCss = COLORESFONDO[$fondoSel];
$textoCss = COLORESTEXTO[$textoSel];

// ---- Dibujar la plantilla ----
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera($fondoCss, $textoCss);
finCabecera();
inicioCuerpo("PERSONALIZAR", $ubicacion);
cuerpo(COLORESFONDO, COLORESTEXTO, $fondoSel, $textoSel);
finCuerpo();

// ---- Vistas ----

function cabecera(string $fondoCss, string $textoCss)
{
    echo "<style>body #documento { background-color: $fondoCss; color: $textoCss; }</style>";
}

function cuerpo(array $coloresFondo, array $coloresTexto, string $fondoSel, string $textoSel)
{
    echo formulario($coloresFondo, $coloresTexto, $fondoSel, $textoSel);
}

function formulario(array $coloresFondo, array $coloresTexto, string $fondoSel, string $textoSel): string
{
    ob_start();
    ?>
    <form method="post" action="">
        <label>Color Fondo:
            <select name="colorFondo">
                <?php foreach ($coloresFondo as $nombre => $css) { ?>
                    <option value="<?php echo $nombre; ?>"
                        <?php if ($nombre === $fondoSel) { echo "selected"; } ?>>
                        <?php echo $nombre; ?>
                    </option>
                <?php } ?>
            </select>
        </label>
        <br><br>
        <label>Color Texto:
            <select name="colorTexto">
                <?php foreach ($coloresTexto as $nombre => $css) { ?>
                    <option value="<?php echo $nombre; ?>"
                        <?php if ($nombre === $textoSel) { echo "selected"; } ?>>
                        <?php echo $nombre; ?>
                    </option>
                <?php } ?>
            </select>
        </label>
        <br><br>
        <input type="submit" value="Guardar">
    </form>
    <?php
    return ob_get_clean();
}