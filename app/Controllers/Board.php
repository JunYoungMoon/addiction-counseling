<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\BoardModel;
use App\Models\BoardTempModel;
use Mobile_Detect;

class Board extends BaseController
{
	public function index()
	{
		
	}

	public function throttle(){
		return redirect()->to('/');
	}

	//댓글 작성 
	public function replyWriteContent(){
		$session = \Config\Services::session();	
		$db      = \Config\Database::connect();

		$request = service('request');

		$post = $request->getPost();

		$builder = $db->table('reply');

		$id = $this->encrypt_decrypt('decrypt', $post['id']);

    	$data = [
			'id'		=> ($session->get('id')) ? $session->get('id') : $id ,
			'boardId'	=> $post['boardId'],
     		'content'	=> $post['content'],
    	    'created'	=> date("Y-m-d H:i:s"),
		];
            	
		$builder->insert($data);

		$builder->select('replyId, id, content, created');
		$builder->where('boardId',$post['boardId']);

		$query = $builder->get()->getResultArray();

		echo json_encode($query);
	}

	//댓글 수정
	public function replyModifyContent(){
		$db      = \Config\Database::connect();
		$session = \Config\Services::session();	

		$request = service('request');	

		$post = $request->getPost();		

		$builder = $db->table('reply');

		$id = $this->encrypt_decrypt('decrypt', $post['id']);
		
		if($id || $session->get('id') == 'admin1'){

	    	$data = [
	     		'content'	=> $post['content'],
	    	    'modifyed'	=> date("Y-m-d H:i:s"),
			];

			$builder->set($data);
			$builder->where('replyId', $post['replyId']);
			$builder->update(); 

			$builder->select('replyId, content, modifyed');
			$builder->where('replyId', $post['replyId']);

			$query = $builder->get()->getResultArray();

			echo json_encode($query);	
		}	
	}

	//댓글 삭제
	public function replyDeleteContent(){
		$db      = \Config\Database::connect();
		$session = \Config\Services::session();	

		$request = service('request');	

		$post = $request->getPost();		

		$builder = $db->table('reply');

		$id = $this->encrypt_decrypt('decrypt', $post['id']);
		
		if($id || $session->get('id') == 'admin1'){
			$builder->where('replyId', $post['replyId']);
			$builder->delete(); 

			$builder->select('replyId, id, content, created');
			$builder->where('boardId',$post['boardId']);

			$query = $builder->get()->getResultArray();

			echo json_encode($query);	
		}		
	}

	public function boardDelete($boardId = ''){
    	$db      = \Config\Database::connect();
    	$session = \Config\Services::session();	

    	$db->transStart();

		if($session->get('id') == 'admin1'){
			$builder = $db->table('notice');
		}else{			
			$builder = $db->table('board');
		}			
		
		$builder->where('boardId', $boardId);
		$builder->delete();    	

		if($session->get('id') != 'admin1'){
	       	$builder = $db->table('boardcount');
	       	$builder->set('boardCount', 'boardCount - 1', false);
	       	$builder->update();
		}

       	$db->transComplete();

       	if ($db->transStatus() === FALSE)
		{
			echo view('errors/error');	
		}else{
			return "<script>
						alert('게시글을 삭제 하였습니다.');
						window.location.href = '/';
					</script>";
		}
	}

	public function boardView($boardId = ''){
		
		helper('cookie');

		$db      = \Config\Database::connect();
		$session = \Config\Services::session();	

		if($boardId == 62){
			$builder = $db->table('notice');
		}else{			
			$builder = $db->table('board');
		}				

		$builder->select('boardId,id,title,content,created,secret');
		$builder->where('boardId',$boardId);

		$row = $builder->get()->getRowArray();
		
		//만약 게시글의 시크릿이 O이고 세션 아이디가 게시글의 아이디와 일치하지 않으면 게시글을 보여주면 안됨.
		if(($row['secret'] == "O" && $session->get('id') == $row['id']) || ($row['secret'] == "X") || ($session->get('id') == 'admin1')){

			$builder = $db->table('reply');
			$builder->select('replyId,id,content,created');
			$builder->where('boardId',$boardId);

			$reply = $builder->get()->getResultArray();

			if(!empty($boardId) && empty(get_cookie('board_free_' . $boardId))) {
				
				if($boardId == 62){
					$builder = $db->table('notice');
				}else{			
					$builder = $db->table('board');
				}
		
				$builder->set('hit', 'hit+1', false);
				$builder->where('boardId', $boardId);
				$builder->update(); 

				set_cookie('board_free_' . $boardId , 'The Value', '86400','.dou.local.co.kr','/');
			}

			$this->data  = array(
				'row' => $row,
				'ciphertext' => htmlspecialchars($this->encrypt_decrypt('encrypt', $row['id'])),
				'reply'	=> $reply
			);

			$this->header = array(
						'title'	=>	'게시글보기',
						'css'	=>	array('boardView'),
						'javascript'	=>	array('boardView','common')
			);	

		    echo view('templates/header', $this->header);
		    echo view('board/boardView', $this->data);
		    echo view('templates/footer');	
		}else{
			echo view('errors/error');	
		}
	}

