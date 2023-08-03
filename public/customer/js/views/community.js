
/***********************************************************************************************************************
 Image Crop
 ***********************************************************************************************************************/

var basic = $('#crop_preview').croppie({
    viewport: { width: 250, height: 250 }
});

// photo change event
function selectPhoto(obj)
{
    // check image size
    var img_url = window.URL.createObjectURL(obj.files[0]);

    $('.cr-slider').attr({
        "value": 1,
        'aria-valuenow': 1,
        "max" : 2,        	// substitute your own
        "min" : 0
    });

    $('.cr-slider').val('1').trigger('change');

    $('#imgDialog').modal('show');
    $('#crop_save').removeClass('hidden');
    $('#crop_save_event').addClass('hidden');

    if(basic){
        basic.croppie('bind', {
            url: img_url
        });
    }
}

//on button click
$('#crop_save').on('click', function() {

    basic.croppie('result', 'base64').then(function(base64) {
        $('#photo_data').val(base64);
        $('#photo').css('background-image', 'url(' + base64+ ')');
        $('#imgDialog').modal('hide');
    });
});

// take photo from camera
function selectCameraPhoto(img_url, img_type)
{
    $('.cr-slider').attr({
        "value": 1,
        'aria-valuenow': 1,
        "max" : 2,
        "min" : 0
    });

    $('.cr-slider').val('1').trigger('change');

    $('#imgDialog').modal('show');

    if(img_type == 0){
        $('#crop_save').removeClass('hidden');
        $('#crop_save_event').addClass('hidden');
    }
    else {
        $('#crop_save').addClass('hidden');
        $('#crop_save_event').removeClass('hidden');
    }

    if(basic){
        basic.croppie('bind', {
            url: img_url
        });
    }
}

/**********************************************************************************************************************
 Select Event Image
 **********************************************************************************************************************/

function selectEventPhoto(obj)
{
    // set image
    var img_url = window.URL.createObjectURL(obj.files[0]);
    $('#imgDialog').modal('show');
    $('#crop_save').addClass('hidden');
    $('#crop_save_event').removeClass('hidden');

    if(basic){
        basic.croppie('bind', {
            url: img_url
        });
    }
}

$('#crop_save_event').on('click', function() {

    basic.croppie('result', 'base64').then(function(base64) {
        $('#event_photo_data').val(base64);
        $('#event_photo').css('background-image', 'url(' + base64+ ')');
        $('#imgDialog').modal('hide');
    });
});

/**********************************************************************************************************************
 Get Base64 From Image URL
**********************************************************************************************************************/

function toDataUrl(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
        var reader = new FileReader();
        reader.onloadend = function() {
            callback(reader.result);
        }
        reader.readAsDataURL(xhr.response);
    };

    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
}

function getBase64FromPhoto(img_url, obj_id)
{
    toDataUrl(img_url, function(myBase64) {
        $(obj_id).val(myBase64);
    });
}

/**********************************************************************************************************************
 Special Description
 **********************************************************************************************************************/

// show sp element
function showSp(sp_id, button) {

    if ($(sp_id).hasClass('hidden')) {

        if (sp_id == '#sp3') {
            if ($('#sp2').hasClass('hidden')) {
                return;
            }
        }

        // show
        $(sp_id).removeClass('hidden');
        $(button).html('削除する');
        $(button).addClass('btn-gold');
    }
    else {

        // hidden
        $(sp_id).addClass('hidden');
        $(button).html('追加する');
        $(button).removeClass('btn-gold');
        $(button).addClass('btn-green');

        if (sp_id == '#sp2') {
            $('#sp3').addClass('hidden');
            $('#sp3_button').removeClass('btn-gold');
            $('#sp3_button').html('追加する');
            $('#sp3_button').addClass('btn-green');

            $('#sp2_title').val('');
            $('#sp2_description').html('');
        }

        // clear
        $('#sp3_title').val('');
        $('#sp3_description').html('');
    }
}

/***********************************************************************************************************************
 * Create Community & Preview
***********************************************************************************************************************/

function checkValidation()
{
    $('input').removeClass('error');
    $('textarea').removeClass('error');

    if($('#name').val() == ''){
        $('#name').addClass('error');
        return false;
    }

    if($('#description').val() == ''){
        $('#description').addClass('error');
        return false;
    }

    if($('#sp1_title').val() == ''){
        $('#sp1_title').addClass('error');
        return false;
    }

    if($('#sp1_description').val() == ''){
        $('#sp1_description').addClass('error');
        return false;
    }

    if(!$('#sp2').hasClass('hidden')){
        if($('#sp2_title').val() == ''){
            $('#sp2_title').addClass('error');
            return false;
        }

        if($('#sp2_description').val() == ''){
            $('#sp2_description').addClass('error');
            return false;
        }
    }

    if(!$('#sp3').hasClass('hidden')){
        if($('#sp3_title').val() == ''){
            $('#sp3_title').addClass('error');
            return false;
        }

        if($('#sp3_description').val() == ''){
            $('#sp3_description').addClass('error');
            return false;
        }
    }

    if($('#price').val() == ''){
        $('#price').addClass('error');
        return false;
    }

    // check photo
    if($('#photo_data').val() == ""){
        alert('トップ画像を選択してください。');
        return false;
    }

    return true;
}
// preview submit
function preview()
{
    if(!checkValidation()) {
        $('.error').focus();
        return false;
    }
    else {

        var form_box = $("#form_box").clone();
        form_box.appendTo("#previewForm");
        $('#previewForm').submit();
    }
}

