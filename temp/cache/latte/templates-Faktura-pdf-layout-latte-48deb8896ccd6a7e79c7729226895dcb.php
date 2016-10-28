<?php
// source: /var/www/fakturace/app/presenters/../templates/Faktura/../@pdf.layout.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('2980078162', 'html')
;
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
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Language" content="en">
    <meta name="description" content="MyApplication">
<?php if (isset($robots)) { ?>    <meta name="robots" content="<?php echo Latte\Runtime\Filters::escapeHtml($robots, ENT_COMPAT) ?>">
<?php } ?>
    <link rel="stylesheet" media="print" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/print.css" type="text/css">
</head>
<body>
    <div id="content">
<?php Latte\Macros\BlockMacros::callBlock($_b, 'content', $template->getParameters()) ?>
    </div>
</body>
</html>