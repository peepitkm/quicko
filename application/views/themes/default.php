<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="HandheldFriendly" content="true">
<title><?php echo lang('website_title') ?></title>
<?php if(!empty($meta)) { foreach($meta as $name=>$content) { echo "<meta name=\"<?php echo $name; ?>\" content=\"{$content}\" />\n"; } } ?>
<?php if(!empty($canonical)) { echo "\n\t\t<link rel=\"canonical\" href=\"{$canonical}\" />\n"; } ?>
<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400italic,700italic,400,700" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css'); ?>" type="text/css" />
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/css/flag-icon.min.css'); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/themes/default/css/style.css'); ?>" type="text/css" />
<?php foreach($css as $file) { echo "<link rel=\"stylesheet\" href=\"{$file}\" type=\"text/css\" />\n"; } ?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="<?php echo base_url('assets/js/jquery-1.12.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
<style type="text/css">
<?php
$script = $this->load->get_inline_styling();
echo $script['infile'];
?>
</style>
</head>
<body>
<nav class="navbar navbar-default navbar-nathai navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo site_url(); ?>"><?php echo lang('website_title') ?></a>
		</div>
		<div id="navbar-collapse" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<?php if ($this->uri->segment(1)=='admin') : ?>
				<li<?php echo $this->uri->segment(2)=='' || $this->uri->segment(2)=='dashboard'?' class="active"':NULL ?>><a href="<?php echo site_url('admin/dashboard'); ?>"><?php echo lang('title_menubar_dashboard') ?></a></li>
				<li<?php echo $this->uri->segment(2)=='billing'?' class="active"':NULL ?>><a href="<?php echo site_url('admin/billing'); ?>"><?php echo lang('title_menubar_billing') ?></a></li>
				<li<?php echo $this->uri->segment(2)=='report'?' class="active"':NULL ?>><a href="<?php echo site_url('admin/report'); ?>">Report</a></li>
				<li class="dropdown<?php echo $this->uri->segment(2)=='categories' || $this->uri->segment(2)=='menus' || $this->uri->segment(2)=='tables' ? ' active' : NULL ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Setting <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('admin/menus'); ?>"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> <?php echo lang('title_menubar_menus') ?></a></li>
						<li><a href="<?php echo site_url('admin/categories'); ?>"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> <?php echo lang('title_menubar_categories') ?></a></li>
						<li><a href="<?php echo site_url('admin/tables'); ?>"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> <?php echo lang('title_menubar_tables') ?></a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Printer</a></li>
					</ul>
				</li>
				<?php else : ?>
				<li<?php echo $this->uri->segment(1)=='' || $this->uri->segment(1)=='home'?' class="active"':NULL ?>><a href="<?php echo site_url('home'); ?>"><?php echo lang('title_menubar_home') ?></a></li>
				<li<?php echo $this->uri->segment(1)=='ordering'?' class="active"':NULL ?>><a href="<?php echo site_url('ordering'); ?>"><?php echo lang('title_menubar_ordering') ?></a></li>
				<li<?php echo $this->uri->segment(1)=='billing'?' class="active"':NULL ?>><a href="<?php echo site_url('billing'); ?>"><?php echo lang('title_menubar_billing') ?></a></li>
				<?php endif ?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="#" data-toggle="modal" data-target="#searchModal"><i class="fa fa-fw fa-search"></i> <span class="hidden-lg hidden-md hidden-sm">Search Themes</span></a>
				</li>
				<?php if ($this->uri->segment(1)=='admin') : ?>
				<li><a href="<?php echo site_url('ordering'); ?>"><i class="fa fa-user" aria-hidden="true"></i> Ordering</a></li>
				<?php else : ?>
				<li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="fa fa-user" aria-hidden="true"></i> Manager</a></li>
				<?php endif ?>
				<!--<li><a href="#" data-toggle="modal" data-target="#login-modal"><i class="fa fa-user" aria-hidden="true"></i> Login</a></li>-->
				<li class="dropdown">
					<?php
						$language = $this->session->userdata('site_language');
						switch ($language) {
							case 'thai': $flag_class = 'flag-icon flag-icon-th'; break;
							case 'japaness': $flag_class = 'flag-icon flag-icon-jp'; break;
							default: $flag_class = 'flag-icon flag-icon-us';
						}
					?>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="<?php echo $flag_class ?>"></i> <?php echo lang('title_menubar_language') ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('language/change/english'); ?>"><span class="flag-icon flag-icon-us"></span> <?php echo lang('title_english') ?></a></li>
						<li><a href="<?php echo site_url('language/change/thai'); ?>"><span class="flag-icon flag-icon-th"></span> <?php echo lang('title_thai') ?></a></li>
						<li><a href="<?php echo site_url('language/change/japaness'); ?>"><span class="flag-icon flag-icon-jp"></span> <?php echo lang('title_japanese') ?></a></li>
					</ul>
				</li>
			</ul>
		</div> <!-- /.navbar-collapse -->
	</div> <!-- /.container -->
</nav>

<div class="container-fluid">
<?php echo $output;?>
</div>
<!-- JavaScript -->
<script src="<?php echo base_url('assets/js/bootstrap-notify/bootstrap-notify.js'); ?>"></script>
<?php foreach($js as $file) { echo "\n\t\t<script src=\"{$file}\"></script>\n"; } ?>
<script type="text/javascript">
<?php
$script = $this->load->get_inline_scripting();
echo $script['infile'];
?>
</script>
</body>
</html>