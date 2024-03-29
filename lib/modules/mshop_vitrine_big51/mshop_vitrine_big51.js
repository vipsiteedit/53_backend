﻿var mshop_vitrine_big51_execute = function(params){ 
var showDescription = function(k,l,m){$(".markDescription").each(function(){var a=$(this),b=a.parent(),c=b.find(".contentDescription");b.css("position","relative");c.css({position:"absolute","z-index":1E3}).hide();var b=a.position(),f=a.outerWidth(),a=a.outerHeight(),g=c.outerWidth(!0),h=c.outerHeight(!0),d=0,e=0;switch(k){case "l":d=b.left-g;break;case "c":d=b.left+f/2-g/2;break;case "r":d=b.left+f}switch(l){case "t":e=b.top-h;break;case "c":e=b.top+a/2-h/2;break;case "b":e=b.top+a}c.css({left:d+"px",top:e+"px"})});if("c"==m)$(".contentDescription").click(function(){return!1}),$(".markDescription").on("click",function(){var a=$(this).parent().find(".contentDescription");$(".contentDescription").stop().fadeOut(100);a.stop().fadeIn(200);return!1}),$(document).click(function(){$(".contentDescription").fadeOut(100)});else $(".content .markDescription").on({mouseenter:function(){$(this).parent().find(".contentDescription")
.stop().fadeIn(200)},mouseleave:function(){$(".contentDescription").stop().fadeOut(100)}})};

function loadCompare(id_prices, compares) {
    $.post("?ajax_compare",{compare: ""+compares, idprice: id_prices}, function(){
        window.location.reload(true);
    });
}

$(document).ready(function(){
var appendPreloader = function($obj){
    if ($obj.has('.preloader').length)
        $obj.find('.preloader').show();
    else 
        $obj.append('<span class="preloader"></span>');    
}

var hidePreloader = function($obj){
    $obj.find('.preloader').fadeOut(500, function(){
        $(this).remove();
    });   
}
var updReviews = function(action, data){
    console.log($(data.reviews));
    if (data.reviews){
        if (action == 'add') {
            $(data.reviews).hide().appendTo($('.reviewsList'));
            $('.reviewItem').fadeIn(500);
        }
        else
            $('.reviewsList').hide().html(data.reviews).fadeIn(400);
    }
    $('.moreReviews').data('offset', data.offset);
    if (data.count - data.offset > 0){
        $('.moreReviews').show();
        $('.countNext').html((Math.min(parseInt(params.p321), data.count - data.offset)));
        $('.countReviews').html(data.count);
    }
    else
        $('.moreReviews').hide();    
}
var getSort = function(e, s){
    var sort = 'reviews_sort=' + e.data('sort') 
    if (e.has((s ? '.desc' : '.asc')).length)
        sort += '&asc=1'; 
    return sort;   
}
$('.moreReviews').on('click', '.buttonSend', function(e){
    var $this = $(this),
        $buttons = $(e.delegateTarget).find('.buttonSend'),
        data = 'get_reviews=1',
        upd = false;
        if ($this.is('.btnShowAll')){
            data += '&all=1';
            upd = true;
        }
        else
            data += '&offset=' + $('.moreReviews').data('offset');
        data += '&' + getSort($('.sortReviews').find('.sortField.selected'))
    $.ajax({
        url: '?ajax'+params.id,
        type: 'post',
        data: data,
        dataType: 'json',
        beforeSend: function(){
            appendPreloader($this);
            $buttons.attr('disabled', true);  
        },
        success: function(data){ 
            if (data){
                if (data.reviews) {
                    updReviews(upd ? 'upd' : 'add', data);     
                }   
            } 
        },
        complete: function(){
            hidePreloader($this);
            $buttons.attr('disabled', false); 
        }
    })
    return false; 
})

$('.sortReviews').on('click', '.sortField', function(){ 
    var $field = $(this);
    $.ajax({
        url: '?ajax'+params.id,
        type: 'post',
        data: getSort($field, 1) + '&get_reviews=1',
        dataType: 'json',
        beforeSend: function(){
            appendPreloader($('.sortReviews'));    
        },
        success: function(data){
            if (data){
                if (data.reviews) {
                    updReviews('upd', data);
                    $field.find('i').remove();
                    $field.append(data.direction).addClass('selected').siblings().removeClass('selected').find('i').remove();
                }                    
            }   
        },
        complete: function(){
            hidePreloader($('.sortReviews'));
        }
    })
    return false;
})
$('.reviews').on('click', '.linkShow, .linkCancel', function(){
    $('.addReview').stop().slideToggle(400);
    return false;    
})
$('.addReview form').submit(function(e){
    e.preventDefault();
    var $form = $(this);
    $.ajax({
        url: '?ajax'+params.id,
        type: 'post',
        data: $form.serialize(),
        dataType: 'json',
        beforeSend: function(){
            appendPreloader($form.find('.btnAdd').attr('disabled', true));    
        },
        success: function(data){
            if (data){
                if (data.success){
                    $('.addReview, .linkShow').hide(500, function(){
                        $(this).remove();
                    });
                     $('.msgSuccess').show(500);
                }
            }    
        },
        complete: function(){
            $form.find('.btnAdd').attr('disabled', false);
            hidePreloader($form);
        }
    }) 
    return false;      
})

$('.blockEditMark').on('change', 'input:radio', function(){
    var $current = $(this).parent();
    $('.blockEditMark').find('.markTitle').html($current.attr('title')); 
    $current.addClass('selectedMark').siblings().removeClass('selectedMark');
    $current.prevAll().addClass('selectedMark');    
})

$('.blockEditMark').on({'mouseenter': function(){
    $('.blockEditMark').removeClass('editMark');
    $(this).addClass('activeMark').prevAll().addClass('activeMark');  
},'mouseleave':function(){
    $('.blockEditMark').addClass('editMark');
    $('.blockEditMark').find('.markItem').removeClass('activeMark');
}}, '.markItem')

$('.reviewsList').on('click', '.reviewVoiting:not(.disabled) .lnkVote', function(){
    var $this = $(this).addClass('selected'),
        $voiting = $this.closest('.reviewVoiting').addClass('disabled');
        vote = $this.is('.likeReview') ? '1' : '-1',
        id_review = $this.closest('.reviewItem').data('id');
    $.ajax({
        url: '?ajax'+params.id,
        type: 'post',
        data: {'vote':vote, 'id':id_review},
        dataType: 'json',
        beforeSend: function(){
            appendPreloader($voiting);   
        },
        success: function(data){ 
            if (data){
                if (data.success){
                    $voiting.find('.countLikes').text(data.likes); 
                    $voiting.find('.countDislikes').text(data.dislikes);
                    var rating = data.likes - data.dislikes,
                        new_class = rating > 0 ? 'positive' : (rating < 0 ? 'negative' : '');
                    $voiting.closest('.reviewItem').find('.rateValue').removeClass('positive negative').addClass(new_class).text(rating);
                }
            }
        },
        complete: function(){  
            hidePreloader($voiting);       
        }
    })    
})

function imageCarousel() {
if (typeof ($.fn.jCarouselLite) === "function") {
    $('.photoSlider').jCarouselLite({
        btnNext: '.next',
        btnPrev: '.prev',
        circular: false,
        mouseWheel: true
    });
}
};
imageCarousel();

if (typeof ($.fn.imagezoomsl) === "function") {
    $('.goodsLinkPhoto img').imagezoomsl({
        'zoomrange': [1,4], 
        'stepzoom':0.2
    });
    $('.tracker').click(function(){alert()})
}

if (typeof ($.fn.fancybox) === "function") {
    $('.imageList a').fancybox({
        helpers : {
            thumbs : {
				width : 50,
				height : 50
            }
        }
    });
    $('.goodsLinkPhoto a').click(function(){
        $('.imageList .activeImg a').click();
        return false;
    })
}

/*
if ($('.goodsDetail .tabs').length){
    var $titles = $('.goodsDetail .titleHead'),
        $tabs = $('.goodsDetail .tabs').show(),
        $tabs_nav = $tabs.find('.tabsNav'),
        $tabs_content = $tabs.find('.tabsContent');    
    $titles.each(function(){
        $tabs_nav.append('<li class="itemTab">' + $(this).html() + '</li>');
        $tabs_content.append($(this).next());
        $(this).remove();
    }) 
    $('.tabs .tabsNav li').click(function(e) {
        e.preventDefault();
        var $this = $(this);
        if (!$this.hasClass('activeTab')) {
            $this.addClass('activeTab').siblings().removeClass('activeTab');
            $tabs_content.find('.content').hide().eq($this.index()).fadeIn(400);
        }
    }); 
    $tabs_nav.find('.itemTab').first().click();  
}
*/
if ($('.goodsDetail .tabs').length){
    var $titles = $('.goodsDetail .titleHead'),
        $tabs = $('.goodsDetail .tabs').show(),
        $tabs_nav = $tabs.find('.tabsNav'),
        $tabs_content = $tabs.find('.tabsContent');    
    $titles.each(function(){
        $tabs_nav.append('<li class="itemTab" id="' + ($(this).attr('id') ? $(this).attr('id') : '') + '">' + $(this).html() + '</li>');
        $tabs_content.append($(this).next());
        $(this).remove();
    }) 
    $('.tabs .tabsNav .itemTab').click(function(e) {
        e.preventDefault();
        var $this = $(this);
        if (!$this.hasClass('activeTab')) {
            $this.addClass('activeTab').siblings().removeClass('activeTab');
            $tabs_content.find('.content').hide().eq($this.index()).fadeIn(400);
        }
    }); 
    var hash = location.hash;
    var $default_tab = $tabs_nav.find(hash);
    if (!$default_tab.length)
        $default_tab = $tabs_nav.find('.itemTab').first();
    $default_tab.click();  
}

$('.imageList').on('mouseenter', 'a', function(){
    if (!$(this).closest('.imageItem').hasClass('activeImg')){
        var $this = $(this),
            $photo = $('.goodsLinkPhoto');
        $this.closest('.imageItem').addClass('activeImg').siblings().removeClass('activeImg');
    
        $photo.find('img').stop().fadeOut(100, function(){$(this).attr({'src': $this.data('middle'), 'data-large': $this.attr('href')}).stop().fadeIn(300)});
    }
})

$('.vitrineSort').on('change', 'select', function(){
    $(this).closest('form').submit();    
})

$('.modifications').off('change').on('change', 'input, select', function(){
    var $this = $(this),
        value = $this.val();
        $param = $this.closest('.itemFeature');
        $group = $this.closest('.groupFeature');
        $block_param = $this.closest('.modifications');
        $overlay = $block_param.find('.overlay').show();
        id_price = $block_param.data('goods');
    $.ajax({
        url: '?ajax'+params.id,
        type: 'post',
        data: {'id_price':id_price,'group':$group.data('id'), 'param':$param.data('id'), 'value':value},
        dataType: 'json',
        success: function(data){
            var $product = $block_param.closest('.goodsDetail, .productItem, .blockGoods');
            if (data.price) {
                $product.find('.newPrice').html(data.price.new);
                $product.find('.oldPrice').html(data.price.old);    
            }
            if (data.presence) {
                $product.find('.presenceValue, .hpresence .presence').html(data.presence);    
            }
            if (data.count) {
                if (data.count=='0')
                    $product.find('.addcart').attr('disabled', true);
                else
                    $product.find('.addcart').attr('disabled', false);    
            } 
            if (data.images) {
                var $images = $product.find('.morephotos .imageList');
                if ($images.length) {
                    
                    $images.find('.imageItem').hide().find('a').removeAttr('rel');
                    if (data.images.length) {
                        for (var i = 0; i < data.images.length; i++){
                            if (i in data.images) {
                                $images.find('.imageItem[data-id='+data.images[i].id+']').show().find('a').attr('rel', 'imagebox');       
                            }
                        }
                    }
                    else
                        $images.find('.imageItem:first').show().find('a').attr('rel', 'imagebox');
                    $images.find('.imageItem:visible:first a').mouseenter();
                    
                    imageCarousel();
                }
            }
            if (data.params) {
                for (var i in data.params) {
                    var param = data.params[i];
                    if (param.values){
                        $param = $group.find('.itemFeature[data-id='+i+']');
                        if (data.type=='radio') {
                            $param.find('.itemValue').hide().find('input').removeAttr('checked');
                        }
                        else {
                            $param.find('option').hide().removeAttr('selected');    
                        }
                        var $prev = null;
                        for (var j in param.values) {
                            var value = param.values[j];
                            if (data.type=='radio') {
                                var $value = $param.find('.itemValue[data-id='+j+']'); 
                            }
                            else {
                                var $value = $param.find('option[data-id='+j+']');
                            }
                            if ($value.length)
                                $prev = $value.show();
                            else {
                                if (data.type=='radio') {
                                    if (!$prev) $prev = $param.find('.nameFeature');
                                    $value = $('<label class="itemValue" title="'+value.value+'" data-id="'+j+'"><input type="radio" name="feature['+id_price+'_'+$group.data('id')+'_'+i+']" value="'+j+'"><span class="featureValue">'+value.value+'</span></label>').insertAfter($prev);
                                    if (param.type == 'colorlist') {
                                        $value.find('.featureValue').css('background-color', '#'+value.color).html('<span></span>');
                                    }   
                                }
                                else{
                                    $value = $('<option title="'+value.value+'" data-id="'+j+'" value="'+j+'">'+value.value+'</option>')
                                    if (!$prev){ 
                                        $value.prependTo($param.find('select'));
                                    }
                                    else {   
                                        $value.insertAfter($prev);
                                    }
                                }       
                            }
                                
                            if (j == param.selected) {
                                if (data.type=='radio') {
                                    $value.find('input').attr('checked', true);
                                }
                                else{
                                    $value.attr('selected', true);
                                }
                            }    
           
                        }
                    }
                        
                }
            }
        },
        complete: function(){
            $overlay.fadeOut(200);    
        }
    });
});
$('.anchor').click(function(){
    var hash = $(this).attr('href');
    if (hash){
        var $anchor = $(hash);
        if ($anchor.length) {
            $('body,html').animate({
                scrollTop: $anchor.offset().top
            }, 400);
            if ($anchor.is('.itemTab'))
                $anchor.click();
        }  
    }
    return false;
})
})
showDescription(params.p307, params.p308, params.p309);
}
