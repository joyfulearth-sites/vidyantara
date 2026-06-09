<?php
variables([
	'sections-have-files' => true,
	'no-page-menu' => true,
	'no-seo-info' => true,
	'no-search' => true,
	'salutation' => 'VidyAntara folks',
	'social' => [
		//[ 'type' => 'linkedin', 'url' => 'https://www.linkedin.com/in/vidya-shankar-1453ab49/', 'name' => 'Vidya' ],
	],
	'footer-variation' => 'no-widget',
	'no-footer-alt-design' => true,
	'quotes-display-count' => 5,
]);

if (nodeIs(SITEHOME)) {
	includeThemeManager();
	CanvasTheme::addAssets(CanvasTheme::spa);
}

function after_menu() {
	_headerMenuItem(replaceHtml('<img src="%site-assets%relief-foundation-icon.png" height="40" />'), 'https://relieffoundation.in/', true);
}

function after_file() {
	if (nodeIsOneOf(['being-at-vidyantara'])) return;
	contentBox('visiting-us', 'container');
	echo getSnippet('visiting-us');
	contentBox('end');
}

function enrichThemeVars($vars, $what) {
	if ($what == 'header' && nodeIs(SITEHOME)) {
		$sheet = getSheet('slider', false);
		$items = [];
		foreach ($sheet->rows as $row)
			$items[$row[0]] = renderSingleLineMarkdown($sheet->getValue($row, 'value'), ['echo' => false]);
		$vars['optional-slider'] = replaceHtml(replaceItems(getSnippet('spa-slider'), $items, '%'));
	}

	return $vars;
}

function after_footer_assets() {
	if (nodeIs(SITEHOME))
		echo getSnippet('slider-footer');

	//echo getThemeSnippet('floating-button');
}

function site_before_render() {
	runFeature('engage'); //needed for floating button
	variable('htmlReplaces', [
		'Vidya' => '<span class="h5 cursive">Vidya Shankar Chakravarthy</span>',
		'VidyAntara' => '<span class="h5 cursive">' . variable('name') . '</span>',
		'REFLECT' => '<span class="h5 cursive">REFLECT</span>',
		'Vision' => (nodeIs(SITEHOME) ? 'we ' : 'We' ) . ' aspire to create the best <span class="h5 cursive">rural home-stay</span> in South India with a <span class="h5 cursive">spiritual ambience</span> that fosters pluralism.',
		'Mission' => 'At <span class="h5 cursive">VidyAntara Family Retreat</span>, our aim is to provide a <b>peaceful and nurturing environment</b>.',
	]);

	if (hasPageParameter('slider'))
		variable('sub-theme', 'slider-only');

	if (variable('node') == 'food')
		variable('skip-container-for-this-page', true);
}

function before_file() {
	if (nodeIs('gallery'))
		echo '<div class="mt-5"></div>' . NEWLINES2;
}
