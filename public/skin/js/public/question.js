function sendmycode() {
    var code = $('#textarea').val();
    var id = $('#textarea').data('id');
    var params = $.param({id:id,code:code});
    $('#sendmycode').on('click', function () {
        $.ajax({
            type: 'GET',
            url: host() + '/ajax/question/updateorinsert/' + id,
            data: params,
            dataType: 'text',
            success: function (result) {
                console.log(result);
                $(result).prependTo('#container');
            }
        });
    });
}

$(document).ready(function () {
    scrollTop();
    sendmycode();
});
