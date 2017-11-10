$(function() {


	//===== Hide/show sidebar =====//

	$('.fullview').click(function(){
	    $("body").toggleClass("clean");
	    $('#sidebar').toggleClass("hide-sidebar mobile-sidebar");
	    $('#content').toggleClass("full-content");
	});



	//===== Hide/show action tabs =====//

	$('.showmenu').click(function () {
		$('.actions-wrapper').slideToggle(100);
	});



	//===== Easy tabs =====//
	
	$('.sidebar-tabs').easytabs({
		animationSpeed: 150,
		collapsible: false,
		tabActiveClass: "active"
	});

	$('.actions').easytabs({
		animationSpeed: 300,
		collapsible: false,
		tabActiveClass: "current"
	});



	//===== Collapsible plugin for main nav =====//
	
	$('.expand').collapsible({
		defaultOpen: 'current,third',
		cookieName: 'navAct',
		cssOpen: 'subOpened',
		cssClose: 'subClosed',
		speed: 200
	});



    //===== Make code pretty =====//

    window.prettyPrint && prettyPrint();



    //===== Validation engine =====//
    // TODO: Change to a generic ID & update Form object
    //$("#user-form").validationEngine({promptPosition : "topRight:-122,-5"});
    //$("#layout-form").validationEngine({promptPosition : "topRight:-122,-5"});



    //===== Datatables =====//

    oTable = $('#data-table').dataTable({
        "bJQueryUI": false,
        "bAutoWidth": false,
        "bStateSave": true,
        "sPaginationType": "full_numbers",
        "sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
        "aoColumnDefs": [{
            "bSortable": false,
            "sWidth": "200px",
            "aTargets": [ "actnCol" ] }],
        "oLanguage": {
            "sSearch": "<span>Filter records:</span> _INPUT_",
            "sLengthMenu": "<span>Show entries:</span> _MENU_",
            "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
        }
    });

    // vehicles table
    oTable2 = $('#data-table-vehicles').dataTable({
        'bServerSide' : true,
        'bProcessing' : true,
        'sAjaxSource' : '/admin/products/vehicles',
        "bJQueryUI": false,
        "bAutoWidth": false,
        "bStateSave": true,
        "sPaginationType": "full_numbers",
        "sDom": '<"datatable-header"fl>rt<"datatable-footer"ip>',
        "aoColumnDefs": [
            { 'sTitle' : 'Year', 'aTargets': [0] },
            { 'sTitle' : 'Make', 'aTargets': [1] },
            { 'sTitle' : 'Model', 'aTargets': [2] },
            { 'sTitle' : 'Submodel', 'aTargets': [3] },
            { 'mRender' : function (data, type, full) {
                // have to append to a temp div to get innerHTML
                var returnHtml = $('<div />').append($('<ul class="table-controls"></ul>').append(
                                    $('<li></li>').append(
                                        $('<a href=""></a>').addClass('btn')
                                                            .addClass('tip')
                                                            .attr('title', 'View Parts')
                                                            .attr('href', '/admin/products/vehicles/parts/' + data)
                                                            .html('<i class="icon-external-link"></i> view associated parts')
                                        )
                                  ));

                return returnHtml.html();
            }, 'aTargets' : [4]},
        ],
        "oLanguage": {
            "sProcessing" : '<div class="loading"><span>Loading data</span><img src="/assets/rocket-admin/images/elements/loaders/6s.gif" /></div>',
            "sSearch": "<span>Filter records:</span> _INPUT_",
            "sLengthMenu": "<span>Show entries:</span> _MENU_",
            "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
        }
    });

    // parts table
    oTable3 = $('#data-table-parts').dataTable({
        'bServerSide' : true,
        'bProcessing' : true,
        'sAjaxSource' : '/admin/products/parts',
        "bJQueryUI": false,
        "bAutoWidth": false,
        "bStateSave": true,
        "sPaginationType": "full_numbers",
        "sDom": '<"datatable-header"fl>rt<"datatable-footer"ip>',
        "aoColumnDefs": [
            { 'sTitle' : 'Part Number', 'aTargets': [0] },
            { 'sTitle' : 'UPC Code', 'aTargets': [1] },
            { 'sTitle' : 'Product Line', 'aTargets': [2], 'mRender' : function (data, type, full) {
                var returnHtml = $('<div />').append(
                    $('<a href="/admin/products/productlines/view/' + data.id + '"></a>').addClass('btn')
                                                                                         .addClass('btn-primary')
                                                                                         .addClass('tip')
                                                                                         .attr('title', data.name)
                                                                                         .append(
                        $('<i class="icon-external-link"></i>')
                    ).append(
                        $('<span></span>').attr('style', 'margin-left: 5px;')
                                          .html(data.name)
                    )
                );

                return returnHtml.html();
            }},
            { 'sTitle' : 'Color', 'aTargets': [3] },
            { 'sTitle' : 'MSRP', 'aTargets': [4] },
            { 'sTitle' : 'I-Sheet', 'aTargets': [5], 'mRender' : function (data, type, full) {
                if (data.isheet != null) {
                if (data.isheet.length > 0) {
                var returnHtml = $('<div />').append(
                    $('<a href="/assets/library/products/isheets/' + data.isheet + '.pdf" target="_blank"></a>').addClass('btn')
                                                                                         .addClass('btn-primary')
                                                                                         .addClass('tip')
                                                                                         .attr('title', data.isheet)
                                                                                         .append(
                        $('<i class="icon-external-link"></i>')
                    ).append(
                        $('<span></span>').attr('style', 'margin-left: 5px;')
                                          .html(data.isheet)
                    )
                );

                return returnHtml.html();
                } else {
                    return '';
                }
                } else {
                    return '';
                }
            }},
            { 'mRender' : function (data, type, full) {
                // have to append to a temp div to get innerHTML
                var returnHtml = $('<div />').append($('<ul class="table-controls"></ul>').append(
                                    $('<li></li>').append(
                                        $('<a href=""></a>').addClass('btn')
                                                            .addClass('tip')
                                                            .attr('title', 'View Record')
                                                            .attr('href', '/admin/products/parts/view/' + data)
                                                            .html('<i class="icon-external-link"></i> view')
                                    )
                                  ));

                return returnHtml.html();
            }, 'aTargets' : [6]},
        ],
        "oLanguage": {
            "sProcessing" : '<div class="loading"><span>Loading data</span><img src="/assets/rocket-admin/images/elements/loaders/6s.gif" /></div>',
            "sSearch": "<span>Filter records:</span> _INPUT_",
            "sLengthMenu": "<span>Show entries:</span> _MENU_",
            "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
        }
    });

    oTable4 = $('#data-table-retailers').dataTable({
        'bServerSide' : true,
        'bProcessing' : true,
        'sAjaxSource' : '/admin/accounts/retailer',
        "bJQueryUI": false,
        "bAutoWidth": false,
        "bStateSave": true,
        "sPaginationType": "full_numbers",
        "sDom": '<"datatable-header"fl>rt<"datatable-footer"ip>',
        "aoColumnDefs": [
            { 'sTitle' : 'Company Name', 'aTargets': [0] },
            { 'sTitle' : 'Retailer Type', 'aTargets': [1] },
            { 'sTitle' : 'Address', 'aTargets': [2] },
            { 'sTitle' : 'Phone Number', 'aTargets': [3] },
            { 'mRender' : function (data, type, full) {
                var returnHtml = $('<div />').append($('<ul class="table-controls"></ul>').append(
                                    $('<li></li>').append(
                                        $('<a href=""></a>').addClass('btn')
                                                            .addClass('tip')
                                                            .attr('title', 'Edit Record')
                                                            .attr('href', '/admin/accounts/retailer/edit/' + data)
                                                            .html('<i class="icon-edit"></i> edit')
                                    ),
                                    $('<li></li>').append(
                                        $('<a href=""></a>').addClass('btn')
                                                            .addClass('tip')
                                                            .attr('title', 'View Record')
                                                            .attr('href', '/admin/accounts/retailer/view/' + data)
                                                            .html('<i class="icon-external-link"></i> view')
                                    ),
                                    $('<li></li>').append(
                                        $('<a href=""></a>').addClass('btn')
                                                            .addClass('tip')
                                                            .attr('title', 'Delete Record')
                                                            .attr('href', '/admin/accounts/retailer/delete/' + data)
                                                            .html('<i class="icon-trash"></i> delete')
                                    )
                                  ));

                return returnHtml.html();
            }, 'aTargets' : [4]},
        ],
        "oLanguage": {
            "sProcessing" : '<div class="loading"><span>Loading data</span><img src="/assets/rocket-admin/images/elements/loaders/6s.gif" /></div>',
            "sSearch": "<span>Filter records:</span> _INPUT_",
            "sLengthMenu": "<span>Show entries:</span> _MENU_",
            "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
        }
    });

    oTable5 = $('#data-table-product-reviews').dataTable({
        'bServerSide' : true,
        'bProcessing' : true,
        'sAjaxSource' : '/admin/products/productreviews',
        "bJQueryUI": false,
        "bAutoWidth": false,
        "bStateSave": true,
        "sPaginationType": "full_numbers",
        "sDom": '<"datatable-header"fl>rt<"datatable-footer"ip>',
        "aoColumns": [{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"10%"},{"sWidth":"30%"},{"sWidth":"10%"},{"sWidth":"10%"}],
        "aoColumnDefs": [
            { 'sTitle' : 'Created', 'aTargets': [0] },
            { 'sTitle' : 'Product Line', 'aTargets': [1], 'mRender' : function (data, type, full) {
                var returnHtml = $('<div />').append(
                    $('<a href="/admin/products/productlines/view/' + data.id + '"></a>').addClass('btn')
                                                                                         .addClass('btn-primary')
                                                                                         .addClass('tip')
                                                                                         .attr('title', data.name)
                                                                                         .append(
                        $('<i class="icon-external-link"></i>')
                    ).append(
                        $('<span></span>').attr('style', 'margin-left: 5px;')
                                          .html(data.name)
                    )
                );

                return returnHtml.html();
            }},
            { 'sTitle' : 'User', 'aTargets': [2] },
            { 'sTitle' : 'Rating', 'aTargets': [3] },
            { 'sTitle' : 'Review', 'aTargets': [4] },
            { 'sTitle' : 'Status', 'aTargets': [5], 'mRender' : function (data, type, full) {
                if (data.disabled == 'Yes') {
                    var returnHtml = $('<div />').append(
                        $('<a href="/admin/products/productreviews/approve/' + data.id + '"></a>').addClass('btn')
                            .addClass('tip')
                            .addClass('btn-success')
                            .attr('title', 'Approve Review')
                            .html('<i class="icon-check"></i> approve'));
                } else if (data.disabled == 'No') {
                    var returnHtml = $('<div />').append(
                        $('<p></p>').html('<strong>approved</strong>'));
                }
                return returnHtml.html();
            }},
            { 'mRender' : function (data, type, full) {
                var returnHtml = $('<div />').append($('<ul class="table-controls"></ul>').append(
                                    $('<li></li>').append(
                                        $('<a href=""></a>').addClass('btn')
                                                            .addClass('tip')
                                                            .attr('title', 'Edit Record')
                                                            .attr('href', '/admin/products/productreviews/edit/' + data)
                                                            .html('<i class="icon-edit"></i> edit')
                                    ),
                                    $('<li></li>').append(
                                        $('<a href=""></a>').addClass('btn')
                                                            .addClass('tip')
                                                            .attr('title', 'Delete Record')
                                                            .attr('href', '/admin/products/productreviews/delete/' + data)
                                                            .html('<i class="icon-trash"></i> delete')
                                    )
                                  ));

                return returnHtml.html();
            }, 'aTargets' : [6]},
        ],
        "oLanguage": {
            "sProcessing" : '<div class="loading"><span>Loading data</span><img src="/assets/rocket-admin/images/elements/loaders/6s.gif" /></div>',
            "sSearch": "<span>Filter records:</span> _INPUT_",
            "sLengthMenu": "<span>Show entries:</span> _MENU_",
            "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
        }
    });

    //===== Form elements styling =====//

    $(".ui-datepicker-month, .styled, .dataTables_length select").uniform({ radioClass: 'choice' });



    //===== Select2 dropdowns =====//

    //$(".select").select2({width:'200px'});
    $(".select").select2();



    //===== Form Cancel Button =====//

    $('#form-cancel-btn').click(function(e){
        e.preventDefault();
        history.back(1);
    });



    //===== Tooltips =====//

    $('.tip').tooltip();



    //===== Modals and dialogs =====//

    $("a.confirm").click(function(e) {
        e.preventDefault();
        var location = $(this).attr('href');
        bootbox.confirm("Are you sure you want to delete this record?", function(confirmed) {
            if (confirmed) {
                window.location.replace(location);
            }
        });
    });

    //===== Fix twitter bootstrap issue with elfinder resize buttons =====//
    var btn = $.fn.button.noConflict(); // reverts $.fn.button to jqueryui btn
    $.fn.btn = btn; // assigns bootstrap button functionality to $.fn.btn
});
