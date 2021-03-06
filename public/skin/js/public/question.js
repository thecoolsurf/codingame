function sendmycode() {
    var code = $.trim($('#textarea').val());
    var id = $('#textarea').data('id');
    var params = $.param({id:id,code:code});
    console.log(id+'|'+code);
    $('#sendmycode').on('click', function () {
        $.ajax({
            type: 'POST',
            url: host() + '/ajax/question/updateorinsert',
            data: params,
            dataType: 'text',
            success: function (result) {
                scrollTo();
                $(result).appendTo('#msg');
            }
        });
    });
}

function testmycode() {
    var ltx = $('#ltx').val();
    var lgx = $('#lgx').val();
    var lty = $('#lty').val();
    var lgy = $('#lgy').val();
    var params = $.param({ltx:ltx,lty:lty,lgx:lgx,lgy:lgy});
    $('#testmycode').on('click', function () {
        $.ajax({
            type: 'POST',
            url: host() + '/ajax/question/position',
            data: params,
            dataType: 'text',
            success: function (msg) {
                $('#result').html(msg);
            }
        });
    });
}

$(document).ready(function () {
    scrollTop();
    sendmycode();
    testmycode();
});
