/**
 * Created by kbin on 8/31/2018.
 */
(function($) {

    /*  image upload in services  */
    /* convert bytes into friendly format */
    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB'];
        if (bytes == 0) return 'n/a';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
    };

    /* check for selected crop region */
    function checkForm() {
        if (parseInt(jQuery('#w').val())) return true;
        jQuery('.error').html(errorobj_please_select_a_crop_region_and_then_press_upload).show();
        return false;
    };


    /* clear info by cropping (onRelease event handler) */
    function clearInfo() {
        jQuery('.info #w').val('');
        jQuery('.info #h').val('');
    };

    function storeCoords(c) {
        jQuery('#X').val(c.x);
        jQuery('#Y').val(c.y);
        jQuery('#W').val(c.w);
        jQuery('#H').val(c.h);
    };

    /* Create variables (in this scope) to hold the Jcrop API and image size */
    var jcrop_api, boundx, boundy;

    jQuery(document).on('change', '.ct-upload-images', function (e) {
        var uploadsection = jQuery(this).attr('id');
        var ctus = jQuery(this).data('us');
        var oFile = jQuery('#' + uploadsection)[0].files[0];
        jQuery('#' + ctus + 'ctimagename').val(oFile.name);

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

        /* preview element */
        var oImage = document.getElementById('ct-preview-img' + ctus);

        /* prepare HTML5 FileReader */
        var oReader = new FileReader();
        oReader.onload = function (e) {

            /* e.target.result contains the DataURL which we can use as a source of the image */
            oImage.src = e.target.result;
            oImage.onload = function () { /* onload event handler */

                /* show image popup for image crop */
                jQuery('#ct-image-upload-popup' + ctus).modal();

                /*  display some basic image info */
                var sResultFileSize = bytesToSize(oFile.size);
                jQuery('#' + ctus + 'filesize').val(sResultFileSize);
                jQuery('#' + ctus + 'ctimagetype').val(oFile.type);
                /* jQuery('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight); */

                /* destroy Jcrop if it is existed */
                if (typeof jcrop_api != 'undefined') {
                    jcrop_api.destroy();
                    jcrop_api = null;
                    jQuery('#ct-preview-img' + ctus).width(oImage.naturalWidth);
                    jQuery('#ct-preview-img' + ctus).height(oImage.naturalHeight);
                }
                jQuery('#ct-preview-img' + ctus).width(oImage.naturalWidth);
                jQuery('#ct-preview-img' + ctus).height(oImage.naturalHeight);
                setTimeout(function () {

                    jQuery('#ct-preview-img' + ctus).Jcrop({
                        minSize: [32, 32], /* min crop size */
                        /* onSelect: [0, 0, 150, 180], */
                        setSelect: [1000,1000, 180, 200],
                        /* aspectRatio: 1, */ /* keep aspect ratio 1:1 */
                        bgFade: true, /* use fade effect */
                        bgOpacity: .3, /* fade opacity   */
                        /* maxSize: [200, 200],           */

                        boxWidth: 575,   /* Maximum width you want for your bigger images */
                        boxHeight: 400,
                        /* trueSize : [1000,1500], */
                        /* onSelect: showCoords,   */
                        /* onChange: showCoords,   */

                        onChange: function (e) {
                            jQuery('#' + ctus + 'x1').val(e.x);
                            jQuery('#' + ctus + 'y1').val(e.y);
                            jQuery('#' + ctus + 'x2').val(e.x2);
                            jQuery('#' + ctus + 'y2').val(e.y2);
                            jQuery('#' + ctus + 'w').val(e.w);
                            jQuery('#' + ctus + 'h').val(e.h);
                        },
                        onSelect: function (e) {
                            jQuery('#' + ctus + 'x1').val(e.x);
                            jQuery('#' + ctus + 'y1').val(e.y);
                            jQuery('#' + ctus + 'x2').val(e.x2);
                            jQuery('#' + ctus + 'y2').val(e.y2);
                            jQuery('#' + ctus + 'w').val(e.w);
                            jQuery('#' + ctus + 'h').val(e.h);
                        },
                        onRelease: clearInfo
                    }, function () {
                        /* jcrop_api.destroy(); */
                        /* use the Jcrop API to get the real image size */
                        var bounds = this.getBounds();
                        boundx = bounds[0];
                        boundy = bounds[1];

                        /* Store the Jcrop API in the jcrop_api variable */
                        jcrop_api = this;
                    });
                }, 500);

            };
        };

        oReader.readAsDataURL(oFile);
    });


    /* Upload Addon Service Image */
    /* UPLOAD ADDON SERVICE IMAGE */
    jQuery(document).on("click", ".ct_upload_img", function (e) {

        jQuery('.ct-loading-main').show();
        var imageuss = jQuery(this).data('us');
        var imageids = jQuery(this).data('imageinputid');
        var file_data = jQuery("#" + jQuery(this).data('imageinputid')).prop("files")[0];

        var formdata = new FormData();
        var imgObj_url =  '/feks/public/customer/img/';

        var ctus = jQuery(this).data('us');
        var img_w = jQuery('#' + ctus + 'w').val();
        var img_h = jQuery('#' + ctus + 'h').val();
        var img_x1 = jQuery('#' + ctus + 'x1').val();
        var img_x2 = jQuery('#' + ctus + 'x2').val();
        var img_y1 = jQuery('#' + ctus + 'y1').val();
        var img_y2 = jQuery('#' + ctus + 'y2').val();
        var img_name = jQuery('#' + ctus + 'newname').val();
        var img_id = jQuery('#' + ctus + 'id').val();
        var upload_path = jQuery('#upload').val();

        formdata.append("image", file_data);
        formdata.append("w", img_w);
        formdata.append("h", img_h);
        formdata.append("x1", img_x1);
        formdata.append("x2", img_x2);
        formdata.append("y1", img_y1);
        formdata.append("y2", img_y2);
        formdata.append("newname", img_name);
        formdata.append("img_id", img_id);
        formdata.append("upload_path", upload_path);

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
                jQuery('.ct-loading-main').hide();
                if (data == "") {
                    jQuery('.error-service').addClass('show');
                    jQuery('.hidemodal').trigger('click');
                } else {
                    jQuery('#' + ctus + 'ctimagename').val(data);
                    jQuery('.hidemodal').trigger('click');

                    jQuery('#' + ctus + 'addonimage').attr('src', imgObj_url + upload_path + "/" + data + "?" + Math.random());
                    jQuery('.error_image').hide();
                    jQuery('#' + ctus + 'addonimage').attr('data-imagename', data);
                    jQuery('#' + ctus + 'addonimage').attr('value', data);
                    jQuery('#image').attr('value', data);
                }
                jQuery('#'+imageids).val('');
            }
        });
    });

}).apply(this, [jQuery]);
