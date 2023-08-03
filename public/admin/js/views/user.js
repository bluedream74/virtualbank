
(function($) {

    'use strict';

    var User = {

        options: {

            table: '#user_datatable',                  // main panels
            dialog: {                                       // confirm dialog for delete a service
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
                aoColumns: [ null, null, null,null, null, null, null,null, { "bSortable": false }],
                order: [],
                pageLength: $('#pagelen').val()
            });

            window.dt = this.datatable;
            return this;
        },

        events: function() {
            var _self = this;
            this.$table

                // delete company
                .on( 'click', 'a.remove-row', function( e ) {

                    e.preventDefault();
                    var delete_url = $(this).data('url');

                    // show confirm popup
                    $.magnificPopup.open({
                        items: {
                            src: _self.options.dialog.wrapper,
                            type: 'inline'
                        },
                        preloader: false,
                        modal: true,
                        callbacks: {
                            change: function() {
                                _self.dialog.$confirm.on( 'click', function( e ) {

                                    e.preventDefault();
                                    $.magnificPopup.close();
                                    _self.delete(delete_url);
                                });

                                _self.dialog.$cancel.on( 'click', function( e ) {
                                    e.preventDefault();
                                    $.magnificPopup.close();
                                });
                            },
                            close: function() {
                                _self.dialog.$confirm.off( 'click' );
                            }
                        }
                    });
                });

            return this;
        },

        // ==========================================================================================
        // delete
        // ==========================================================================================

        delete: function(delete_url) {

            // delete
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
        User.initialize();
    });

}).apply(this, [jQuery]);