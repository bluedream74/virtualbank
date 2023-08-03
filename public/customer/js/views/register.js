
/***********************************************************************************************************************
 Image Crop
***********************************************************************************************************************/

var basic = $('#crop_preview').croppie({
    viewport: { width: 200, height: 200 }
});

// photo change event
function selectPhoto(obj)
{
    $('.cr-slider').attr({
        "value": 1,
        'aria-valuenow': 1,
        "max" : 2,        	// substitute your own
        "min" : 0
    });

    $('.cr-slider').val('1').trigger('change');

    var img_url = window.URL.createObjectURL(obj.files[0]);
    $('#imgDialog').modal('show');

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
        "max" : 2,        	// substitute your own
        "min" : 0
    });

    $('.cr-slider').val('1').trigger('change');

    $('#imgDialog').modal('show');

    if(basic){
        basic.croppie('bind', {
            url: img_url
        });
    }
}

/***********************************************************************************************************************
 Get Base64 From URL
***********************************************************************************************************************/

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

// image to base64
function getBase64FromPhoto(img_url)
{
    toDataUrl(img_url, function(myBase64) {
        $('#photo_data').val(myBase64);
    });
}

/***********************************************************************************************************************
 Register Functions
***********************************************************************************************************************/

// check email
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

// submit
function checkForm()
{
    $('input').removeClass('error');

    if($('#name').val() == ''){
        $('#name').addClass('error');
        return;
    }

    if($('#email').val() == ''){
        $('#email').addClass('error');
        return;
    }

    if(!isEmail($('#email').val())){
        $('#email').addClass('error');
        return;
    }

    if($('#tel').val() == ''){
        $('#tel').addClass('error');
        return;
    }

    if($('#password').val() == ''){
        $('#password').addClass('error');
        return;
    }

    // check password
    if($('#password').val() != $('#confirm').val()) {
        $('#confirm').addClass('error');
        return;
    }

    // check photo
    if($('#photo_data').val() == ""){
        alert('アイコン画像を選択してください。');
        return;
    }

    $('#regForm').submit();
}

// check password
function checkPassword()
{
    $('input').removeClass('error');

    // check new password
    var new_password = $('#password').val();
    if(new_password == ''){
        $('#password').addClass('error');
        return;
    }

    var confirm = $('#confirm').val();
    if(confirm == ''){
        $('#confirm').addClass('error');
        return;
    }

    if(new_password != confirm){
        $('#confirm').addClass('error');
        alert('パスワードをご確認ください。');
        return;
    }

    $('#pwdForm').submit();

    /*var old_password = $('#old_pwd').val();
    var url = $('#get_url').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: url,
        data:{ password: inp_password },
        success:function(data){
            var obj = JSON.parse(data);
            if(obj['password'] == old_password){
                $('#pwdForm').submit();
            }
            else {
                alert('古いパスワードをご確認ください。');
            }
        }
    });*/
}

// forgot password
function forgotPassword(btnForgot)
{
    var email = $('#email').val();
    if((email == '') || (!isEmail(email))){
        $('#email').addClass('error');
        return;
    }

    var forgot_url = $(btnForgot).data('url');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: forgot_url,
        data:{ email: email },
        success:function(res){
            var data = JSON.parse(res);
            if(data.code == '200'){
                window.location.href = data.url;
            }
            else {
                alert('登録されたメールアドレスを入力してください。');
            }
        }
    });
}
