const baseUrl = window.location.origin;
const token = $('meta[name="csrf-token"]').attr("content");

function ajaxCallback(
    url,
    method,
    data,
    success,
    error,
    dataType = "json",
    contentType = "application/x-www-form-urlencoded;charset=UTF-8",
    processData = false
) {
    $.ajax({
        url: baseUrl + url,
        method: method,
        data: data,
        dataType: dataType,
        success: success,
        error: error,
        contentType: contentType,
        processData: processData,
    });
}

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": token,
    },
});
