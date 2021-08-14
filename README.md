# 중독 상담 게시판

![20210321_135434_1](https://user-images.githubusercontent.com/35192352/111908567-13b41680-8a9d-11eb-8234-bcd0a2652617.png)


## 중독 원인 상담 게시판이란?

- 사용자가 간단하게 회원가입을 하고 게시판에 본인의 중독 현상에 대해 구체적으로 작성 후 관리자가 답변해 주는 방식으로, 사용자는 관리자의 답변을 통해 사용자 본인 스스로 중독의 **원인**을 알아낼 수 있도록 유도한다.


## 프로젝트 개요

- 본인은 도박 중독으로 꽤나 많은 고통을 겪었고 이를 극복하기 위해 중독의 본질에 대해 `계속해서 연구 중`이다. 내가 습득한 지식을 현재 중독에 빠져 고통을 겪는 사용자에게 조금이라도 도움이 되었으면 한다.

- 본인 스스로 처한 상황에 대해서 작성하는 글의 비밀 보장이 되지않고 관련된 커뮤니티 사이트가 없어 `전혀 관련 없는 사이트에서 글을 작성하는 모습`도 목격하였다.

- 1차적으로 사용자가 본인 스스로 처한 상황에 대해 구체적으로 작성하는 것만으로도 해결에 많은 도움이 되고, 상담을 통해서 `스스로 원인을 깨달을수 있도록 유도`한다.

- 중독의 분야가 광범위하지만 `중독의 근원은 모두 일치`하기에 상담을 할 수 있다고 판단하였고 해당 프로젝트를 시작하게 되었다.

## 기술스택

- **CodeIgniter 4**
- **PHP7.4**
- **Webpack**
- **Apache 2.4.43**
- **MySql**
- **Bootstrap 4.5**

![20210321_144411](https://user-images.githubusercontent.com/35192352/111908115-4eb54a80-8a9b-11eb-99a3-cee2b8b5e36b.png)

## 기능

- 기본적인 CRUD 기능 구현, url로 입력시 entry는 route.app를 통해 분기처리, 자동입력 방지를 위해 recaptcha-v3 등록 
- 프로젝트 부분적으로 webpack 도입을 통하여 속도 개선 (참고 :https://blog.naver.com/ko5642027/222261117589)
- 본인인증, 아이디/패스워드찾기, 내정보변경시 메일인증 
- 본인이 아닌 경우 비밀글 열람 불가능 id값을 암호화하여 처리 


**로그인**

![20210321_135434_2](https://user-images.githubusercontent.com/35192352/111908578-1adb2480-8a9d-11eb-8e39-40ce7240d29e.png)

**회원가입**

![20210321_135434_3](https://user-images.githubusercontent.com/35192352/111908657-61c91a00-8a9d-11eb-802f-8588aa54378b.png)


**아이디/비밀번호찾기**

![20210321_135434_4](https://user-images.githubusercontent.com/35192352/111908669-6a215500-8a9d-11eb-96b2-d49da3a777fe.png)


**메일발송**

![20210321_135434_6](https://user-images.githubusercontent.com/35192352/111908677-70afcc80-8a9d-11eb-90b5-2dd88fd10bc0.png)


**내정보 변경**


![20210321_135434_7](https://user-images.githubusercontent.com/35192352/111908682-773e4400-8a9d-11eb-9522-3f218eb023ab.png)


**나의 게시글**


![20210321_135434_8](https://user-images.githubusercontent.com/35192352/111908858-2844de80-8a9e-11eb-93b9-953aaab0db38.png)



**임시저장글 리스트**


![제목 없음](https://user-images.githubusercontent.com/35192352/111908710-90df8b80-8a9d-11eb-91c6-8e5af0a8b299.png)


**게시글 상세 뷰**


![20210321_151119](https://user-images.githubusercontent.com/35192352/111908728-9ccb4d80-8a9d-11eb-828f-46cda310698b.png)


**게시글 입력**


![20210321_135434_9](https://user-images.githubusercontent.com/35192352/111908736-a3f25b80-8a9d-11eb-843f-9b9a6d63078e.png)
