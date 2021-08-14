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
      <h1>내정보</h1>      
    </div>
    <!-- Login Form -->
    <form action="/changeInformation" id="changeInformation_form" name="changeInformation_form" method="post">
      <div style="margin:10px ; padding: 10px">
        <?php 
          $session = \Config\Services::session(); 

          echo $session->get('id');
        ?>        
      </div>
      
      <input type="password" id="password" class="zero-raduis" name="password" placeholder="현재비밀번호" maxlength="20">
      <input type="password" id="password1" class="zero-raduis" name="password1" placeholder="새비밀번호" maxlength="20">
      <input type="password" id="password2" class="zero-raduis" name="password2" placeholder="새비밀번호 확인" maxlength="20">
      <div id="password_check"></div>
      <input type="email" id="email" class="zero-raduis" name="email" placeholder="이메일" value="<?php echo $session->get('email');?>">        
      <div id="email_check"></div>  
      <div id="email_notice">※ 메일 변경시 본인인증 메일이 재전송 됩니다. ※</div>      
      <input type="hidden" id="g-recaptcha" name="g-recaptcha">
      <input type="hidden" id="id" name="id" value=<?=$ciphertext?>>
      <input type="button" id="myInfo_btn" class="zero-raduis" value="내정보수정">
    </form>
  </div>
</div>