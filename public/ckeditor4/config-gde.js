/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.stylesSet.add( 'gde_styles', [
	// Inline styles
	{ name: 'Táblázat (csíkos)', element: 'table', attributes: { 'class': 'table table-striped' } },
	{ name: 'Kék kiemelés - információ', element: 'div', attributes: { 'class': 'alert alert-info py-2' } },
	{ name: 'Piros kiemelés - hiba/felhívás', element: 'div', attributes: { 'class': 'alert alert-danger py-2' } },
	{ name: 'Zöld kiemelés', element: 'div', attributes: { 'class': 'alert alert-success py-2' } },
	{ name: 'Narancs kiemelés', element: 'div', attributes: { 'class': 'alert alert-warning py-2' } }
] );



CKEDITOR.editorConfig = function( config ) {
	config.ImageBrowser = true ;
	config.ImageBrowserURL = '/admin/filemanager_overlay/index.php' ;
	config.extraAllowedContent = 'div(*);iframe(*)[*]{*};';
	config.extraPlugins = 'oldalak,dokumentumok';
	config.allowedContent = true;	
	//config.language = 'en';
	https://gdeportal.max.hu/admin/ckeditor4/lang/en.js?t=L4KA
	config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'editing' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'align',  'paragraph' ] },
		{ name: 'styles', groups: [ 'styles' ] },
        { name:'gde' }
	];
	
	config.removeButtons = 'Underline,Subscript,Superscript,Flash,SpecialChar,PageBreak,Iframe,Save,NewPage,Preview,Print,Templates,Blockquote,BidiLtr,BidiRtl,Language,Smiley,Font,FontSize';	
	config.format_tags = 'p;h1;h2;h3;pre';

	//config.removeDialogTabs = 'image:advanced;link:advanced';
	config.height = '30em';
	config.stylesSet = 'gde_styles';	
};
