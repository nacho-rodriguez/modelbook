<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('model_model', 'mm');
        $this->obj = $this->CI->mm;
    }

	public function test_getAvailableModels(){
		$expected = [
			1 => 'DOÑANA',
            2 => 'PALMAR'
        ];
		$list = $this->obj->getAvailableModels();

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_modelo], $element->modelo);
        }
	}

	public function test_getgetDisableModels(){
		$expected;
		$list = $this->obj->getDisableModels();

		foreach($list as $element)
		{
			$this->assertEquals($expected[$element->id_modelo], $element->modelo);
		}
	}
}
