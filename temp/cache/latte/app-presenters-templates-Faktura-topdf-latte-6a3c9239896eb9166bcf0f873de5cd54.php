<?php
// source: /var/www/fakturace/app/presenters/../templates/Faktura/topdf.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('8391668829', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb6efca9a794_content')) { function _lb6efca9a794_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><i>Dne: <?php echo Latte\Runtime\Filters::escapeHtml($today, ENT_NOQUOTES) ?></i>
<br><br>
<div class="head">Vyúčtování pro <?php echo Latte\Runtime\Filters::escapeHtml($faktura->firma->Nazev, ENT_NOQUOTES) ?></div>
<br>
<div class="pdfprint">
<table>
	<thead>
		<tr>
			<th>Datum</th>
			<th>Druh práce</th>
			<th>Popis práce</th>
			<th>Délka</th>
			<th>Cena</th>
		</tr>
	</thead>
<?php $iterations = 0; foreach ($works as $work) { ?>	<tr>
		<td><?php echo Latte\Runtime\Filters::escapeHtml($work->Datum, ENT_NOQUOTES) ?></td>
		<td><?php echo Latte\Runtime\Filters::escapeHtml($work->typ->Typ, ENT_NOQUOTES) ?></td>
		<td><?php echo Latte\Runtime\Filters::escapeHtml($work->Popis, ENT_NOQUOTES) ?></td>
<?php if ($work->TypID == 1) { ?>		<td><?php echo Latte\Runtime\Filters::escapeHtml($work->Delka, ENT_NOQUOTES) ?> km.</td>
<?php } if ($work->TypID != 1) { ?>		<td><?php echo Latte\Runtime\Filters::escapeHtml($work->Delka, ENT_NOQUOTES) ?> hod.</td>
<?php } ?>
		<td><?php echo Latte\Runtime\Filters::escapeHtml($work->Cena, ENT_NOQUOTES) ?> Kč</td>
	</tr>
<?php $iterations++; } ?>
	<tr>
		<th colspan="5" align="right">Cena celkem <?php echo Latte\Runtime\Filters::escapeHtml($faktura->Cena, ENT_NOQUOTES) ?> Kč.</th>
	</tr>
</table>
</div><?php
}}

//
// end of blocks
//

// template extending

$_l->extends = '../@pdf.layout.latte'; $_g->extended = TRUE;

if ($_l->extends) { ob_start();}

// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIMacros::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
 if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 