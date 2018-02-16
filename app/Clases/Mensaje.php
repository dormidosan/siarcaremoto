<?php
/**
 * Created by PhpStorm.
 * User: Jonatan Lopez
 * Date: 12/10/2017
 * Time: 10:41
 */

namespace App\Clases;


class Mensaje
{
    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $titulo = "Mensaje";

    /**
     * @var string
     */
    private $contenido;

    /**
     * Mensaje constructor.
     * @param string $titulo
     * @param string $contenido
     * @param string $tipo
     */
    public function __construct($titulo, $contenido, $tipo)
    {
        $this->contenido = $contenido;
        $this->titulo = $titulo;
        $this->tipo = $tipo;
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     * @return Mensaje
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     * @return Mensaje
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * @param string $contenido
     * @return Mensaje
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }


    public function toArray()
    {
        //forma de crear un array asociativo
        $array = array(
            'titulo' => $this->titulo,
            'contenido' => $this->contenido,
            'tipo' => $this->tipo
        );

        return $array;
    }

}