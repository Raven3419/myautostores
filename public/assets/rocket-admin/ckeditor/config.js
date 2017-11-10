/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.height = 400;
    config.toolbar = 'Full';
    config.toolbar_Full =
    [
        { name: 'document',    items : [ 'Source','-','Preview','-','Templates' ] },
        { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
        { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        '/',
        { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
        { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
        { name: 'insert',      items : [ 'Image','Table','HorizontalRule','SpecialChar','PageBreak' ] },
        '/',
        { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
        { name: 'colors',      items : [ 'TextColor','BGColor' ] },
        { name: 'tools',       items : [ 'Maximize','ShowBlocks' ] }
    ];
	config.toolbarCanCollapse = true;
	config.language = 'en';
	config.menu_groups = 'clipboard,table,anchor,link,image';
	config.uiColor = '#f2f2f2';
};

function getUrlParam(paramName) {
    var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
    var match = window.location.search.match(reParam) ;
    return (match && match.length > 1) ? match[1] : '' ;
}

CKEDITOR.on('dialogDefinition', function(event) {
    var editor = event.editor;
    var dialogDefinition = event.data.definition;
    var dialogName = event.data.name;

    var tabCount = dialogDefinition.contents.length;
    for(var i = 0; i < tabCount; i++) {
        var browseButton = dialogDefinition.contents[i].get('browse');
        if (browseButton !== null) {
            browseButton.hidden = false;
            browseButton.onClick = function(dialog, i) {
                $('<div \>').dialog({modal:true,width:"80%",title:'elFinder',zIndex: 99999,
                    create: function(event, ui) {
                        var funcNum = getUrlParam('CKEditorFuncNum');
                        $(this).elfinder({
                            resizable:false,
                            url : '/admin/dam/connector',
                            getFileCallback : function(file) {
                                if($('input#cke_91_textInput').is(':visible')){
                                    $('input#cke_91_textInput').val(file.url);
                                } else {
                                    $('input#cke_129_textInput').val(file.url);
                                }
                                $('a.ui-dialog-titlebar-close[role="button"]').click()
                            }
                        }).elfinder('instance')
                    }
                })
            }
        }
    }
});
