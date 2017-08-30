<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Models_prices_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('models_prices_model', 'mprem');
        $this->obj = $this->CI->mprem;
    }

	public function test_getPreciosComisionesModelo(){
		$expected = [
			1 => '10.00',
            2 => '15.00',
			3 => '20.00',
			4 => '25.00'
        ];
		$list = $this->obj->getPreciosComisionesModelo(1,1);

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_modelo_precio], $element->valor_monetario);
        }
	}
}
