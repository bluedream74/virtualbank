
(function($) {


    // Image Manager
    $(document).delegate('a[data-toggle=\'image\']', 'click', function(e) {
        e.preventDefault();

        var element = this;

        $(element).popover({
            html: true,
            placement: 'right',
            trigger: 'manual',
            content: function() {
                return '<button type="button" id="button-image" class="btn btn-success"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
            }
        });

        $(element).popover('toggle');

        $('#button-image').on('click', function() {
            $(element).popover('hide');
            $(element).parent().find('input').click();
        });

        $('#button-clear').on('click', function() {
            $(element).find('img').attr('src', $(element).find('img').attr('data-placeholder'));
            $(element).parent().find('input').attr('value', '');
            $(element).popover('hide');
        });
    });

    // image upload
    jQuery(document).on('change', '.upload_button', function (e) {

        // get information from image file
        var oFile = jQuery(this)[0].files[0];

        /* check for image type (jpg and png are allowed) */
        var rFilter = /^(image\/jpeg|image\/png|image\/gif)$/i;
        if (!rFilter.test(oFile.type)) {
            jQuery('.error_image').addClass('error');
            jQuery('.error_image').html(errorobj_please_select_a_valid_image_file_jpg_and_png_are_allowed).show();
            return;
        }

        /*  check for file size  */
        var file = this.files[0];
        var fileType = file["type"];
        var ValidImageTypes = ["image/jpeg", "image/png", "image/gif"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            jQuery('.error_image').addClass('error');
            jQuery('.error_image').html(errorobj_only_jpeg_png_and_gif_images_allowed);
            return;
        }
        var file_size = $(this)[0].files[0].size;
        var maxfilesize = 1048576 * 2;
        /*  Here 2 repersent MB  */
        if (file_size >= maxfilesize) {
            jQuery('.error_image').addClass('error');
            jQuery('.error_image').html(errorobj_maximum_file_upload_size_2_mb);
            return;
        }
        var file_size = $(this)[0].files[0].size;
        var minfilesize = 1048576 * 0.0005;

        /*  Here 5 repersent KB  */
        if (file_size <= minfilesize) {
            jQuery('.error_image').addClass('error');
            jQuery('.error_image').html(errorobj_minimum_file_upload_size_1_kb);
            return;
        }

        // image information
        var imgObj_url =  '/feks/public/customer/img/';
        var upload_path = $(this).data('path');
        var img_name = $(this).data('name');

        // object
        var obj_imageView = $(this).prev().find('img');
        var obj_inputView = $(this).next();

        /* prepare HTML5 FileReader & image size*/
        var oImage = document.getElementById('preview_img');
        var oReader = new FileReader();
        oReader.onload = function (e) {
            oImage.src = e.target.result;
            oImage.onload = function () { /* onload event handler */

                // form data
                var formdata = new FormData();
                formdata.append("image", oFile);
                formdata.append("upload_path", upload_path);
                formdata.append("newname", img_name);
                formdata.append("x1", 0);
                formdata.append("y1", 0);
                formdata.append("x2", 0);
                formdata.append("y2", 0);
                formdata.append("w", oImage.naturalWidth);
                formdata.append("h", oImage.naturalWidth);
                formdata.append("img_id", '');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/feks/public/admin/ajax/upload.php',
                    type: "POST",
                    data: formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {

                        if (data != "") {

                            // file name
                            $(obj_inputView).val(data);

                            // image view
                            $(obj_imageView).attr('src', imgObj_url + upload_path + "/" + data + "?" + Math.random());
                        }
                    }
                });
            };
        };

        oReader.readAsDataURL(oFile);
    });

}).apply(this, [jQuery]);
