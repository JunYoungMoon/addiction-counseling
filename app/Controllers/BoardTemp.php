<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\BoardTempModel;

class BoardTemp extends BaseController
{
	public function index()
	{
		
	}

	//임시저장 리스트중 전체 내용 삭제
	public function getTempAllDelete(){
		$request = service('request');	

		$session = \Config\Services::session();	

		$db      = \Config\Database::connect();
		$builder = $db->table('boardtemp');

		$id = $this->encrypt_decrypt('decrypt', $request->getPost('id'));

		//id가 세션 아이디와 일치하거나 작성중 세션파괴로 세션 아이디가 없을때 
	    if(($id == $session->get('id')) || !$session->get('id')){
	    	
	    	$builder->where('id', $id);
	    	$builder->delete();

	    	$builder->where('id', $id);
			$BoardWriteTempSaveCount = $builder->countAllResults();

    		echo json_encode("OK");
	    }else{
	    	echo json_encode("FAIL");
	    }
	}

	//임시저장 리스트중 선택 내용 삭제
	public function getTempDelete(){
		$request = service('request');	

		$session = \Config\Services::session();	

		$db      = \Config\Database::connect();
		$builder = $db->table('boardtemp');

		$id = $this->encrypt_decrypt('decrypt', $request->getPost('id'));

		//id가 세션 아이디와 일치하거나 작성중 세션파괴로 세션 아이디가 없을때 
	    if(($id == $session->get('id')) || !$session->get('id')){
	    	
	    	$builder->where('id', $id);
	    	$builder->where('boardTempId', $request->getPost('boardTempId'));

	    	//임의로 Id,boardTempId 변경했을때 처리
	    	if($builder->get()->getRow()){	 
	    		
	    		$builder->where('boardTempId', $request->getPost('boardTempId'));
	    		$builder->delete();

	    		$this->getTempList();
	    	}else{
	    		echo json_encode("FAIL");
	    	}
	    }else{
	    	echo json_encode("FAIL");
	    }
	}

	//임시저장 리스트중 특정 내용 가져오기 
	public function getTempListContent(){
		$request = service('request');	

		$session = \Config\Services::session();	

		$db      = \Config\Database::connect();
		$builder = $db->table('boardtemp');

		$id = $this->encrypt_decrypt('decrypt', $request->getPost('id'));

		//id가 세션 아이디와 일치하거나 작성중 세션파괴로 세션 아이디가 없을때 
	    if(($id == $session->get('id')) || !$session->get('id')){
	    	
	    	$builder->where('id', $id);
	    	$builder->where('boardTempId', $request->getPost('boardTempId'));

	    	//임의로 Id,boardTempId 변경했을때 처리
	    	if($builder->get()->getRow()){	 
	    		$builder->select('title, content');	
	    		$builder->where('boardTempId', $request->getPost('boardTempId'));

	    		echo json_encode($builder->get()->getRow());
	    	}else{
	    		echo json_encode("FAIL");
	    	}
	    }else{
	    	echo json_encode("FAIL");
	    }
	}

	//임시저장글 리스트 
	public function getTempList(){
		$request = service('request');	

		$session = \Config\Services::session();	

		$db      = \Config\Database::connect();
		$builder = $db->table('boardtemp');

		//1.id 값으로 세션 체크 
		$id = $this->encrypt_decrypt('decrypt', $request->getPost('id'));		
		
	    //id가 세션 아이디와 일치하거나 작성중 세션파괴로 세션 아이디가 없을때 
	    if(($id == $session->get('id')) || !$session->get('id')){	    	

	    	$builder->select('boardTempId, title, created');
			$builder->where('id', $id);
			$builder->orderBy('created', 'DESC');
			
			$query = $builder->get()->getResultArray();

			$builder->where('id', $id);
			array_push($query, $builder->countAllResults());
			
			echo json_encode($query);

	    }else{
	    	echo json_encode("FAIL");
	    }
	}

	//임시저장 버튼 입력
	public function setTempContent(){

		$request = service('request');	

		$session = \Config\Services::session();	

		$db      = \Config\Database::connect();
		$builder = $db->table('boardtemp');

		//1.id 값으로 세션 체크 
		$id = $this->encrypt_decrypt('decrypt', $request->getPost('id'));		

	    //id가 세션 아이디와 일치하거나 작성중 세션파괴로 세션 아이디가 없을때 
	    if(($id == $session->get('id')) || !$session->get('id')){

	    	if($request->getPost('gubun') == "first"){

            	$data = [
					'id'		=> $id,
              		'title'		=> $request->getPost('title'),
             		'content'	=> $request->getPost('content'),
            	    'created'	=> date("Y-m-d H:i:s"),
            	];
            	
               	$builder->insert($data);

               	//저장된 임시등록 글 갯수
				$builder->where('id', $id);
				$BoardWriteTempSaveCount = $builder->countAllResults();

               	echo $BoardWriteTempSaveCount;
	    	
	    	}else if($request->getPost('gubun') == "otherThan"){

	    		//update 가장최근의 임시저장 게시글을 가져와서 업데이트 한다.
				$builder->select('boardTempId');				
				$builder->where('id', $id);
				$builder->orderBy('created', 'DESC');
				$builder->limit(1); 				
				$query   = $builder->get()->getRow();		

				if($query){
					$data = [
				        'title' => $request->getPost('title'),
				        'content'  => $request->getPost('content'),
				        'created'	=> date("Y-m-d H:i:s"),
					];

					$builder->where('boardTempId', $query->boardTempId);
					$builder->update($data);
				}else{
						$data = [
						'id'		=> $id,
	              		'title'		=> $request->getPost('title'),
	             		'content'	=> $request->getPost('content'),
	            	    'created'	=> date("Y-m-d H:i:s"),
	            	];
	            	
	               	$builder->insert($data);
				}

				//저장된 임시등록 글 갯수
				$builder->where('id',$id);
	    		echo $builder->countAllResults();
	    	}else{
	    		echo "FAIL";
	    	}	    	
	    }else{
	    	echo "FAIL";
	    }

	}
}
