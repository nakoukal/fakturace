<?php
// source: /var/www/fakturace/vendor/NiftyGrid/../../templates/grid.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('9118448399', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block _
//
if (!function_exists($_b->blocks['_'][] = '_lb11fbc0532f__')) { function _lb11fbc0532f__($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl(false, FALSE)
;if (!$control->isSubGrid) { echo Latte\Runtime\Filters::escapeHtml($control['gridForm']->render('begin'), ENT_NOQUOTES) ?>

<?php } ?>
<table class="grid"<?php echo Latte\Runtime\Filters::htmlAttributes(array('style' => $control->width ? 'width: '.$control->width.';' : NULL)) ?>>
	<thead>
<?php if ($control->gridName) { ?>		<tr>
			
		</tr>
<?php } ?>
		<tr class="grid-panel">
			<th colspan="<?php echo Latte\Runtime\Filters::escapeHtml($colsCount, ENT_COMPAT) ?>">
				<div class="grid-upper-panel">
					<div class="grid-name"><?php echo Latte\Runtime\Filters::escapeHtml($control->gridName, ENT_NOQUOTES) ?></div>
<?php if ($control->hasGlobalButtons()) { ?>					<div>
<?php $iterations = 0; foreach ($globalButtons as $globalButton) { if (is_object($globalButton)) $_l->tmp = $globalButton; else $_l->tmp = $_control->getComponent($globalButton); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;$iterations++; } ?>
					</div>
<?php } ?>
					<div class="grid-upper-info">
						<a class="grid-current-link" title="Získat odkaz na tuto stránku" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this"), ENT_COMPAT) ?>
"></a>
						<div class="grid-results">
							celkem <?php echo Latte\Runtime\Filters::escapeHtml($results, ENT_NOQUOTES) ?>
 <?php echo Latte\Runtime\Filters::escapeHtml(($results == 1) ? "záznam" : (($results >= 2 && $results <= 4) ? "záznamy" : "záznamů"), ENT_NOQUOTES) ;if ($paginate) { ?>
 <?php if ((boolean)$results) { ?>(Zobrazeno <?php echo Latte\Runtime\Filters::escapeHtml($viewedFrom, ENT_NOQUOTES) ?>
 až <?php echo Latte\Runtime\Filters::escapeHtml($viewedTo, ENT_NOQUOTES) ?>)<?php } } ?>

						</div>
					</div>
				</div>
			</th>
		</tr>
<?php $iterations = 0; foreach ($flashes as $flash) { ?>		<tr class="grid-flash <?php echo Latte\Runtime\Filters::escapeHtml($flash->type, ENT_COMPAT) ?>">
			<th colspan="<?php echo Latte\Runtime\Filters::escapeHtml($colsCount, ENT_COMPAT) ?>">
				<span><?php echo Latte\Runtime\Filters::escapeHtml($flash->message, ENT_NOQUOTES) ?></span>
				<div class="grid-flash-hide"></div>
			</th>
		</tr>
<?php $iterations++; } $iterations = 0; foreach ($control['gridForm']->errors as $error) { ?>		<tr class="grid-flash grid-error">
			<th colspan="<?php echo Latte\Runtime\Filters::escapeHtml($colsCount, ENT_COMPAT) ?>">
				<span><?php echo Latte\Runtime\Filters::escapeHtml($error, ENT_NOQUOTES) ?></span>
				<div class="grid-flash-hide"></div>
			</th>
		</tr>
<?php $iterations++; } ?>
		<tr>
<?php if ($control->hasActionForm()) { ?>			<th style="text-align:center; width: 16px;" class="grid-head-column"><input type="checkbox" class="grid-select-all" title="Označit/odznačit všechny záznamy"></th>
<?php } $iterations = 0; foreach ($subGrids as $subGrid) { ?>			<th style="width: 26px;" class="grid-head-column"></th>
<?php $iterations++; } $iterations = 0; foreach ($columns as $column) { ?>			<th class="grid-head-column"<?php echo Latte\Runtime\Filters::htmlAttributes(array('style' => $column->width ? 'width: '.$column->width.';' : NULL)) ?>
><?php if ($control->hasEnabledSorting() && $column->isSortable()) { $order = ($control->order == $column->name.' ASC') ? " DESC" : " ASC" ?>
<a class="grid-ajax" title="Obrátit řazení" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this", array('order' => $column->name.$order)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($column->label, ENT_NOQUOTES) ?></a><?php } else { echo Latte\Runtime\Filters::escapeHtml($column->label, ENT_NOQUOTES) ;} ?>

<?php if ($column->isSortable() && $control->hasEnabledSorting()) { ?>				<div class="grid-order">
					<a title="Řadit vzestupně" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this", array('order' => $column->name.' ASC')), ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('grid-ajax', 'grid-order-up' ,($control->order && ($control->order == $column->name.' ASC')) ? 'grid-order-active-up' : NULL))) echo ' class="' . Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>></a>
					<a title="Řadit sestupně" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this", array('order' => $column->name.' DESC')), ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('grid-ajax', 'grid-order-down' ,($control->order && ($control->order == $column->name.' DESC')) ? 'grid-order-active-down' : NULL))) echo ' class="' . Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>></a>
				</div>
<?php } ?>
			</th>
<?php $iterations++; } if ($control->hasButtons() || $control->hasFilterForm()) { ?>			<th class="grid-head-column">Akce</th>
<?php } ?>
		</tr>
<?php if ($control->hasFilterForm()) { ?>		<tr>
<?php if ($control->hasActionForm()) { ?>			<th class="grid-filter-form"></th>
<?php } $iterations = 0; foreach ($subGrids as $subGrid) { ?>			<th class="grid-filter-form"></th>
<?php $iterations++; } $iterations = 0; foreach ($columns as $column) { ?>			<th<?php echo Latte\Runtime\Filters::htmlAttributes(array('class' => array('grid-filter-form', $control->isSpecificFilterActive($column->name) ? 'grid-filter-form-active' : NULL))) ?>>
<?php if ($column->hasFilter()) { ?>
					<?php echo Latte\Runtime\Filters::escapeHtml($control['gridForm'][$control->name]['filter'][$column->name]->getControl(), ENT_NOQUOTES) ?>

<?php } ?>
			</th>
<?php $iterations++; } ?>
			<th class="grid-filter-form"><?php echo Latte\Runtime\Filters::escapeHtml($control['gridForm'][$control->name]['filter']['send']->getControl(), ENT_NOQUOTES) ;if ($control->hasActiveFilter()) { ?>
<a title="Zrušit filtr" class="grid-filter-reset grid-ajax" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this", array('filter' => NULL, 'paginator-page' => NULL)), ENT_COMPAT) ?>
"></a><?php } ?>
</th>
		</tr>
<?php } ?>
	</thead>
	<tbody>
<?php if ($control->showAddRow && $control->isEditable()) { ?>		<tr>
<?php if ($control->hasActionForm()) { ?>			<td class="grid-row-cell grid-edited-cell"></td>
<?php } if (count($subGrids)) { ?>			<td colspan="count($subGrids)" class="grid-row-cell grid-edited-cell"></td>
<?php } $iterations = 0; foreach ($columns as $column) { ?>			<td class="grid-row-cell grid-data-cell grid-edited-cell">
<?php if ($column->editable) { ?>
					<?php echo Latte\Runtime\Filters::escapeHtml($control['gridForm'][$control->name]['rowForm'][$column->name]->getControl(), ENT_NOQUOTES) ?>

<?php } ?>
			</td>
<?php $iterations++; } ?>
			<td class="grid-row-cell grid-edited-cell">
				<?php echo Latte\Runtime\Filters::escapeHtml($control['gridForm'][$control->name]['rowForm']['send']->getControl(), ENT_NOQUOTES) ?>

				<a class="grid-rowForm-cancel grid-ajax" title="Zrušit editaci" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this"), ENT_COMPAT) ?>
"></a>
			</td>
		</tr>
<?php } if (count($rows)) { $iterations = 0; foreach ($iterator = $_l->its[] = new Latte\Runtime\CachingIterator($rows) as $row) { ?>
		<tr<?php echo Latte\Runtime\Filters::htmlAttributes(array('class' => $iterator->isOdd() ? 'grid-row-odd' : 'grid-row-even')) ?>>
<?php if ($control->hasActionForm()) { ?>			<td<?php echo Latte\Runtime\Filters::htmlAttributes(array('class' => array('grid-row-cell', 'grid-action-checkbox', $control->isEditable() && $control->activeRowForm == $row[$primaryKey] ? 'grid-edited-cell' : NULL))) ?>
><?php echo Latte\Runtime\Filters::escapeHtml($control->assignCheckboxToRow($row[$primaryKey]), ENT_NOQUOTES) ?></td>
<?php } $iterations = 0; foreach ($subGrids as $subgrid) { ?>			<td<?php echo Latte\Runtime\Filters::htmlAttributes(array('class' => array('grid-row-cell', $control->isEditable() && $control->activeRowForm == $row[$primaryKey] ? 'grid-edited-cell' : NULL))) ?>>
<?php if (is_object($subgrid)) $_l->tmp = $subgrid; else $_l->tmp = $_control->getComponent($subgrid); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render($row) ?>
			</td>
<?php $iterations++; } $iterations = 0; foreach ($columns as $column) { ?>			<td<?php echo Latte\Runtime\Filters::htmlAttributes(array('class' => array('grid-row-cell', 'grid-data-cell', $control->isEditable() && $control->activeRowForm == $row[$primaryKey] ? 'grid-edited-cell' : NULL), 'style' => $column->hasCellRenderer() ? $column->getCellRenderer($row) : NULL)) ?>>
<?php if ($control->isEditable() && $column->editable && $control->activeRowForm == $row[$primaryKey]) { ?>
					<?php echo Latte\Runtime\Filters::escapeHtml($control['gridForm'][$control->name]['rowForm'][$column->name]->getControl(), ENT_NOQUOTES) ?>

<?php } else { ?>
					<?php echo Latte\Runtime\Filters::escapeHtml($column->prepareValue($row), ENT_NOQUOTES) ?>

<?php } ?>
			</td>
<?php $iterations++; } if ($control->hasButtons() || $control->hasFilterForm()) { ?>
			<td<?php echo Latte\Runtime\Filters::htmlAttributes(array('class' => array('grid-row-cell', $control->isEditable() && $control->activeRowForm == $row[$primaryKey] ? 'grid-edited-cell' : NULL))) ?>>
<?php if ($control->activeRowForm == $row[$primaryKey] && $control->isEditable()) { ?>
					<?php echo Latte\Runtime\Filters::escapeHtml($control['gridForm'][$control->name]['rowForm']['send']->getControl(), ENT_NOQUOTES) ?>

					<a class="grid-rowForm-cancel grid-ajax" title="Zrušit editaci" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this"), ENT_COMPAT) ?>
"></a>
					<?php echo Latte\Runtime\Filters::escapeHtml($control['gridForm'][$control->name]['rowForm'][$primaryKey]->getControl(), ENT_NOQUOTES) ?>

<?php } else { $iterations = 0; foreach ($buttons as $button) { if (is_object($button)) $_l->tmp = $button; else $_l->tmp = $_control->getComponent($button); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render($row) ;$iterations++; } } ?>
			</td>
<?php } ?>
		</tr>
<?php if ($control->hasActiveSubGrid() && $control->activeSubGridId == $row[$primaryKey]) { ?>		<tr class="grid-subgrid-row" align="center">
			<td colspan="<?php echo Latte\Runtime\Filters::escapeHtml($colsCount, ENT_COMPAT) ?>
"<?php echo Latte\Runtime\Filters::htmlAttributes(array('style' => $control['subGrids-'.$control->activeSubGridName]->hasCellStyle() ? $control['subGrids-'.$control->activeSubGridName]->getCellStyle().'border-bottom:1px solid #f2f2f2;' : NULL)) ?>>
<?php if (is_object($control['subGrid'.$control->activeSubGridName])) $_l->tmp = $control['subGrid'.$control->activeSubGridName]; else $_l->tmp = $_control->getComponent($control['subGrid'.$control->activeSubGridName]); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
			</td>
		</tr>
<?php } $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ;} else { ?>
		<tr>
			<td class="grid-row-cell" style="background-color:#FFF; font-size:16px;" colspan="<?php echo Latte\Runtime\Filters::escapeHtml($colsCount, ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($control->messageNoRecords, ENT_NOQUOTES) ?></td>
		</tr>
<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="<?php echo Latte\Runtime\Filters::escapeHtml($colsCount, ENT_COMPAT) ?>" class="grid-bottom">
<?php if ($export) { ?>				<span class="grid-paginator" style="float: left;">					
					<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("export"), ENT_COMPAT) ?>
">EXPORT CSV</a>
				</span>
<?php } if ($control->hasActionForm()) { ?>				<span class="grid-action-box">
						<?php echo Latte\Runtime\Filters::escapeHtml($control['gridForm'][$control->name]['action']['action_name']->label, ENT_NOQUOTES) ?>

						<?php echo Latte\Runtime\Filters::escapeHtml($control['gridForm'][$control->name]['action']['action_name']->getControl(), ENT_NOQUOTES) ?>

						<?php echo Latte\Runtime\Filters::escapeHtml($control['gridForm'][$control->name]['action']['send']->getControl(), ENT_NOQUOTES) ?>

				</span>
<?php } if ($paginate) { ?>				<span class="grid-perPage">
						<?php echo Latte\Runtime\Filters::escapeHtml($control['gridForm'][$control->name]['perPage']['perPage']->label, ENT_NOQUOTES) ?>

						<?php echo Latte\Runtime\Filters::escapeHtml($control['gridForm'][$control->name]['perPage']['perPage']->getControl(), ENT_NOQUOTES) ?>

						<?php echo Latte\Runtime\Filters::escapeHtml($control['gridForm'][$control->name]['perPage']['send']->getControl(), ENT_NOQUOTES) ?>

				</span>
<?php } ?>
			</td>
		</tr>
<?php if ($paginate) { ?>		<tr class="grid-panel">
			<td colspan="<?php echo Latte\Runtime\Filters::escapeHtml($colsCount, ENT_COMPAT) ?>">
<?php $_l->tmp = $_control->getComponent("paginator"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
			</td>
		</tr>
<?php } ?>
	</tfoot>
</table>
<?php if (!$control->isSubGrid) { echo Latte\Runtime\Filters::escapeHtml($control['gridForm']->render('end'), ENT_NOQUOTES) ?>

<?php } 
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
if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); } ?>
<div id="<?php echo $_control->getSnippetId('') ?>"><?php call_user_func(reset($_b->blocks['_']), $_b, $template->getParameters()) ?>
</div>
