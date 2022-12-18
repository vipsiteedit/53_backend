var apersonal_execute = function(params){ 
$('.show-password').click(function(){
    var $this = $(this),
        $input = $this.parent().find('input');
    if ($input.attr('type') == 'password')
        $input.attr('type', 'text');    
    else
        $input.attr('type', 'password'); 
    $this.toggleClass('glyphicon-eye-open glyphicon-eye-close');
})
$('.change-avatar').click(function(e){
    e.preventDefault();
    $('input[name=avatar]').click();
    
})

$('input[name=avatar]').change(function(e){
    var file = e.target.files[0],
        reader = new FileReader,
        $image = $('.image-avatar'); 
    reader.readAsDataURL(file);
    reader.onload = function(e) {
         $image.attr('src', e.target.result);
    }   
})
}
