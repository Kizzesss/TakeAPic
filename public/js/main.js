var url = 'http://localhost/takeapic/public/';
window.addEventListener("load", function() {
    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');

    //Boton de like
    function like(){
        $(".btn-like").unbind('click').click(function() {
            console.log("Like");
            $(this).addClass("btn-dislike").removeClass("btn-like");
            $(this).attr('src', url+'software/heart_red.png');

            var $id = $(this).data('id');
            $.ajax({
                url: url+'like/'+$id,
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log("Has dado like");
                    }
                    else{
                        console.log("Error al dar like");
                    }
                }
            });      
            dislike();
        });
    }
    like();
    //Boton de dislike
    function dislike(){
        $(".btn-dislike").unbind('click').click(function() {
            console.log("Dislike");
            $(this).addClass("btn-like").removeClass("btn-dislike");
            $(this).attr('src', url+'software/heart.png');

            var $id = $(this).data('id');
            $.ajax({
                url: url+'dislike/'+$id,
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log("Has dado dislike");
                    }
                    else{
                        console.log("Error al dar dislike");
                    }
                }
            });
            like();
        });
    }
    dislike();   

    //Buscador
    $('#buscador').submit(function(e){
        $(this).attr('action', url+'usuarios/'+$('#buscador #search').val());
    });
});