
function swalreload(msg,url) {

    swal({
        title: msg+"！",
        text: "2秒后刷新",
        timer: 2000,
        showConfirmButton: false
    },function(){
        if(url){
            window.location.href = url;
        }else{
            window.location.reload();
        }
    });

}