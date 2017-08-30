<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Models_paradas_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('models_paradas_model', 'mparm');
        $this->obj = $this->CI->mparm;
    }

	public function test_getAllParadasFromModel(){
		$expected = [
			1 => 'Primera parada en Chiclana',
            2 => 'Segunda parada en San Fernando'
        ];
		$list = $this->obj->getAllParadasFromModel(1);

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_modelo_parada], $element->parada);
        }
	}
}