function create()
{
    if(!checkValidation()){
        $('.error').focus();
        return false;
    }

    $('#createForm').submit();
}

/**********************************************************************************************************************
 * news
***********************************************************************************************************************/

function addNews(strDate, strContent)
{
    // number of news
    var number = parseInt($('#newsNum').val()) + 1;
    $('#newsNum').val(number);

    // title, content
    var strContent = $('#content').val();
    var strTag =  $('#tag').val();

    // date
    var currentDate = new Date()
    var day = currentDate.getDate()
    var month = currentDate.getMonth() + 1
    var year = currentDate.getFullYear()
    var strDate = year + '.' + month + '.' + day;

    // insert HTML
    insertNewsHTML(number, strDate, strTag, strContent);

    // hide dialog
    $('#content').val('');
    $('#tag').val('');
    $('#addDialog').modal('hide');

    // max news 10
    if(number == 10){
        $('#btn_addNews').attr('disabled', 'disabled');
    }else {
        $('#btn_addNews').removeAttr('disabled');
    }

    // save news
    var arr_news = [];
    if($('#newslist').val() != ''){
        arr_news = JSON.parse($('#newslist').val());
    }else{

    }

    var news_item = {"tag": strTag, "content": strContent, "date": strDate};
    arr_news.push(news_item);
    $('#newslist').val(JSON.stringify(arr_news));

    if(arr_news.length > 0){
        $('#no-news').addClass('hidden');
    }
}

function insertNewsHTML(number, strDate, strTag, strContent)
{
    // string HTML for PC
    var strHTML = '<div class="row item create">';
    strHTML += '<div class="hidden-xs">';
    strHTML += '<p class="col-sm-2 txt-green date">' + strDate + '</p>';
    strHTML += '<p class="col-sm-6 content">' + strTag + '</p>';
    strHTML += '<a class="col-sm-2 btn btn-default btn-green-border btnNews mr-xs" onclick="showEditNews(' + number + ')">修正する</a>';
    strHTML += '<a class="col-sm-2 btn btn-default btn-gold-border btnNews" onclick="deleteNews(' + number + ')">削除する</a>';
    strHTML += '</div>';

    // for Mobile
    strHTML += '<div class="visible-xs">';
    strHTML += '<p class="col-xs-7 txt-green date">' + strDate + '</p>';
    strHTML += '<a class="col-xs-5 btn btn-default btn-green-border btnNews pull-right" onclick="showEditNews(' + number + ')">修正する</a>';
    strHTML += '<p class="col-xs-7 content">' + strTag + '</p>';
    strHTML += '<a class="col-xs-5 btn btn-default btn-gold-border btnNews pull-right" onclick="deleteNews(' + number + ')">削除する</a>';
    strHTML += '</div>';

    // input
    strHTML += '<input class="hidden" value="' + strDate + '" id="date' + number + '" name="date' + number + '"/>';
    strHTML += '<input class="hidden" value="' + strTag + '" id="tag' + number + '" name="tag' + number + '"/>';
    strHTML += '<input class="hidden" value="' + strContent + '" id="content' + number + '" name="content' + number + '"/>';
    strHTML += '</div>';
    $('#news').append(strHTML);
}

function deleteNews(number)
{
    // delete news
    var new_list = [];
    var arr_news = JSON.parse($('#newslist').val());
    $.each(arr_news, function(key, news) {
        if(key != number-1){
            new_list.push(news);
        }
    });

    $('#news').html('');

    // refresh news
    if(new_list.length > 0){
        $.each(new_list, function(key, news) {
            insertNewsHTML(key+1, news['date'], news['tag'], news['content']);
        });
    }
    else{
        $('#no-news').removeClass('hidden');
    }

    // save news
    $('#newslist').val(JSON.stringify(new_list));
    $('#newsNum').val(new_list.length);
}

function showEditNews(number)
{
    var strTag = $('#tag' + number).val();
    var strContent = $('#content' + number).val();

    $('#edit-tag').val(strTag);
    $('#edit-content').val(strContent);
    $('#editNum').val(number);
    $('#editDialog').modal('show');
}

function updateNews()
{
    var currentDate = new Date()
    var day = currentDate.getDate()
    var month = currentDate.getMonth() + 1
    var year = currentDate.getFullYear()
    var strDate = year + '.' + month + '.' + day;

    var editNum = $('#editNum').val();
    var strContent = $('#edit-content').val();
    var strTag =  $('#edit-tag').val();

    $('#date' + editNum).val(strDate);
    $('#tag' + editNum).val(strTag);
    $('#content' + editNum).val(strContent);

    $('#tag' + editNum).parent().find('.date').html(strDate);
    $('#tag' + editNum).parent().find('.content').html(strTag);

    // hide
    $('#edit-tag').val('');
    $('#edit-content').val('');
    $('#editDialog').modal('hide');
}

function showNews(news)
{
    $('#tag').html(($(news).data('tag')));
    $('#content').html(($(news).data('content')));
    $('#newsDialog').modal('show');
}

function showAllNews()
{
    if($('#btn_more').hasClass('more')){

        $('#btn_more').removeClass('more');
        $('#btn_more').addClass('less');
        $('#btn_more').html('閉じる');
        $('.more-news').removeClass('hidden');

    } else {
        $('#btn_more').removeClass('less');
        $('#btn_more').addClass('more');
        $('#btn_more').html('さらに見る');
        $('.more-news').addClass('hidden');
    }
}