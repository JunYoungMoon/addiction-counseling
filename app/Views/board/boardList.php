<body>
<div class="wrapper fadeInDown zero-raduis">
    <input type="hidden" id="g-recaptcha" name="g-recaptcha">
    <div class="formContent">                   
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
                    <h1>중독 상담 게시판</h1>
                </div>
            </div>
            <div class="writebtn">
                <a href="/boardWriteView">
                <button type="button" class="btn btn-dark btn-create <?php $detect = new Mobile_Detect; if ( $detect->isMobile() ) {print_r('btn-sm');}?>"><i class="material-icons" style="font-size: 15px">&#xE254;</i>글쓰기</button>
                </a>
            </div>
            <?php 
                $detect = new Mobile_Detect;

                if ( $detect->isMobile() ) {
            ?>
                <div class="table-area">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>                                
                                <th>제목</th>                                
                                <th>조회수</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                                $session = \Config\Services::session();

                                foreach ($list as $list_value):?>
                            <tr 
                            <?php 
                                if((($session->get('id') == $list_value['id']) && ($list_value['secret'] == "O")) || ($session->get('id') == "admin1")){
                            ?>
                                onclick="location.href='/boardView/<?=$list_value['boardId']?>'"                         
                            <?php
                                }else if(($list_value['secret'] == "X")){
                            ?>
                                onclick="location.href='/boardView/<?=$list_value['boardId']?>'"
                            <?php
                                }else if(($session->get('id') != $list_value['id']) && ($list_value['secret'] == "O")){
                            ?>
                                onclick="secretCheck()"
                            <?php }?>

                         style="cursor:pointer;">                        
                                <td><?=$list_value['no']?>                                
                                <?php if($list_value['secret'] == "O"){?>
                                <td>비밀글 입니다. <i class="fas fa-lock"></i></td>
                                <?php }else if($list_value['id'] == "admin"){?>
                                <td><?=$list_value['title']?><i class="fas fa-exclamation-circle"></i></td>
                                <?php }else{?>
                                <td><?=$list_value['title']?></td>
                                <?php }?>           
                                <td><?=$list_value['hit']?></td>
                            </tr>
                        <?php endforeach; ?>       
                        </tbody>
                    </table>
                </div>
            <?php                 
                }else{
            ?>
                <div class="table-area">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th style="width: 150px;">아이디</th>
                                <th>제목</th>
                                <th style="width: 180px;">작성일</th>
                                <th>조회수</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                                $session = \Config\Services::session(); 
                                foreach ($list as $list_value):?>
                            <tr 
                            <?php                             
                                if((($session->get('id') == $list_value['id']) && ($list_value['secret'] == "O")) || ($session->get('id') == "admin1")){
                            ?>
                                onclick="location.href='/boardView/<?=$list_value['boardId']?>'"                         
                            <?php
                                }else if(($list_value['secret'] == "X")){
                            ?>
                                onclick="location.href='/boardView/<?=$list_value['boardId']?>'"
                            <?php
                                }else if(($session->get('id') != $list_value['id']) && ($list_value['secret'] == "O")){
                            ?>
                                onclick="secretCheck()"
                            <?php }?>

                         style="cursor:pointer;">                        
                                <td><?=$list_value['no']?>
                                <td><?=$list_value['id']?></td>
                                <?php if($list_value['secret'] == "O"){?>
                                <td>비밀글 입니다. <i class="fas fa-lock"></i></td>
                                <?php }else if($list_value['id'] == "admin"){?>
                                <td><?=$list_value['title']?><i class="fas fa-exclamation-circle"></i></td>
                                <?php }else{?>
                                <td><?=$list_value['title']?></td>
                                <?php }?>
                                <td><?=$list_value['created']?></td>
                                <td><?=$list_value['hit']?></td>
                            </tr>
                        <?php endforeach; ?>       
                        </tbody>
                    </table> 
                </div>
            <?php 
                } 
            ?>            

            <div class="clearfix">
                <!-- <div class="hint-text">Showing <b>10</b> out of <b>25</b> entries</div> -->
                <ul class="pagination">

                    <?php if($_SERVER['REQUEST_URI'] == '/'.$startPage){?>
                    <li class="page-item disabled">
                    <?php }else{?>
                    <li class="page-item">
                    <?php }?>    
                        <a href="/<?=$startPage?>">
                            <i class="fa fa-angle-double-left"></i>
                        </a>
                    </li>

                    <?php for($iCount = $startPage; $iCount <= $endPage; $iCount++):?>

                        <!-- 경로가 / 일때 1번 페이징 버튼 1번 활성화 -->
                        <?php if($_SERVER['REQUEST_URI'] =="/" && $iCount == $startPage){ ?>
                            <li class="page-item active"><a href="/<?=$iCount?>" class="page-link"><?=$iCount?></a></li>                        
                        <?php }else if($_SERVER['REQUEST_URI'] =="/".$iCount){ ?>
                            <li class="page-item active"><a href="/<?=$iCount?>" class="page-link"><?=$iCount?></a></li>
                        <?php }else{?>
                            <li class="page-item"><a href="/<?=$iCount?>" class="page-link"><?=$iCount?></a></li>
                        <?php }?>

                    <?php endfor;?>

                    <?php if($_SERVER['REQUEST_URI'] == '/'.$endPage){?>
                    <li class="page-item disabled">
                    <?php }else{?>
                    <li class="page-item">
                    <?php }?>              
                        <a href="/<?=$endPage?>">
                            <i class="fa fa-angle-double-right"></i>
                        </a>
                    </li>                    
                </ul>
            </div>
        </div>
    </div>  
    <script type="text/javascript" src='/dist/boardList_bundle.js'></script>
</body>