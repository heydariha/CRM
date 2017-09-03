<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$title		= isset($title) ? $title : 'ddd';
$baseAdr	= '';
$baseURL	= base_url().'vendore/template/';
$str		= "
<!-- Favicons -->
<link rel='shortcut icon' href='{$baseURL}img/favicon.ico'>
<link rel='apple-touch-icon' href='{$baseURL}img/apple-touch-icon.png'>
<link rel='apple-touch-icon' sizes='72x72' href='{$baseURL}img/apple-touch-icon-72x72.png'>
<link rel='apple-touch-icon' sizes='114x114' href='{$baseURL}img/apple-touch-icon-114x114.png'>
<link rel='apple-touch-icon' sizes='144x144' href='{$baseURL}img/apple-touch-icon-144x144.png'>

<!-- Google Webfonts -->
<link href='".base_url('vendore/PersianFonts/font-awesome/css/font-awesome.min.css')."' rel='stylesheet'>

<!--[if lt IE 9]>
<script src='{$baseURL}js/libs/respond.min.js'></script>
<![endif]-->

<!-- Bootstrap Core CSS -->
<link href='{$baseURL}css/bootstrap.css' rel='stylesheet'>

<!-- Theme Styles CSS-->
<link rel='stylesheet' href='{$baseURL}css/style.css' >
<link rel='stylesheet' href='{$baseURL}css/flexslider.css'/>
<link rel='stylesheet' href='{$baseURL}css/nivo-lightbox.css' />
<link rel='stylesheet' href='{$baseURL}images/themes/default/default.css' />
<link rel='stylesheet' href='{$baseURL}css/animate.css' />

<!--[if lt IE 9]>
<script src='{$baseURL}/js/libs/html5.js'></script>
<![endif]-->

<!-- Style Switch -->
<link rel='stylesheet' type='text/css' href='{$baseURL}css/colors/yellow-black.css' title='yellow' media='screen' />";
$page->page->acse	= $str;
$page->page->headPage();
?>

<!-- LOADING MASK -->
<div id="mask">   
    <div class="loader">
        <img src="<?php echo base_url('vendore/template/images/loading.gif');?>" alt='loading'>
    </div>
</div>

<!-- MAIN CONTENT -->
<?php $obj		= get_instance();?>
<div class="main-content">
	<div class="container no-padding" style='width:80%' >
		<div class="row" >
			<div class="col-md-3 l-content">
				<div class="profile-pic">
					<div>
						<a title="Exit" href="<?php echo base_url('login/logout');?>"><i class="fa fa-times" style="font-size:18pt" aria-hidden="true"></i></a>
						<a title="Home" href="<?php echo base_url('todo');?>"><i class="fa fa-home" style="font-size:18pt" aria-hidden="true"></i></a>
					</div>
					<div class="pic-bg"><img src="<?php echo base_url('vendore/template/images/profile-avatar.png');?>" class="img-responsive" alt=""/></div>
				</div>
				<nav>
					<ul class="navigation">
						<li onclick='window.location="<?php echo base_url('todo');?>"'><a href="#"><i class="fa fa-comment"></i> <?php echo $obj->lang->line('tit_customers_list');?></a></li>
						<li onclick='window.location="<?php echo base_url('mainPage');?>"'><a href="<?php echo base_url('mainpage');?>"><i class="fa fa-user"></i> <?php echo $obj->lang->line('tit_Personal_Information');?></a></li>
						<li onclick='window.location="<?php echo base_url('mainPage/changePass');?>"'><a href="#"><i class="fa fa-lock"></i> <?php echo $obj->lang->line('tit_Change_Password');?></a></li>
					</ul>
				</nav>
			</div>
			<div class="col-md-9 r-content" >
				<div class="flexslider" >
					<div class="slides">