
function swalreload(msg) {
    swal({
        title: msg+"！",
        text: "2秒后刷新",
        timer: 2000,
        showConfirmButton: false
    });
    setTimeout(function () {
        window.location.reload();
    },2000)
}