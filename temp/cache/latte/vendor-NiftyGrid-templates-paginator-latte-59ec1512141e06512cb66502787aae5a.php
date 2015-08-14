<?php
// source: /var/www/fakturace/vendor/NiftyGrid/../../templates/paginator.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('8342138616', 'html')
;
// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIMacros::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
if ($paginator->pageCount > 1) { ?>
<div class="grid-paginator">
<?php $iterations = 0; foreach (range($paginator->getBase(), $paginator->getPageCount()) as $page) { $iterations++; } if (!$paginator->isFirst()) { ?>
		<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this", array('page' => $paginator->getFirstPage())), ENT_COMPAT) ?>" class="grid-ajax">&lt;&lt;</a>
<?php } else { ?>
		<span>&lt;&lt;</span>
<?php } if ($paginator->getPage() - 1 >= $paginator->getFirstPage()) { ?>
		<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this", array('page' => $paginator->getPage() - 1)), ENT_COMPAT) ?>" class="grid-ajax">&lt;</a>
<?php } else { ?>
		<span>&lt;</span>
<?php } ?>
	<span class="grid-current" data-lastpage="<?php echo Latte\Runtime\Filters::escapeHtml($paginator->getLastPage(), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($paginator->getPage(), ENT_NOQUOTES) ?></span>
<?php if ($paginator->getPage() + 1 <= $paginator->getLastPage()) { ?>
		<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this", array('page' => $paginator->getPage() + 1)), ENT_COMPAT) ?>" class="grid-ajax">&gt;</a>
<?php } else { ?>
		<span>&gt;</span>
<?php } if (!$paginator->isLast()) { ?>
		<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this", array('page' => $paginator->getLastPage())), ENT_COMPAT) ?>" class="grid-ajax">&gt;&gt;</a>
<?php } else { ?>
		<span>&gt;&gt;</span>
<?php } ?>
</div>
<?php } 