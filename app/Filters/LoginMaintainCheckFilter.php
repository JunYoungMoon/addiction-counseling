<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoginMaintainCheckFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
		$session = \Config\Services::session();	

		helper('cookie');

		//세션은 없고 로그인유지시 생성한 쿠키는 있을시.
		if(!$session->get('id') && get_cookie('id')){

		    $encrypt_method = "AES-256-CBC";
		    $secret_key = 'CauseOfAddictionKey'; 
		    $secret_iv = 'CauseOfAddictionIv'; 

		    $key = hash('sha256', $secret_key);
		    $iv = substr(hash('sha256', $secret_iv), 0, 16);
		    
	        $id = openssl_decrypt(base64_decode(get_cookie('id')), $encrypt_method, $key, 0, $iv);

    		$db      = \Config\Database::connect();

			$builder = $db->table('user');

   			$builder->select('id, email');
   			$builder->where('id',$id);

   			$query = $builder->get()->getRowArray();

			$userdata = [
			        'id'		=> $query['id'],
     				'email'		=> $query['email']
			];

			$session->set($userdata);
	    }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}