<div class="wrapper fadeInDown zero-raduis">
  <div id="formContent">
    <div class="homeIcon">
      <i class="fas fa-home" onclick="location.href='/'" style="cursor:pointer;"></i>
    </div>
    <div class="">
      <img src="/image/logo.png" alt="logo" class="logo">      
      <h1>로그인</h1>
    </div>
    <!-- Login Form -->
    <form action="/loginCheck" id="login_form" name="login_form" method="post">
      <input type="text" id="id" class="zero-raduis enterkey" name="id" placeholder="id" maxlength="20">
      <input type="password" id="password" class="zero-raduis enterkey" name="password" placeholder="password" maxlength="20">
      <div id="formFooter" class="">            
        <div class="custom-control custom-checkbox" style="float: left;">
          <input type="checkbox" name="loginCheck" id="jb-checkbox" class="custom-control-input">              
          <label class="custom-control-label" for="jb-checkbox">로그인 상태 유지</label>
        </div>
        <div>
        <a class="underlineHover" href="/find">아이디/비밀번호 찾기</a></div>
      </div>
      <input type="hidden" id="g-recaptcha" name="g-recaptcha">
      <input type="button"  id="login_btn" class="zero-raduis" value="로그인">
      <h2 class="">아직 회원가입을 하지 않으셨나요?</h2>
      <a href="/signUp">
      <input type="button" class="zero-raduis pc" value="회원가입"></a>
    </form>
  </div>
</div>
<script type="text/javascript" src='/dist/login_bundle.js'></script>