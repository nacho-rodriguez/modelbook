<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('users_model', 'um');
        $this->obj = $this->CI->um;
    }

	public function test_getAdminEmail(){
		$expected = 'modelbook@modelbook.com';
		$list = $this->obj->getAdminEmail();

		$this->assertEquals($expected, $list);
	}
}
