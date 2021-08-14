<div class="wrapper fadeInDown zero-raduis">
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
      <h1>게시글</h1>
    </div>
    <br>
    <form action="/boardWriteView/<?=$row['boardId']?>" id="boardWrite_form" name="boardWrite_form" method="post">
      <br>
      <div class="title_area" style="padding-bottom: 20px;">
        <h3 class="title_text">
           <?=$row['title']?>
        </h3>
      </div>
      <div style="text-align: left; margin-left: 8%; padding-bottom: 20px;">
        <div><?=$row['id']?></div>
        <div><?=$row['created']?></div>
      </div>
      <div style="text-align: right; padding-right: 20px;">        
        <button type="button" class="btn btn-dark btn-create <?php $detect = new Mobile_Detect; if ( $detect->isMobile() ) {print_r('btn-sm');}?>" onclick="location.href='/boardWriteView'"><i class="material-icons" style="font-size: 15px">&#xE254;</i>글쓰기</button>
        <?php 
          $session = \Config\Services::session(); 
          if($session->get('id') == $row['id']){
        ?>
        <button type="submit" class="btn_modify btn btn-dark <?php $detect = new Mobile_Detect; if ( $detect->isMobile() ) {print_r('btn-sm');}?>">수정</button>
        <button type="button" class="btn_delete btn btn-dark <?php $detect = new Mobile_Detect; if ( $detect->isMobile() ) {print_r('btn-sm');}?>" onclick="location.href='/boardDelete/<?=$row['boardId']?>'">삭제</button>
        <?php }?>
      </div>
      <div style="padding-right: 20px; padding-left: 20px;">
      <hr>
      <div class="content">
        <?=$row['content']?>
      </div>      
      <hr>
      </div>
      <input type="hidden" id="g-recaptcha" name="g-recaptcha">
      <input type="hidden" id="id" name="id" value=<?=$ciphertext?>>
      
      <div id="reply">
      <?php 
        if($reply != array()){
      ?>
        <div style="text-align: left; margin-left:5%; font-size: 20px; padding-top: 20px;">댓글</div>        
        <?php 
          foreach ($reply as $reply_value):
        ?>
        <div style="padding-right: 30px; padding-left: 30px;">
        <hr>
        <div id="<?=$reply_value['replyId']?>">
          <div style="text-align: left; float: left; font-weight: 700"><?=$reply_value['id']?></div>
          <div style="text-align: right; "><?=$reply_value['created']?></div>
          <div style="text-align: left; word-break:break-all;"><?=$reply_value['content']?>
          <?php 
            $session = \Config\Services::session(); 
            if($session->get('id') == $row['id'] || $session->get('id') == "admin1"){
          ?>          
          <i class='fas fa-pencil-alt' style="cursor:pointer"></i>
          <i class="far fa-trash-alt" style="cursor:pointer"></i>          
          <?php }?>
          </div>
        </div>
        <hr>
        </div>
        <?php 
          endforeach; 
        ?>         
      <?php 
        }
      ?>
      </div>

      <?php $session = \Config\Services::session(); 
      if($session->get('id') == $row['id'] || $session->get('id') == "admin1"){?>
      <div id="replyArea">
        <textarea id="replyWriteContent" cols="60" rows="5" style="width: 85%"></textarea>
        <input type="button" id="replyWrite_btn" class="fadeIn fourth zero-raduis pc" value="댓글작성">
      </div>
      <?php }?>
    </form>
  </div>
</div>