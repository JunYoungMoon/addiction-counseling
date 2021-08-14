<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<style>
	.dummy-positioning {
  -webkit-box-align: center;
          align-items: center;
  -webkit-box-pack: center;
          justify-content: center;
}

.success-icon {
  display: inline-block;
  width:4em;
  height:4em;
  font-size: 20px;
  border-radius: 50%;
  border: 4px solid #96df8f;
  background-color: #fff;
  position: relative;
  overflow: hidden;
  -webkit-transform-origin: center;
          transform-origin: center;
  -webkit-animation: showSuccess 180ms ease-in-out;
          animation: showSuccess 180ms ease-in-out;
  -webkit-transform: scale(1);
          transform: scale(1);
}

.success-icon__tip, .success-icon__long {
  display: block;
  position: absolute;
  height: 4px;
  background-color: #96df8f;
  border-radius: 10px;
}
.success-icon__tip {
  width: 2.4em;
  top:2.15em;
  left: 1.4em;
  -webkit-transform: rotate(45deg);
          transform: rotate(45deg);
  -webkit-animation: tipInPlace 300ms ease-in-out;
          animation: tipInPlace 300ms ease-in-out;
  -webkit-animation-fill-mode: forwards;
          animation-fill-mode: forwards;
  -webkit-animation-delay: 180ms;
          animation-delay: 180ms;
  visibility: hidden;
}
.success-icon__long {
  width: 4em;
  -webkit-transform: rotate(-45deg);
          transform: rotate(-45deg);
  top: 1.85em;
  left: 2.75em;
  -webkit-animation: longInPlace 140ms ease-in-out;
          animation: longInPlace 140ms ease-in-out;
  -webkit-animation-fill-mode: forwards;
          animation-fill-mode: forwards;
  visibility: hidden;
  -webkit-animation-delay: 440ms;
          animation-delay: 440ms;
}

@-webkit-keyframes showSuccess {
  from {
    -webkit-transform: scale(0);
            transform: scale(0);
  }
  to {
    -webkit-transform: scale(1);
            transform: scale(1);
  }
}

@keyframes showSuccess {
  from {
    -webkit-transform: scale(0);
            transform: scale(0);
  }
  to {
    -webkit-transform: scale(1);
            transform: scale(1);
  }
}
@-webkit-keyframes tipInPlace {
  from {
    width: 0em;
    top: 0em;
    left: -0.8em;
  }
  to {
    width:1.2em;
    top: 2.15em;
    left: 0.7em;
    visibility: visible;
  }
}
@keyframes tipInPlace {
  from {
    width: 0em;
    top: 0em;
    left: -0.8em;
  }
  to {
    width:1.2em;
    top: 2.15em;
    left:0.7em;
    visibility: visible;
  }
}
@-webkit-keyframes longInPlace {
  from {
    width: 0em;
    top: 2.55em;
    left:1.6em;
  }
  to {
    width: 2em;
    top: 1.85em;
    left: 1.375em;
    visibility: visible;
  }
}
@keyframes longInPlace {
  from {
    width: 0em;
    top: 2.55em;
    left: 1.6em;
  }
  to {
    width: 2em;
    top: 1.85em;
    left: 1.375em;
    visibility: visible;
  }
}

</style>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="dummy-positioning d-flex">
  
  <div class="success-icon">
    <div class="success-icon__tip"></div>
    <div class="success-icon__long"></div>
  </div>
<a href="/login" class="btn">홈으로</a>
</div>