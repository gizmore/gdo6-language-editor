<?php
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;

$bar = GDT_Bar::make()->horizontal();
$bar->addFields([
	GDT_Link::make('link_edit')->href(href('LanguageEditor', 'Edit')),
	GDT_Link::make('link_csv_upload')->href(href('LanguageEditor', 'CSVUpload')),
	GDT_Link::make('link_generate')->href(href('LanguageEditor', 'Generate')),
]);

echo $bar->render();