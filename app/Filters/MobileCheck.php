<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Mobile_Detect;

class MobileCheck implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
    {	
		$detect = new Mobile_Detect;
		
		if ( $detect->isMobile() ) {
 			static $aaa = 0;
		}
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}
