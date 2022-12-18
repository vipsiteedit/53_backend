var anavcatalog_top_execute = function(params){ 
$('.headerCatalog li').each(function(i,elem) {
    var id = $(this).data('id'), $this = this;
    $.post('?loadsubcatalog', {id: id, level: 1}, function(data){
        $('.loadering').remove();
        if (data != '') {
            $($this).find('.headerCatalogSub .catWindow').html(data);
        }
    })
})
}
