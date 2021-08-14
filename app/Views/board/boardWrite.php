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
      <?php }?>      
    </div>
    <div class="">
      <img src="/image/logo.png" alt="logo" class="logo">      
      <h1><?=$title?></h1>
    </div>
    <br>
    <form action="/boardWrite" id="boardWrite_form" name="boardWrite_form" method="post">      
      <div class="custom-control custom-checkbox secret-check">
        <input type="checkbox" name="secret" id="secret" class="custom-control-input" <?= isset($row['secret']) ? (($row['secret'] == "O") ? "checked=''": ""): ""; ?>>              
        <label class="custom-control-label" for="secret">비밀글</label>
      </div>
      <div class="temp_save_area">
        <button type="button" class="btn_temp_save btn btn-dark">임시등록</button>
        <button type="button" class="btn_temp_count btn btn-dark TempSaveCount" data-toggle="modal" data-target="#tempListModal"><?=$BoardWriteTempSaveCount?></button>
      </div>      
      <input type="hidden" id="id" name="id" value=<?=$ciphertext?>>
      <input type="text" id="title" class="zero-raduis" name="title" placeholder="제목" maxlength="15" value="<?= isset($row) ? $row['title'] : '';?>">   
      <textarea id="content" class="zero-raduis" name="content"><?= isset($row) ? $row['content'] : '';?></textarea>
      <br>
      <input type="hidden" id="g-recaptcha" name="g-recaptcha">
      <input type="hidden" id="divide" name="divide" value="<?= isset($modify) ? $modify : '';?>">
      <input type="hidden" id="boardId" name="boardId" value="<?= isset($row) ? $row['boardId'] : '';?>">
      <input type="button" id="boardWrite_btn" class="zero-raduis pc" value="<?=$title?>">
    </form>
  </div>
</div>
<script type="text/javascript" src="/smartEditor2/js/HuskyEZCreator.js" charset="utf-8"></script>

<!-- Modal -->
<div class="modal fade" id="tempListModal" tabindex="-1" aria-labelledby="tempListModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tempListModalLabel">임시등록 리스트</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-container-notice">
        <div class="modal-notice">임시등록 글은 30일동안 최대 60개까지 저장됩니다.</div>
        <div class="modal-delete">
        <button type="button" class="btn_temp_all_delete btn btn-dark">전체삭제</button>
        </div>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>
