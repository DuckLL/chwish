$(function () {

    $('#generate').click(function () {
        var keySize = 2048;
        var crypt = new JSEncrypt({
            default_key_size: keySize
        });
        crypt.getKey();
        $('#prikey').val(crypt.getPrivateKey());
        $('#pubkey').val(crypt.getPublicKey());
    });

    $('#encrypt').click(function () {
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey($('#enckey').val());
        var input = $('#wish').val();
        $('#encwish').val(encrypt.encrypt(input));
    });

    $('#decrypt').click(function () {
        var decrypt = new JSEncrypt();
        decrypt.setPrivateKey($('#deckey').val());
        var crypted = $('#msg').val();
        var decrypted = decrypt.decrypt(crypted);
        if (!decrypted)
            decrypted = 'This is not your mission';
        $('#decwish').val(decrypted);
    });

    $('#copyprikey').click(function () {
        var copyText = $("#prikey");
        copyText.select();
        var copyStatus = document.execCommand("Copy");
        var msg = copyStatus ? 'copied' : 'failed';
        alert(msg);
    });

    $('#submitpubkey').click(function () {
        if (confirm('請確認已經妥善保存prikey，送出後prikey會消失！')) {
            $.ajax({
                url: 'control.php',
                type: 'POST',
                data: {
                    pubkey: $('#pubkey').val()
                },
                error: function (xhr) {
                    alert(xhr.responseText);
                },
                success: function (response) {
                    alert(response);
                    window.localStorage.prikey = btoa($('#prikey').val())
                    location.reload();
                }
            });
        }
    });

    $('#submitwish').click(function () {
        $.ajax({
            url: 'control.php',
            type: 'POST',
            data: {
                encwish: $('#encwish').val()
            },
            error: function (xhr) {
                alert('error');
            },
            success: function (response) {
                alert(response);
                location.reload();
            }
        })
    });

    $('#confirmwish').click(function () {
        $.ajax({
            url: 'control.php',
            type: 'POST',
            data: {
                confirm: 1
            },
            error: function (xhr) {
                alert('error');
            },
            success: function (response) {
                alert(response);
                location.reload();
            }
        })
    });

    $('#cancelconfirm').click(function () {
        $.ajax({
            url: 'control.php',
            type: 'POST',
            data: {
                confirm: 0
            },
            error: function (xhr) {
                alert('error');
            },
            success: function (response) {
                alert(response);
                location.reload();
            }
        })
    });

    $(".treasure").click(function () {
        $(".treasure").removeClass("active");
        $(this).addClass("active");
        $('#msg').val($(this).attr('value'));
    });

    $(window).mousewheel(function (e) {
        if (e.deltaY > 5) {
            $('#progress').show();
            $('#description').show();
        }
        if (e.deltaY < -5) {
            $('#progress').hide();
            $('#description').hide();
        }
    });

    if (window.localStorage.prikey) {
        $('#deckey').val(atob(window.localStorage.prikey));
    }


});