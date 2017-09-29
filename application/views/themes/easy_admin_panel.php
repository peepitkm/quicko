<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="HandheldFriendly" content="true">
<title><?php echo lang('website_title') ?></title>
<?php if(!empty($meta)) { foreach($meta as $name=>$content) { echo "\n\t\t<meta name=\"<?php echo $name; ?>\" content=\"{$content}\" />\n"; } } ?>
<!-- Canonical -->
<?php if(!empty($canonical)) { echo "\n\t\t<link rel=\"canonical\" href=\"{$canonical}\" />\n"; } ?>
<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" type="text/css" />
<!-- Custom CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/themes/easy-admin-panel/css/style.css'); ?>" type="text/css" />
<!-- Graph CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/themes/easy-admin-panel/css/font-awesome.css'); ?>" type="text/css" />
<!-- jQuery : lined-icons -->
<link rel="stylesheet" href="<?php echo base_url('assets/themes/easy-admin-panel/css/icon-font.min.css'); ?>" type="text/css" />
<!-- CSS -->
<?php foreach($css as $file) { echo "\n\t\t<link rel=\"stylesheet\" href=\"{$file}\" type=\"text/css\" />\n"; } ?>

<script type="application/x-javascript">
	addEventListener("load", function() {
		setTimeout(hideURLbar, 0);
	}, false);
	function hideURLbar(){
		window.scrollTo(0,1);
	}
</script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<style type="text/css">
<?php
$script = $this->load->get_inline_styling();
echo $script['infile'];
?>
</style>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
</head>
<body class="sticky-header left-side-collapsed">
<section>
<!-- left side start-->
<div class="left-side sticky-left-side">
	<!--logo and iconic logo start-->
	<div class="logo">
		<h1><a href="index.html"><?php echo lang('title_restaurant_name') ?> <span><?php echo lang('title_admin') ?></span></a></h1>
	</div>
	<div class="logo-icon text-center">
		<a href="<?php echo site_url(); ?>"><i class="lnr lnr-home"></i> </a>
	</div>
	<!--logo and iconic logo end-->
	<div class="left-side-inner">
		<!--sidebar nav start-->
		<ul class="nav nav-pills nav-stacked custom-nav">
			<li class="active"><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="lnr lnr-power-switch"></i><span><?php echo lang('title_menubar_dashboard') ?></span></a></li>
			<li><a href="<?php echo site_url('admin/billing'); ?>"><i class="lnr lnr-menu"></i> <span><?php echo lang('title_menubar_billing') ?></span></a></li>
			<li><a href="<?php echo site_url('admin/categories'); ?>"><i class="lnr lnr-menu"></i> <span><?php echo lang('title_menubar_categories') ?></span></a></li>
			<li><a href="<?php echo site_url('admin/menus'); ?>"><i class="lnr lnr-spell-check"></i> <span><?php echo lang('title_menubar_menus') ?></span></a></li>
			<li><a href="<?php echo site_url('admin/tables'); ?>"><i class="lnr lnr-spell-check"></i> <span><?php echo lang('title_menubar_tables') ?></span></a></li>
			<li class="menu-list">
				<a href="#"><i class="lnr lnr-cog"></i><span>Settings</span></a>
				<ul class="sub-menu-list">
					<li>Categories</li>
					<li>Menus</li>
				</ul>
			</li>
		</ul>
		<!--sidebar nav end-->
	</div>
</div>
<!-- left side end-->