	public function boardListView($page = ''){	

		$offset = ((int)$page - 1) * 10;

		$db      = \Config\Database::connect();

		//게시글 리스트		
		$query = $db->query('SELECT *, "-" as no FROM notice UNION ALL 
							(SELECT *
	    					FROM  (SELECT 	                					
	                					B.*,@ROWNUM := @ROWNUM - 1 AS no
	            					FROM  board B,
	                  					(SELECT @ROWNUM := (SELECT boardCount FROM boardcount) + 1) TMP
	        						ORDER BY created DESC) SUB 
							ORDER BY SUB.no DESC
							LIMIT '. $offset.',10)');

		$this->list = array('list'=> $query->getResultArray());

		//게시글 총갯수
		$query = $db->query('SELECT boardCount FROM boardcount');

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

		$startPage = floor(($page - 1) / 10) * 10 + 1; 

		$endPage = $startPage + $countPage - 1;
		
		//마지막 페이지가 총페이지보다 커질때 마지막 페이지로
		if ($endPage > $totalPage) {
		    $endPage = $totalPage;
		}

		$this->list = array_merge($this->list, array('startPage' => $startPage, 'endPage' =>$endPage));

		$detect = new Mobile_Detect;

		if ( $detect->isMobile() ) {
			$this->data = array(
				'title'	=>'게시글리스트',
				'css'=>array('mboardList'),
				'javascript' =>array('boardList','common')
			);
		}else{
			$this->data = array(
				'title'	=>'게시글리스트',
				'css'=>array('boardList'),
				'javascript' =>array('boardList','common')
			);
		}

	    echo view('templates/header', $this->data);
	    echo view('board/boardList', $this->list);
	    echo view('templates/footer');
	}

	//게시글 등록
	public function boardWrite(){		
		$request = service('request');	

		$post = $request->getPost();

		$session = \Config\Services::session();	

		$responseKeys = $this->recaptcha($post['g-recaptcha']);				

		helper('cookie');
		set_cookie('id', $this->encrypt_decrypt('encrypt', $post['id']), (string)time() + 86400 * 30, '.dou.local.co.kr','/');

		if ($responseKeys["success"]) {
			$id = $this->encrypt_decrypt('decrypt', $post['id']);

			//id가 세션 아이디와 일치하거나 작성중 세션파괴로 세션 아이디가 없을때 
		    if(($id == $session->get('id')) || !$session->get('id')){

		    	//글수정시 
		    	if($post['divide']){
		    		$db      = \Config\Database::connect();		    		

					if($session->get('id') == 'admin1'){
						$builder = $db->table('notice');
					}else{			
						$builder = $db->table('board');
					}			    		

		    		$array = [					        
					        'title'  => $post['title'],
					        'content'   => $post['content'],
					        'modifyed'	=> date("Y-m-d H:i:s"),
					        'secret'	=> (isset($post['secret'])) ? 'O' : 'X',
					];
		    		
		    		$builder->set($array);
		    		$builder->where('id', $id);
		    		$builder->where('boardId', $post['boardId']);
		    		$builder->update();
		    		
					return "<script>
								alert('게시글을 수정 하였습니다.');
								window.location.href = '/boardView/".$post['boardId']."';
							</script>";

		    	//글작성시
		    	}else{
			    	$db      = \Config\Database::connect();

			    	$db->transStart();		

			    	if($session->get('id') == 'admin1'){
						$builder = $db->table('notice');
					}else{			
						$builder = $db->table('board');
					}				

	            	$data = [
						'id'		=> $id,
	              		'title'		=> $post['title'],
	             		'content'	=> $post['content'],
	            	    'created'	=> date("Y-m-d H:i:s"),
	            	    'secret'	=> (isset($post['secret'])) ? 'O' : 'X',
	            	];
	            	
	               	$builder->insert($data);

	               	if($session->get('id') != 'admin1'){
						$builder = $db->table('board');
		               	$builder = $db->table('boardcount');
		               	$builder->set('boardCount', 'boardCount + 1', false);
		               	$builder->update();
					}

	               	$db->transComplete();

	               	if ($db->transStatus() === FALSE)
					{
						echo view('errors/error');	
					}else{
						return "<script>
									alert('게시글을 등록 하였습니다.');
									window.location.href = '/';
								</script>";
					}
		    	}
		    }else{
		    	echo view('errors/error');	
		    }
		}else{
			echo view('errors/error');	
		}
	}	

	public function boardWriteView($boardId = ''){

		$session = \Config\Services::session();	

		//1.id 값으로 세션 체크 
		if($session->get('id')){

			//글쓰기
			if($boardId == ''){
				
				$userModel = new UserModel();

				$result = $userModel->find($session->get('id'));

				//2.계정 이메일 본인인증 확인
				if($result['IdentityVerification'] == 'O'){

					//id값 암호화
					$ciphertext = $this->encrypt_decrypt('encrypt', $session->get('id'));

					$ciphertext = htmlspecialchars($ciphertext);

					//저장된 임시등록 글 갯수
					$db      = \Config\Database::connect();
					$builder = $db->table('boardtemp');

					$builder->where('id',$session->get('id'));
					$BoardWriteTempSaveCount = $builder->countAllResults();


					//3. 완료 되었을때 세션이 있을때 뷰단에 id 뷰 단에 던져 주기
					$this->data = array(
										'title'	=>	'게시글작성',
										'css'	=>	array('boardWrite'),
										'javascript'	=>	array('boardWrite','common'),
										'ciphertext'	=> $ciphertext,
										'BoardWriteTempSaveCount' => $BoardWriteTempSaveCount
					);			

				    echo view('templates/header', $this->data);
				    echo view('board/boardWrite', $this->data);
				    echo view('templates/footer');	

				}else if($result['IdentityVerification'] == 'X'){

					
					//메일전송 중복 클릭 체크
					if($session->get('sendMail')){
						return "<script>
									alert('" . $session->get('email') . " 으로 본인인증 메일이 전송 되었습니다.');
									window.location.href = '/';
								</script>";
					}else{
						//메일을 한번 보냈으면 상태값을 변경하여 메일 전송 중복 클릭 체크를 함.
						$sendMailCheck = [
						        'sendMail'	=> 'O'
						];

						$session->set($sendMailCheck);	

						$result = $this->IdentityVerificationSendMail($session->get('id'), $session->get('email'));

						if($result == "success"){
							return "<script>
										alert('본인인증이 되지 않았습니다. " . $session->get('email') . "으로 본인인증 메일이 전송 되었습니다.');
										window.location.href = '/';
									</script>";
						}else if($result == "fail"){
							echo view('errors/error');
						}					
					}					
				}
			//글수정
			}else{				
				$db      = \Config\Database::connect();
				$session = \Config\Services::session();	

				if($session->get('id') == 'admin1'){
					$builder = $db->table('notice');
				}else{			
					$builder = $db->table('board');
				}		

				//제목, 내용 가져오기		
				$builder->select('boardId,title,content,secret');
				$builder->where('boardId',$boardId);

				$row = $builder->get()->getRowArray();

				//id값 암호화 하기
				$ciphertext = $this->encrypt_decrypt('encrypt', $session->get('id'));
				$ciphertext = htmlspecialchars($ciphertext);

				//임시저장 게시물수 가져오기
				$builder = $db->table('boardtemp');
				$builder->where('id',$session->get('id'));
				$BoardWriteTempSaveCount = $builder->countAllResults();

				$this->data = array(
					'title'	=>	'게시글수정',
					'css'	=>	array('boardWrite'),
					'javascript'	=>	array('boardWrite','common'),
					'ciphertext'	=> $ciphertext,
					'BoardWriteTempSaveCount' => $BoardWriteTempSaveCount,
					'row' => $row,
					'modify' => 'modify'
				);			

			    echo view('templates/header', $this->data);
			    echo view('board/boardWrite', $this->data);
			    echo view('templates/footer');	
			}
					
		}else{
			//세션이 없으면 알림창 띄워주고 리스트로 다시돌아가기 			
			return "<script>
						alert('게시글 작성은 로그인이 필요합니다.');
						window.location.href = '/login';
					</script>";
		}	
	}
}