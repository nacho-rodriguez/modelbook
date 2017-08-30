<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookings_client_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('bookings_clients_model', 'bcm');
        $this->obj = $this->CI->bcm;
    }

	public function test_getNumberOfClients(){
		$expected = 3;
		$list = $this->obj->getNumberOfClients(1);

        $this->assertEquals($expected, $list);

	}
}
