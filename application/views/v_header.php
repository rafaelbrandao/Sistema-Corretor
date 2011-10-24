<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<link href="<?=base_url('/css/style.css')?>" rel="stylesheet" type="text/css"/>

</head>
<body>

<?php
if (!isset($tab)) $tab = FALSE;
if (!isset($notice)) $notice = FALSE;
if (!isset($error)) $error = FALSE;
if (!isset($logged)) $logged = FALSE;
if (!isset($is_admin)) $is_admin = FALSE;
?>
<div id="notice_box" style="visibility: <?=($notice == FALSE ? 'hidden' : 'visible')?>;"><div class="warning_content" onclick="this.parentNode.style.visibility = 'hidden';"><?=($notice == FALSE ? '' : $notice)?></div></div>

<div id="error_box" style="visibility: <?=($error == FALSE ? 'hidden' : 'visible')?>;"><div class="warning_content" onclick="this.parentNode.style.visibility = 'hidden';"><?=($error == FALSE ? '' : $error)?></div></div>

<div id="navi">
	<div id="navi_shadow"></div>
	<ul id="navi_options">
		<div id="logo_cin"></div>
		<li <?=($tab == 'home' ? 'class="selected"' : '')?> onclick="window.location = '<?=base_url('/')?>';">Home</li>
		<li>Avisos</li>
		<li>Cronograma</li>
		<li onclick="window.location = '<?=base_url('/index.php/home/lists')?>';">Listas</li>
		<li>Material</li>
		<? if ($logged) { ?>
			<div id="perfil_button" onclick="window.location = '<?=base_url('/index.php/home/perfil')?>';">perfil</div>
			<div id="logout_button" onclick="window.location = '<?=base_url('/index.php/home/logout')?>';">logout</div>
		<? } else { ?>
			<div id="login_button" onclick="window.location = '<?=base_url('/index.php/home/login')?>';">login</div>
		<? } ?>
	</ul>
	
</div>

<div id="content">
