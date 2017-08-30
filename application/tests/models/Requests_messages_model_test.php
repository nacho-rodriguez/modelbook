<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request_messages_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('requests_messages_model', 'reqmm');
        $this->obj = $this->CI->reqmm;
    }

	public function test_getMessagesFromRequest(){
		$expected = [
			1 => 'Hola vendedor, ¿necesita algún servicio en la plataforma?',
            3 => 'Hola, pues me vendría bien un servicio de desplazamiento al aeropuerto de Jerez.',
			4 => 'De acuerdo, lo añadiré en breve. Gracias.'
        ];
		$list = $this->obj->getMessagesFromRequest(1);

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_peticion_mensaje], $element->mensaje);
        }
	}
}
