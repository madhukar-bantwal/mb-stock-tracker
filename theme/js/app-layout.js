/** Shivananda Shenoy (Madhukar) */

// Only Alphanumeric
$(document).on('keyup change paste', '.js-alphaNumeric', function () {
    $(this).val(this.value.replace(/[^a-zA-Z0-9 ]/g, ''));
});

// Only Characters
$(document).on('keyup change paste', '.js-characters', function () {
    $(this).val(this.value.replace(/[^a-zA-Z ]/g, ''));
});

// Only Numeric
$(document).on('keyup change paste', '.js-numeric', function () {
    $(this).val(this.value.replace(/[^0-9]/g, ''));
});

// Only Capitalize
$(document).on('keyup change paste', '.js-capitalize', function () {
    $(this).val(this.value.toLowerCase().replace(/\b[a-z]/g, function (letter) {
        return letter.toUpperCase();
    }));
});

/** Loader */

function loader_start(id) {
    if (id) {
        $('#' + id).LoadingOverlay('show');
    } else {
        $.LoadingOverlay('show');
    }
}

function loader_stop(id) {
    if (id) {
        $('#' + id).LoadingOverlay('hide', true);
    } else {
        $.LoadingOverlay('hide', true);
    }
}

// Common Functions

function disable(id) {
    $('#' + id).attr('disabled', true);
    $('#' + id).addClass('disabled');
}

function enable(id) {
    $('#' + id).attr('disabled', false);
    $('#' + id).removeClass('disabled');
}

// Post Data
function postRequest(form, sbt) {
    loader_start();
    if (sbt) { disable(sbt); }
    var formData = new FormData(document.getElementById(form));
    $.ajax({
        type: 'POST',
        enctype: 'multipart/form-data',
        url: 'server-process/post.php',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (result) {
            $('#dy-result').html(result);
            if (sbt) { enable(sbt); }
            loader_stop();
            return true;
        },
        error: function (result) {
            if (sbt) { enable(sbt); }
            loader_stop();
            alert('Error : Unable to process request, Please try again.');
        }
    });
    return false;
}