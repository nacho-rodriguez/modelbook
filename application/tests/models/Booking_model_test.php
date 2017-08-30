<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('booking_model', 'boom');
        $this->obj = $this->CI->boom;
    }

	public function test_getBookingsFromClient(){
		$expected = [
			1 => 1,
            2 => 2
        ];
		$list = $this->obj->getBookingsFromClient(1);

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_reserva], $element->id_servicio);
        }
	}

	public function test_getAllBookingFromSeller(){
		$expected = [
			1 => 3,
            2 => 4
        ];
		$list = $this->obj->getAllBookingFromSeller(1);

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_reserva], $element->totalPersonas);
        }
	}

	public function test_getBookingsConfirmedByService(){
		$expected = [
			1 => 'REF_1'
		];
		$list = $this->obj->getBookingsConfirmedByService(1);

		foreach($list as $element)
		{
			$this->assertEquals($expected[$element->id_reserva], $element->referencia);
		}
	}
}
