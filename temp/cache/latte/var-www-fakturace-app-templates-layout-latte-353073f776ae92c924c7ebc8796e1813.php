<?php
// source: /var/www/fakturace/app/templates/@layout.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('3868934212', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block head
//
if (!function_exists($_b->blocks['head'][] = '_lbc31fa7848c_head')) { function _lbc31fa7848c_head($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<meta charset="utf-8">

	<title><?php if (isset($_b->blocks["title"])) { ob_start(); Latte\Macros\BlockMacros::callBlock($_b, 'title', $template->getParameters()); echo $template->striptags(ob_get_clean()) ?>
 | <?php } ?>Nette Sandbox</title>

	<link rel="stylesheet" media="screen,projection,tv" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/screen.css">
	<link rel="stylesheet" media="print" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/print.css">
	<link rel="stylesheet" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/multiple_load.php?phase=css_main&amp;version=1">
	<link rel="shortcut icon" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/favicon.ico">
<?php call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars()) ; 
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb084a55ef04_scripts')) { function _lb084a55ef04_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>		<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/multiple_load.php?phase=js_main&amp;version=1" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(function()
		{
			$('input.datetimepicker').datetimepicker(
			{
				lang:'cs',
				format:'d.m.Y H:i',
				validateOnBlur: false
			});
		});
		</script>
<?php
}}

//
// end of blocks
//

// template extending

$_l->extends = empty($_g->extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $_g->extended = TRUE;

if ($_l->extends) { ob_start();}

// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIMacros::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
?>
<!DOCTYPE html>
<html>
<head>
<?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['head']), $_b, get_defined_vars())  ?>
</head>

<body>
	<script> document.documentElement.className+=' js' </script>
	<div id="wrapper">
        <ul class="menu">
			<li class="home current"><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Faktura:default"), ENT_COMPAT) ?>
"></a></li>
			<li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Faktura:default"), ENT_COMPAT) ?>
"><span>FAKTURACE</span></a>
			<li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Firma:default"), ENT_COMPAT) ?>
"><span>FIRMA</span></a>
			<li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Prace:default"), ENT_COMPAT) ?>
"><span>PRACE</span></a>
			<li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("#"), ENT_COMPAT) ?>
"><span>TYP</span></a>
		  </li>
        </ul>
	</div>
<?php $iterations = 0; foreach ($flashes as $flash) { ?>	<div class="flash <?php echo Latte\Runtime\Filters::escapeHtml($flash->type, ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; } ?>
	
	
<?php Latte\Macros\BlockMacros::callBlock($_b, 'content', $template->getParameters()) ?>
</body>
</html>
