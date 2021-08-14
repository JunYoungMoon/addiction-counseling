<div class="wrapper fadeInDown zero-raduis">
  <div id="formContent">
    <div class="homeIcon">
      <i class="fas fa-home" onclick="location.href='/'" style="cursor:pointer;"></i>            
    </div>
    <div class="">
      <img src="/image/logo.png" alt="logo" class="logo">      
      <h1>아이디/비밀번호 찾기</h1>
    </div>
    <br>
    <!-- Login Form -->
    <form action="/idpwSendMail" id="find_form" name="find_form" method="post">
      <input type="email" id="email" class="fadeIn third zero-raduis" name="email" placeholder="이메일" maxlength="30">        
      <div id="email_check"></div>  
      <div id="email_notice">입력된 메일로 아이디와 임시비밀번호를 전송합니다.</div>
      <br>
      <input type="hidden" id="g-recaptcha" name="g-recaptcha">
      <input type="button" id="find_btn" class="fadeIn fourth zero-raduis pc" value="아이디/비밀번호 찾기"></a>
    </form>
  </div>
</div>