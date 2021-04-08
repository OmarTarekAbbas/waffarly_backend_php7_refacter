$( "#form_zain" ).submit(function( event ) {
    var inputVal = $('#phone').val();
    var numericReg = /^\d[0-9]*$/;
    if(numericReg.test(inputVal)) {
        $('#numeric').hide();
    }else{
        $('#numeric').show();
    }
    var numericReg = /^\d{9}$/;
    if(numericReg.test(inputVal)) {
        $('#numericnum').hide();
        return;
    }else{
        $('#numericnum').show();
    }
    $('#numeric').css('display', 'block ');
    $('#numericnum').css('display', 'block ');
    event.preventDefault();
});
// x
$('#phone').keyup(function() {
    'use strict';
    $('.fa-times').css('display', 'inline-block');
    if ($(this).val() == '') {
        $('.fa-times').css('display', 'none');
    }
});

$('#phone').focusin(function() {
    'use strict';
    $('#video').css('display', 'none');
    $('.strip').css('margin-top', 20);
});

$('#phone').blur(function() {
    'use strict';
    $('#video').css('display', 'block');
    $('.strip').css('margin-top', -10);

    var phone = $("#phone").val();
    if (phone != "" && phone.length == 8) {
        $("#form").submit()
    }


});
$('#phone').keyup(function() {
        var phone = $("#phone").val();
        if (phone != "" && phone.length == 9) {
            $("#zain_submit").attr('disabled', false)
            $(".fa-times").css('display', 'none')
        } else {
            $("#zain_submit").attr('disabled', true)
            $(".fa-times").css('display', 'inline-block')
        }
    })
$('#zain_submit').focusin(function() {
    var phone = $("#phone").val();
    if (phone != "" && phone.length == 9) {
        $('#form_zain').submit();
    } else {
        return false;
    }
});
