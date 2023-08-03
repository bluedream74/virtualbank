
(function($) {

    'use strict';

    var InvoiceCSV = {

        options: {

            table: '#invoiceCSV_datatable',                    // main panels
            dialog: {                                               // confirm dialog for delete a service
                wrapper: '#dialog',
                cancelButton: '#dialogCancel',
                confirmButton: '#dialogConfirm'
            }
        },

        initialize: function() {
            this
                .setVars()
                .build()
                .events();
        },

        setVars: function() {
            this.$table				= $( this.options.table );

            // dialog
            this.dialog				= {};
            this.dialog.$wrapper	= $( this.options.dialog.wrapper );
            this.dialog.$cancel		= $( this.options.dialog.cancelButton );
            this.dialog.$confirm	= $( this.options.dialog.confirmButton );

            return this;
        },

        build: function() {
            this.datatable = this.$table.DataTable({
                aoColumns: [ { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }],
                order: [],
                pageLength: $('#pagelen').val()
            });

            window.dt = this.datatable;
            return this;
        },

        events: function() {
            var _self = this;
            return this;
        },

        // ==========================================================================================
        // delete
        // ==========================================================================================

        delete: function(delete_url) {

            // delete Media
            $.ajax({
                url: delete_url,
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    if(data.success){
                        window.location.reload();
                    }
                },
                error : function(data){}
            });
        }
    };

    // ==========================================================================================
    // Initialize
    // ==========================================================================================

    $(function() {
        InvoiceCSV.initialize();
    });

}).apply(this, [jQuery]);