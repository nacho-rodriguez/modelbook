<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sellers_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('sellers_model', 'selm');
        $this->obj = $this->CI->selm;
    }

	public function test_getAllSellers(){
		$expected = [
            1 => 'Vendedor1 Chiclana',
            2 => 'Vendedor2 San Fernando'
        ];
		$list = $this->obj->getAllSellers();

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_vendedor], $element->nombre);
        }
	}

	public function test_sellerExists(){
		$expected = 1;
		$list = $this->obj->sellerExists('vendedoruno@modelbook.com');

		$this->assertEquals($expected, $list);
	}
}
