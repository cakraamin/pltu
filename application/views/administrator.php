<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

<title>Aplikasi PLTU - Ionlinesoft</title>

        <!--[if lt IE 9]>

          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

        <![endif]-->

<link href="<?=base_url()?>assets/template/fingers/css/zice.style.css" rel="stylesheet" type="text/css" />

<link href="<?=base_url()?>assets/template/fingers/css/icon.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/template/fingers/components/tipsy/tipsy.css" media="all"/>

<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/template/fingers/components/jquery.tzineClock/jquery.tzineClock.css" media="all"/>

<style type="text/css">

html {

	background-image: none;

}

#versionBar {

	background-color:#212121;

	position:fixed;

	width:100%;

	height:35px;

	bottom:0;

	left:0;

	text-align:center;

	line-height:35px;

}

.copyright{

	text-align:center; font-size:10px; color:#CCC;

}

.copyright a{

	color:#A31F1A; text-decoration:none

}    

.copyright a.login{

    color:#FFF; text-decoration:none

}
#administrator{
  width: 600px;
  margin: 70px auto;  
}

</style>
</head>

<body >

         

<div id="alertMessage" class="error"></div>

<div id="successLogin"></div>

<div class="text_success"><img src="<?=base_url()?>assets/template/fingers/images/loadder/loader_green.gif"  alt="ziceAdmin" /><span>Please wait</span></div>
  <div id="administrator">
    <div class="alertMessage SE">      
      Mohon Tidak Menutup Halaman Ini, terima kasih
    </div> 
    <div id="fancyClock"></div>
  </div>
<div class="clear"></div>

<div id="versionBar" >

  <div class="copyright" > &copy; Copyright 2012  All Rights Reserved <span class="tip"><a  href="http://www.cakra.web.id" title="Cakra Aminuddin" >Ionlinesoft</a> </span></div>

  <!-- // copyright-->

</div>

<!-- Link JScript-->

<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/js/jquery.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/js/site.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/components/effect/jquery-jrumble.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/components/ui/jquery.ui.min.js"></script>     

<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/components/tipsy/jquery.tipsy.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/components/checkboxes/iphone.check.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/components/jquery.tzineClock/jquery.tzineClock.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/js/jquery.form.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/js/login.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#fancyClock').tzineClock();
  });
  setInterval("imports();",10000);
    function imports(){
      $.post( "<?php echo base_url(); ?>setting/import", function( data ) {
        if(data == 'down'){          
          window.location = "<?php echo base_url();?>import/redir";
        }         
      });
    }
</script>

</body>

</html>