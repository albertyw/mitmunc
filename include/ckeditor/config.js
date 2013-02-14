/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.toolbar = 'SelectiveToolbar';
    config.toolbar_SelectiveToolbar =
	[
        { name: 'document', items : [ 'Source','-','Print' ] },
        { name: 'editing', items : [ 'Undo','Redo','-','Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
        { name: 'tools', items : [ 'Maximize','-','About' ] },
        '/',
        { name: 'styles', items : [ 'FontSize'] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
        { name: 'links', items : [ 'Link','Unlink' ] },
        { name: 'insert', items : [ 'Image','Table','HorizontalRule','SpecialChar' ] },
        { name: 'colors', items : [ 'TextColor','BGColor' ] },
        
	];
};
