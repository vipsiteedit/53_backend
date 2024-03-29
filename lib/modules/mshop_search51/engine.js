﻿var liveSearch = function(ajax_url, min_length){
var timer=null, ajax=null;
var closeSuggest = function(suggest){
    
    setTimeout(function(){
		suggest.hide();
	}, 100);
    
}

var input = $("#livesearch"),
	suggest = $('<div class="suggestions"></div>').insertAfter(input).hide(),
    preloader = $('<span class="preloader"></span>').insertAfter(suggest).hide(),
    query = '';



suggest.on('click', '.suggestItem', function(){
    input.val($(this).data('suggest')).focus(); 
})

$(document).click(function(){closeSuggest(suggest)});

input.keydown(function(e) {
    if (suggest.is(':visible') && (e.keyCode == 38 || e.keyCode == 40)) {
		var selected = suggest.children('.suggestItem.selected'),
			next = null,
            value = query;
		if (selected.length) {
			if (e.keyCode == 38) {
				if (!suggest.children('.suggestItem:first.selected').length) {
					next = selected.prev('.suggestItem');
				}
			} 
			else {
				if (!suggest.children('.suggestItem:last.selected').length) 
                    next = selected.next('.suggestItem');
			}
			selected.removeClass('selected');
		}
        else {
            if (e.keyCode == 38) {
                next = suggest.children('.suggestItem:last');
            }
            else
                next = suggest.children('.suggestItem:first');
        }
        if (next){
            value = next.addClass('selected').data('suggest');
        }
		input.val(value);
	}  
	if (e.keyCode == 13 || e.keyCode == 27) {
		closeSuggest(suggest);
	} 
}).keyup(function(e) {
    if (e.keyCode == 37 || e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40 || e.keyCode == 13 || e.keyCode == 27) {
        return false;
    }
    query = input.val();
	if (query && query.length >= min_length) {
		clearTimeout(timer);
		timer = setTimeout(function(){
			if (ajax) 
                ajax.abort();
            ajax = $.ajax({
				url: ajax_url,
				type: 'get',
				dataType: 'json', 
				data: {'q': query}, 
				beforeSend: function(){
                    preloader.show();
                },
                success: function(data){
					if (data.goods) {
                        suggest.empty();
                        for (var i = 0; i < data.goods.length; i++){
                            if (i in data.goods) {
                                var g = data.goods[i];
                                suggest.append('<div class="suggestItem" data-suggest="' + g.suggest + '"> <span class="goodsImage"><img src="' + g.image + '"></span><div class="goodsName"><a title="' + g.suggest + '" href="' + g.url + '">' + g.name + '</a></div><div class="goodsArticle">' + g.article + '</div><div class="goodsPrice">' + g.price + '</div></div>');
                            }
                        }
                        suggest.show();    
                    }   
					else {
						closeSuggest(suggest);
					}
				},
                complete: function(){
                    preloader.hide();
                }
			});
		}, 150);
	}
	else {
		closeSuggest(suggest);
	}
});
}
