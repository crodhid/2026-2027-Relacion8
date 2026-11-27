<?php
class RegistroTexto
{
    private string $_cadena;
    private DateTime $_fechaYHora;

    public function __construct(string $cadena)
    {
        $this->_cadena = $cadena;
        $this->_fechaYHora = new DateTime();
    }

    public function getFechaYHora(): string
    {
        return $this->_fechaYHora->format("d/m/Y H:i");
    }

    public function getCadena():string{
        return $this->_cadena;
    }
}