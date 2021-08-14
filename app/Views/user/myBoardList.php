<div class="wrapper fadeInDown zero-raduis">
  <input type="hidden" id="g-recaptcha" name="g-recaptcha">
  <div id="formContent">
    <div class="homeIcon">
      <i class="fas fa-home" onclick="location.href='/'" style="cursor:pointer;"></i>     
      <?php 
          $session = \Config\Services::session();                    

          if($session->get('id')){
      ?>
      <i class="fas fa-user" onclick="location.href='/myInfo'" style="cursor:pointer;"></i>
      <i class="fas fa-list-ul" onclick="location.href='/myBoardList/1'" style="cursor:pointer;"></i>
      <i class="fas fa-sign-out-alt" onclick="location.href='/logout'" style="cursor:pointer;"></i>
      <?php }else{?>                
      <i class="fas fa-sign-in-alt" onclick="location.href='/login'" style="cursor:pointer;"></i>
      <?php }?>       
    </div>
    <div class="">
      <img src="/image/logo.png" alt="logo" class="logo">  
    </div>
    <div class="table-title">
      <div>    
        <h1>나의 게시글</h1>
      </div>
    </div>
    
    <div class="writebtn">
      <a href="/boardWriteView">
        <button type="button" class="btn btn-dark btn-create <?php $detect = new Mobile_Detect; if ( $detect->isMobile() ) {print_r('btn-sm');}?>"><i class="material-icons" style="font-size: 15px">&#xE254;</i>글쓰기</button>
      </a>
    </div>
    <div class="table-area">
      <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>제목</th>
                <th>작성일<i class="fa fa-sort"></i></th>
                <th>조회수</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $list_value):?>
            <tr onclick="location.href='/boardView/<?=$list_value['boardId']?>'" style="cursor:pointer;">                        
                <td><?=$list_value['no']?>
                <td><?=$list_value['title']?>
                </td>
                <td><?=$list_value['created']?></td>
                <td>1</td>
            </tr>
        <?php endforeach; ?>       
        </tbody>
      </table> 
    </div>
      <div class="clearfix">

        <?php if($startPage != 0 && $endPage != 0){?>
        <ul class="pagination">

            <?php if($_SERVER['REQUEST_URI'] == '/myBoardList/'.$startPage){?>
            <li class="page-item disabled">
            <?php }else{?>
            <li class="page-item">
            <?php }?>    
                <a href="/myBoardList/<?=$startPage?>">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </li>

            <?php for($iCount = $startPage; $iCount <= $endPage; $iCount++):?>

                <!-- 경로가 / 일때 1번 페이징 버튼 1번 활성화 -->
                <?php if($_SERVER['REQUEST_URI'] =="/myBoardList" && $iCount == $startPage){ ?>
                    <li class="page-item active"><a href="/myBoardList/<?=$iCount?>" class="page-link"><?=$iCount?></a></li>                        
                <?php }else if($_SERVER['REQUEST_URI'] =="/myBoardList/".$iCount){ ?>
                    <li class="page-item active"><a href="/myBoardList/<?=$iCount?>" class="page-link"><?=$iCount?></a></li>
                <?php }else{?>
                    <li class="page-item"><a href="/myBoardList/<?=$iCount?>" class="page-link"><?=$iCount?></a></li>
                <?php }?>

            <?php endfor;?>

            <?php if($_SERVER['REQUEST_URI'] == '/myBoardList/'.$endPage){?>
            <li class="page-item disabled">
            <?php }else{?>
            <li class="page-item">
            <?php }?>              
                <a href="/myBoardList/<?=$endPage?>">
                    <i class="fa fa-angle-double-right"></i>
                </a>
            </li>
            
        </ul>
      <?php }?>
    </div>
  </div>
</div>