<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
	}

	//임의문자 생성 모듈
	public	function generateRandomString($length = 8) { 
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
		$charactersLength = strlen($characters); 
		$randomString = ''; 

		for ($i = 0; $i < $length; $i++){ 
			$randomString .= $characters[mt_rand(0, $charactersLength - 1)]; 
		} 
		return $randomString; 
	}	

	//리캡차v3 모듈 
 	public function recaptcha($gRecaptcha){

 		// 1. 컴퓨터인지 확인을 위해 리캡차 처리
		$captcha = $gRecaptcha;
		$secretKey = '6LfBiWwaAAAAAEsme_2wf1lIsAG7r-L2Gx34w4VA'; 
		$ip = $_SERVER['REMOTE_ADDR'];

		$data = array(
			'secret' => $secretKey,
			'response' => $captcha,		
			'remoteip' => $ip  
		);

		$url = "https://www.google.com/recaptcha/api/siteverify";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$response = curl_exec($ch);
		curl_close($ch);

		return json_decode($response, true);
 	}

 	//메일 전송시 암호화,복호화 모듈
	public function encrypt_decrypt($action, $string)
 	{
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $secret_key = 'CauseOfAddictionKey'; 
	    $secret_iv = 'CauseOfAddictionIv'; 

	    $key = hash('sha256', $secret_key);
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);

	    if($action == 'encrypt') {
	        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
	    }else if($action == 'decrypt'){
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }

	    return $output;
 	}

 	//메일 전송시 id 값 암호화 
 	public function IdentityVerificationSendMail($id, $userEmail){

 		$email = \Config\Services::email();

 		$ciphertext = $this->encrypt_decrypt('encrypt', $id);               	

		$email->setFrom('rlavlvl7681@naver.com', '문준영');
		$email->setTo($userEmail);

		$email->setSubject('중독 상담 사이트 본인인증 메일');
		$email->setMessage('<html>
							<head>
							    <title>Identity Verification</title>
							    <style>
							        #btn button:hover{
							            border-top-radius: 5px;
							            border-bottom-radius: 5px;
							            margin-right:-4px;
							            border: 1px solid skyblue;
							            background-color: rgba(0,0,0,0);
							            color: skyblue;
							            padding: 5px;
							            color:white;
							            background-color: skyblue;
							        }
							    </style>
							</head>
							<body>
								<form action="http://dou.local.co.kr/identityVerification" method="post">
								<input type="hidden" name="id" value="'.htmlspecialchars($ciphertext).'">
								<button id="btn">본인인증</button>
							    </form>
							</body>
							</html>');
		if($email->send()){			
			return "success";
		}else{
			return "fail";			
		}												
 	}               	
}
