<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        
    }

    public function loginView()
	{
		$this->data = array(
							'title'	=>'로그인',
							'css'=>array('user'),
							'javascript' =>array('login','common')
		);

	    echo view('templates/header',$this->data);
	    echo view('user/login');
	    echo view('templates/footer');
	}

	public function signUpView()
	{
		$this->data = array(
							'title'	=>'회원가입',
							'css'=>array('user'),
							'javascript' =>array('signUp','common')
		);


	    echo view('templates/header',$this->data);
	    echo view('user/signUp');
	    echo view('templates/footer');
	}

	public function findView()
	{
		$this->data = array(
							'title'	=>'아이디/비밀번호 찾기',
							'css'=>array('user'),
							'javascript' =>array('find','common')
		);


	    echo view('templates/header',$this->data);
	    echo view('user/find');
	    echo view('templates/footer');
	}

	public function myBoardListView($page = '')
	{

		$session = \Config\Services::session();	

		if($session->get('id')){

			$offset = ((int)$page - 1) * 10;

			$db      = \Config\Database::connect();

			//게시글 리스트
			$query = $db->query('SET @rownum := (SELECT count(*) FROM board WHERE id = "'.$session->get('id').'") + 1');
			$query = $db->query('SELECT @rownum:=@rownum-1 as no, fb.boardId, fb.title, fb.created FROM (SELECT boardId, title, created FROM board WHERE id = "'.$session->get('id').'" ORDER BY created DESC) fb ORDER BY fb.created DESC LIMIT '. $offset.',10');

			$this->list = array('list'=> $query->getResultArray());

			//게시글 총갯수
			$query = $db->query('SELECT count(*) as boardCount FROM board WHERE id = "'.$session->get('id').'"');

			//페이지 버튼 
			$totalCount = $query->getRow()->boardCount; //게시글 총 개수 ex)17

			$countList = 10; //한 페이지에 출력될 게시물 수 

			$totalPage = ($totalCount - ($totalCount % $countList)) / $countList; 

			//자투리 게시글 페이지 버튼 추가 처리
			if ($totalCount % $countList > 0) {
			    $totalPage++;
			}

			//현재 페이지 번호가 총 페이지보다 클때 현재 페이지를 강제로 총 페이지 번호로 치환
			if ($totalPage < $page) {
			    $page = $totalPage;
			}

			$countPage = 10; //보여질 페이지 버튼 갯수 

			if($page != 0){
				$startPage = floor(($page - 1) / 10) * 10 + 1; 

				$endPage = $startPage + $countPage - 1;	
			}else{
				$startPage = 0;
				$endPage = 0;
			}			
			
			//마지막 페이지가 총페이지보다 커질때 마지막 페이지로
			if ($endPage > $totalPage) {
			    $endPage = $totalPage;
			}

			$this->list = array_merge($this->list, array('startPage' => $startPage, 'endPage' =>$endPage));

			$this->data = array(
								'title'	=>'게시글리스트',
								'css'=>array('myBoardList'),
								'javascript' =>array('boardList','common')
			);

		    echo view('templates/header', $this->data);
		    echo view('user/myBoardList',$this->list);
		    echo view('templates/footer');

		}else{
			return "<script>
					if(confirm('로그인이 필요합니다 로그인 하시겠습니까?')){
						window.location.href = '/login';
					}else{
						window.location.href = '/';
					}						
					</script>";	
		}
	}

	public function myInfoView()
	{
		$session = \Config\Services::session();	

		if($session->get('id')){

			$this->data = array(
					'title'	=>'내정보',
					'css'=>array('user'),
					'javascript' =>array('myInfo','common'),
					'ciphertext'=>htmlspecialchars($this->encrypt_decrypt('encrypt', $session->get('id')))
			);

		    echo view('templates/header',$this->data);
		    echo view('user/myInfo');
		    echo view('templates/footer');
		}else{
			return "<script>
					if(confirm('로그인이 필요합니다 로그인 하시겠습니까?')){
						window.location.href = '/login';
					}else{
						window.location.href = '/';
					}						
					</script>";	
		}
	}

	public function logout(){

		$session = \Config\Services::session();

		$session->destroy();

		helper('cookie');

		delete_cookie('id');

		return "<script>
				window.location.href = '/login';					
				</script>";	
	}

	public function changeInformation(){
		$session = \Config\Services::session();
		$request = service('request');	

		$post = $request->getPost();		

		$id = $this->encrypt_decrypt('decrypt',$post['id']);

		$responseKeys = $this->recaptcha($post['g-recaptcha']);

		if ($responseKeys["success"]) {

			if(($id == $session->get('id')) || !$session->get('id')){

				$db      = \Config\Database::connect();
				$builder = $db->table('user');

				$builder->select('password,email');
				$builder->where('id',$id);

				$row = $builder->get()->getRowArray();

				if (password_verify($post['password'], $row['password'])) {
		    		
		    		$builder->set('password',password_hash($post['password1'], PASSWORD_DEFAULT));
		    		$builder->where('id', $id);
		    		$builder->update();

		    		if($row['email'] != $post['email']){

			    		$builder->set('IdentityVerification','X');
			    		$builder->set('email',$post['email']);
			    		$builder->where('id', $id);
			    		$builder->update();

			    		$session->set('email',$post['email']);	
			    		//4. 본인 인증 메일 전송 
						$email = \Config\Services::email();

						$email->setFrom('rlavlvl7681@naver.com', '문준영');
						$email->setTo($post['email']);

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
												<input type="hidden" name="id" value="'.htmlspecialchars($post['id']).'">
												<button id="btn">본인인증</button>
											    </form>
											</body>
											</html>');
						if($email->send()){					
							return "<script>
											alert('비밀번호변경 및 메일변경을 완료 하였습니다. 본인인증을 위하여 새로운 메일을 발송하였습니다.');
											window.location.href = '/login';
									</script>";
						}else{
							echo view('errors/error');
						}
		    		}

					return "<script>
								alert('비밀번호 변경을 완료 하였습니다.');
								window.location.href = '/login';
							</script>";

				}else{
					return "<script>
								alert('현재 비밀번호가 틀렸습니다.');
								window.location.href = '/myInfo';
							</script>";
				}
			
			}else{
				echo view('errors/error');
			}
		}else{
			echo view('errors/error');	
		}

	}

	//아이디/임시 비밀번호 메일 전송
	public function idpwSendMail(){
		$request = service('request');	

		$post = $request->getPost();

		$responseKeys = $this->recaptcha($post['g-recaptcha']);

		if ($responseKeys["success"]) {		
			if($post['email']=="" || $post['g-recaptcha']==""){
				echo view('errors/error');		
			}else{							
				$db = db_connect();

				$tempPassword = $this->generateRandomString();

				$db->query("update user set password = '".password_hash($tempPassword, PASSWORD_DEFAULT)."' where email = '".$post['email']."' ");	

				$query = $db->query("select id from user where email ='".$post['email']."'");

				$row = $query->getRow();

				$email = \Config\Services::email();         	

				$email->setFrom('rlavlvl7681@naver.com', '문준영');
				$email->setTo($post['email']);

				$email->setSubject('중독 상담 사이트 아이디/임시비밀번호');
				$email->setMessage('<html>
									<head>
									    <title>아이디/임시비밀번호</title>
									</head>
									<body>
										<div> ID : '.$row->id.'</div>
										<br>
										<div> PASSWORD : '.$tempPassword.'</div>
									</body>
									</html>');			

				if($email->send()){					
					return "<script>
									alert('".$post['email']." \\n아이디/임시비밀번호 전송을 완료 하였습니다.');
									window.location.href = '/login';
							</script>";
				}else{
					echo view('errors/error');
				}
			}
		}else{
			echo view('errors/error');	
		}
	}

	//본인인증
	public function identityVerification(){

		$request = service('request');			

		$ciphertext = $this->encrypt_decrypt('decrypt',$request->getPost('id'));

		$userModel = new UserModel();

		//암호화된 id 값을 임의로 변경시 $ciphertext 값은 ""으로 처리된다.
		if($ciphertext != ""){

			$data = [
		    	'IdentityVerification' => 'O',
			];

			$userModel->update($ciphertext, $data);

			echo view('success/success');

		}else{
			echo view('errors/error');
		}
	}

	public function loginCheck(){				
		//post 값을 받기 위한 세팅				
		$request = service('request');
		
		$post = $request->getPost();

		//로그인 상태유지 체크 
		if($request->getPost('loginCheck')){

			helper('cookie');
			set_cookie('id', $this->encrypt_decrypt('encrypt', $post['id']), (string)time() + 86400 * 30, '.dou.local.co.kr','/');
		}
		
		// 1. 컴퓨터인지 확인을 위해 리캡차 처리
		/*$responseKeys = $this->recaptcha($post['g-recaptcha']);*/

/*		if ($responseKeys["success"]) {
			print_r('1');exit;*/
			if($post['id']=="" || $post['password']==""/* || $post['g-recaptcha']==""*/){
				echo view('errors/error');		
			}else{
				//id,pw 확인처리
				$userModel = new UserModel();

				$user = $userModel->find($post['id']);

				if($user){
					if (password_verify($post['password'], $user['password'])) {
						//로그인성공
						//세션저장
						$session = \Config\Services::session();

						$userdata = [
						        'id'		=> $user['id'],
	             				'email'		=> $user['email']
						];

						$session->set($userdata);
						
						return "<script>
									window.location.href = '/';
								</script>";
					} else {
						return "<script>
									alert('비밀번호가 일치하지 않습니다.');
									window.location.href = '/login';
								</script>";
					}
				}else{
					return "<script>
								alert('존재하지 않는 아이디 입니다.');
								window.location.href = '/login';
							</script>";
				}			
			}
/*		}else{
			print_r('2');exit;
			echo view('errors/error');	
		}*/
	}

	public function overLapCheck(){

		$request = service('request');

		$get = $request->getGet();

		$db = db_connect();

		$userModel = new UserModel();

		if($get['gubun'] == "id"){			

			if($userModel->find($get['id']) != ""){
				return '중복';
			}else{
				return '중복되지않음';
			}
		}else if($get['gubun'] == "email"){

			$query = $db->query("select * from user where email ='".$get['email']."'");

			if($query->getRowArray() != ""){
				return '중복';
			}else{
				return '중복되지않음';
			}
		}else{
			echo view('errors/error');
		}		
	}

	public function save(){		

		$request = service('request');
		
		$post = $request->getPost();

		// 1. 컴퓨터인지 확인을 위해 리캡차 처리
		$responseKeys = $this->recaptcha($post['g-recaptcha']);

		if ($responseKeys["success"]) {
			//리캡차 성공 

  			//2. post 값으로 아무것도 넘어 오지 않았을때 처리 (크롬 개발자에서 자바스크립트 껐을때)
			if($post['id']=="" || $post['password1']=="" || $post['password2']=="" || $post['g-recaptcha']==""){
				echo view('errors/error');		
			}else{
				$userModel = new UserModel();

            	$data = [
					'id'		=> $post['id'],
              		'password'	=> password_hash($post['password1'], PASSWORD_DEFAULT),
             		'email'		=> $post['email'],
            	    'ip'		=> $_SERVER['REMOTE_ADDR'],
            	    'created'=> date("Y-m-d H:i:s"),
            	    'IdentityVerification' => 'X',
            	];				

            	//회원가입
               	$userModel->insert($data);

            	//4. 본인 인증 메일 전송 
				$email = \Config\Services::email();

               	//메일 전송시 id 값 암호화 
               	$ciphertext = $this->encrypt_decrypt('encrypt', $post['id']);

				$email->setFrom('rlavlvl7681@naver.com', '문준영');
				$email->setTo($post['email']);

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
					return "<script>
									alert('회원가입이 완료 되었습니다.');
									window.location.href = '/login';
							</script>";
				}else{
					echo view('errors/error');
				}
			}
		} else {
			//리캡차 실패
		  	echo view('errors/error');
		}		
	}
}