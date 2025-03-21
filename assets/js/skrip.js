$(document).ready(function(){

$('#toggle-like-btn').on('click',function(){
    var rsp_id = $(this).data('rsp');
    $klik_btn = $(this);
    var sts_like = "";

    if($klik_btn.hasClass('far fa-heart')){
        sts_like = "like";
    }else if($klik_btn.hasClass('fas fa-heart')){
        sts_like = "unlike";
    }
    $.ajax({
        url: 'recipe-detail.php',
        type: 'POST',
        data: {
            'status_like': sts_like,
            'resep_id': rsp_id
        },
        success: function(data){
            res = JSON.parse(data);
            // $klik_btn.removeClass('far fa-heart fas fa-heart like');
            if(sts_like == "like"){
                $klik_btn.removeClass('far fa-heart');
                $klik_btn.addClass('fas fa-heart');
            }else if(sts_like == "unlike"){
                $klik_btn.removeClass('fas fa-heart');
                $klik_btn.addClass('far fa-heart');
            }
            $klik_btn.siblings('span.likes').text(res.likes);
        }
    });
    
});


});


function changePage() {
    var page = document.getElementById('pageinput').value;
    var urlParams = new URLSearchParams(window.location.search);
    urlParams.set('page', page);
    window.location.href = window.location.pathname + '?' + urlParams.toString();
}

document.querySelectorAll('input[name="sort"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.getElementById('sortForm').submit(); // Submit formulir saat input radio diubah
    });
});

