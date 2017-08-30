<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commissions_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('commissions_model', 'comm');
        $this->obj = $this->CI->comm;
    }

	public function test_getAllCommissions(){
		$expected = [
            1 => '%',
            2 => 'Fijo'
        ];
		$list = $this->obj->getAllCommissions();

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_tipo_comision], $element->nombre);
        }
	}
}