<!-- main content start-->
<div class="main-content">
	<!-- .header-section -->
	<div class="header-section">
		<!--toggle button start-->
		<a class="toggle-btn  menu-collapsed"><i class="fa fa-bars"></i></a>
		<!--toggle button end-->
		<!--notification menu start -->
		<div class="menu-right">
			<div class="user-panel-top">
				<div class="profile_details_left">
					<ul class="nofitications-dropdown">
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-envelope"></i><span class="badge">3</span></a>

					<ul class="dropdown-menu">
					<li>
					<div class="notification_header">
					<h3>You have 3 new messages</h3>
					</div>
					</li>
					<li><a href="#">
					<div class="user_img"><img src="<?php echo base_url('assets/themes/easy-admin-panel/images/1.png'); ?>" alt=""></div>
					<div class="notification_desc">
					<p>Lorem ipsum dolor sit amet</p>
					<p><span>1 hour ago</span></p>
					</div>
					<div class="clearfix"></div>	
					</a></li>
					<li class="odd"><a href="#">
					<div class="user_img"><img src="<?php echo base_url('assets/themes/easy-admin-panel/images/1.png'); ?>" alt=""></div>
					<div class="notification_desc">
					<p>Lorem ipsum dolor sit amet </p>
					<p><span>1 hour ago</span></p>
					</div>
					<div class="clearfix"></div>	
					</a></li>
					<li><a href="#">
					<div class="user_img"><img src="<?php echo base_url('assets/themes/easy-admin-panel/images/1.png'); ?>" alt=""></div>
					<div class="notification_desc">
					<p>Lorem ipsum dolor sit amet </p>
					<p><span>1 hour ago</span></p>
					</div>
					<div class="clearfix"></div>	
					</a></li>
					<li>
					<div class="notification_bottom">
					<a href="#">See all messages</a>
					</div> 
					</li>
					</ul>
					</li>
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue">3</span></a>
					<ul class="dropdown-menu">
					<li>
					<div class="notification_header">
					<h3>You have 3 new notification</h3>
					</div>
					</li>
					<li><a href="#">
					<div class="user_img"><img src="<?php echo base_url('assets/themes/easy-admin-panel/images/1.png'); ?>" alt=""></div>
					<div class="notification_desc">
					<p>Lorem ipsum dolor sit amet</p>
					<p><span>1 hour ago</span></p>
					</div>
					<div class="clearfix"></div>	
					</a></li>
					<li class="odd"><a href="#">
					<div class="user_img"><img src="<?php echo base_url('assets/themes/easy-admin-panel/images/1.png'); ?>" alt=""></div>
					<div class="notification_desc">
					<p>Lorem ipsum dolor sit amet </p>
					<p><span>1 hour ago</span></p>
					</div>
					<div class="clearfix"></div>	
					</a></li>
					<li><a href="#">
					<div class="user_img"><img src="<?php echo base_url('assets/themes/easy-admin-panel/images/1.png'); ?>" alt=""></div>
					<div class="notification_desc">
					<p>Lorem ipsum dolor sit amet </p>
					<p><span>1 hour ago</span></p>
					</div>
					<div class="clearfix"></div>	
					</a></li>
					<li>
					<div class="notification_bottom">
					<a href="#">See all notification</a>
					</div> 
					</li>
					</ul>
					</li>	
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tasks"></i><span class="badge blue1">22</span></a>
					<ul class="dropdown-menu">
					<li>
					<div class="notification_header">
					<h3>You have 8 pending task</h3>
					</div>
					</li>
					<li><a href="#">
					<div class="task-info">
					<span class="task-desc">Database update</span><span class="percentage">40%</span>
					<div class="clearfix"></div>	
					</div>
					<div class="progress progress-striped active">
					<div class="bar yellow" style="width:40%;"></div>
					</div>
					</a></li>
					<li><a href="#">
					<div class="task-info">
					<span class="task-desc">Dashboard done</span><span class="percentage">90%</span>
					<div class="clearfix"></div>	
					</div>

					<div class="progress progress-striped active">
					<div class="bar green" style="width:90%;"></div>
					</div>
					</a></li>
					<li><a href="#">
					<div class="task-info">
					<span class="task-desc">Mobile App</span><span class="percentage">33%</span>
					<div class="clearfix"></div>	
					</div>
					<div class="progress progress-striped active">
					<div class="bar red" style="width: 33%;"></div>
					</div>
					</a></li>
					<li><a href="#">
					<div class="task-info">
					<span class="task-desc">Issues fixed</span><span class="percentage">80%</span>
					<div class="clearfix"></div>	
					</div>
					<div class="progress progress-striped active">
					<div class="bar  blue" style="width: 80%;"></div>
					</div>
					</a></li>
					<li>
					<div class="notification_bottom">
					<a href="#">See all pending task</a>
					</div> 
					</li>
					</ul>
					</li>
					<li><a href="<?php echo site_url('language/change/english'); ?>">English</a></li>
					<li><a href="<?php echo site_url('language/change/thai'); ?>">Thai</a></li>
					<li><a href="<?php echo site_url('language/change/japaness'); ?>">Japaness</a></li>	   		
					<div class="clearfix"></div>
					</ul>
				</div>
				<div class="profile_details">
					<ul>
						<li class="dropdown profile_details_drop">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<div class="profile_img">	
						<span style="background:url(<?php echo base_url('assets/themes/easy-admin-panel/images/1.jpg'); ?>) no-repeat center"> </span> 
						<div class="user-name">
						<p>Michael<span>Administrator</span></p>
						</div>
						<i class="lnr lnr-chevron-down"></i>
						<i class="lnr lnr-chevron-up"></i>
						<div class="clearfix"></div>	
						</div>	
						</a>
						<ul class="dropdown-menu drp-mnu">
						<li> <a href="#"><i class="fa fa-cog"></i> Settings</a> </li> 
						<li> <a href="#"><i class="fa fa-user"></i>Profile</a> </li> 
						<li> <a href="<?php echo site_url('') ?>"><i class="fa fa-sign-out"></i> Logout</a> </li>
						</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- notification menu end -->
	</div>
	<!-- /.header-section -->
	
	<div id="page-wrapper" class="container-fluid">
		<?php echo $output;?>
	</div>

	<!-- footer section start-->
	<footer>
		<p>&copy 2015 <a href="https://p.w3layouts.com/demos/easy_admin_panel/web/" target="_blank">Easy Admin Panel</a>. All Rights Reserved | Design by <a href="https://w3layouts.com/" target="_blank">w3layouts.</a></p>
	</footer>
	<!-- footer section end-->
</section>

<!-- Chart -->
<script src="<?php echo base_url('assets/themes/easy-admin-panel/js/Chart.js'); ?>"></script>
<!--Animate-->
<link rel="stylesheet" href="<?php echo base_url('assets/themes/easy-admin-panel/css/animate.css'); ?>" type="text/css" media="all">
<script type="text/javascript" src="<?php echo base_url('assets/themes/easy-admin-panel/js/wow.min.js'); ?>"></script>
<script type="text/javascript"> new WOW().init(); </script>
<script type="text/javascript" src="<?php echo base_url('assets/themes/easy-admin-panel/js/jquery.nicescroll.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/themes/easy-admin-panel/js/scripts.js'); ?>"></script>
<!-- JavaScript -->
<?php foreach($js as $file) { echo "<script src=\"{$file}\"></script>\n"; } ?>
<script type="text/javascript">
<?php
$script = $this->load->get_inline_scripting();
echo $script['infile'];
?>
</script>
</body>
</html>