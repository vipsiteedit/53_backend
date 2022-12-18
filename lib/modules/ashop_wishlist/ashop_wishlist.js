var ashop_wishlist_execute = function(params){ 
var showDescription = function(k,l,m){$(".markDescription").each(function(){var a=$(this),b=a.parent(),c=b.find(".contentDescription");b.css("position","relative");c.css({position:"absolute","z-index":1E3}).hide();var b=a.position(),f=a.outerWidth(),a=a.outerHeight(),g=c.outerWidth(!0),h=c.outerHeight(!0),d=0,e=0;switch(k){case "l":d=b.left-g;break;case "c":d=b.left+f/2-g/2;break;case "r":d=b.left+f}switch(l){case "t":e=b.top-h;break;case "c":e=b.top+a/2-h/2;break;case "b":e=b.top+a}c.css({left:d+"px",top:e+"px"})});if("c"==m)$(".contentDescription").click(function(){return!1}),$(".markDescription").on("click",function(){var a=$(this).parent().find(".contentDescription");$(".contentDescription").stop().fadeOut(100);a.stop().fadeIn(200);return!1}),$(document).click(function(){$(".contentDescription").fadeOut(100)});else $(".content .markDescription").on({mouseenter:function(){$(this).parent().find(".contentDescription")
.stop().fadeIn(200)},mouseleave:function(){$(".contentDescription").stop().fadeOut(100)}})};

var productCompare = function(){
$('.compare').off('change').change(function(){
    var id_price = $(this).data('id');
    $.ajax({
        url: params.ajax_url,
        type: 'post',
        data: {'compare':id_price},
        dataType: 'json',
        success: function(data){
            if (data.compare){
                var $compare = $('.compare[data-id=' + id_price + ']').attr('checked', (data.compare == 'add')),
				    $btn = $('.selCompare'),
				    $warning = $('.CompareWarning');
                if (data.compare == 'add')
                    $compare.closest('.blockCompare').find('.lnkInCompare').show();
                else
                    $compare.closest('.blockCompare').find('.lnkInCompare').hide();
				if ($btn.length) {
				    $btn.find('.compareNum').text(data.all_compare);
                    if (data.all_compare > 0)
				        $btn.show();
				    else
				        $btn.hide();
				}
				if ($warning.length) {
				    if (data.limit && data.all_compare >= data.limit) {
				        $warning.show();
				        $('.compare').not(':checked').attr('disabled', true);
				    }
				    else {
				        $warning.hide();
                        $('.compare').not(':checked').removeAttr('disabled');
				    }
				}
                
                if($('.shop_informer__compare').find('.shop_informer__item_count').length > 0){
					let compare_count = data.all_compare;
					$('.shop_informer__compare').find('.shop_informer__item_count').text(compare_count);
					$('#informer_compare_count').val(compare_count);
				}
                	
            }          
        }
    })    
})
}

$('.btnPreorder').on('click', function(){
    var $this = $(this),
        $block = $('.blockPreorder');
    if ($block.length > 0) {  
        $block.find('form').show();
        $block.find('.msgAccepted, .cback_error').hide();
        $block.find('input').val('');
        $block.find('[name=product]').val($this.closest('form').find('[name=addcart]').val());
        $block.find('[name=count]').val($this.closest('form').find('[name=addcartcount]').val()); 
        $.fancybox({content:$block});
    }
})

$('.btnDelProd').on('click', function(e){
    e.preventDefault();
    var id_price = $(this).data('id');
    var this_el = $(this);
    $.ajax({
        url: params.ajax_url,
        type: 'post',
        data: {'delprod':id_price},
        dataType: 'json',
        success: function(data){
            if(data.id){
                this_el.closest('.productItem').fadeOut(400, function(){
                    $(this).remove();
					if($('.shop_wishlist').find('.productItem').length == 0){
						$('.goodsContent').append('<div class="noGoodsIntable">Нет товаров</div>');
						$('.blockPanel').remove();
						$('.blockWishList').remove();
					}
                });
				
				if($('.shop_informer__wish').find('.shop_informer__item_count').length > 0){
					let wish_count = data.count;
					$('.shop_informer__wish').find('.shop_informer__item_count').text(wish_count);
					$('#informer_wish_count').val(wish_count);
				}
				
            }
        },
        error: function (xhr, ajaxOptions, thrownError){
            alert(thrownError); //выводим ошибку
        }
    })    
});

function checkPreorder() {
    var $block = $('.blockPreorder')
        $email = $block.find('[name=cb_email]'),
        $name = $block.find('[name=cb_name]'),
        pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i,
        result = true;
    $block.find('.msgAccepted, .cback_error').hide();    
    if ($email.val() == '' || !pattern.test($email.val())) {
        $email.parent().find('.cback_error').show(); 
        result = false;
    }
    if ($name.val() == '') {
        $name.parent().find('.cback_error').show();
        result = false;
    } 
    return result;
}

$('.blockPreorder').on('click', '.btnConfirm', function(e){
    e.preventDefault();
    if (checkPreorder()) {
    var data = $('.blockPreorder').find('form').serialize() + '&preorder=1';
    $.ajax({
        url: params.ajax_url,
        type: 'post',
        data: data,
        dataType: 'json',
        beforeSend: function(){
            $('.blockPreorder').find('.btnConfirm').attr('disabled', true);        
        },
        success: function(data){ 
            if (data){
                console.log(data);  
            } 
            $('.blockPreorder').find('form').hide();
            $('.blockPreorder').find('.msgAccepted').show();
        },
        complete: function(){
            $('.blockPreorder').find('.btnConfirm').removeAttr('disabled'); 
        }
    })
    }
})

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
var getSort = function(e, s){
    var sort = 'reviews_sort=' + e.data('sort') 
    if (e.has((s ? '.desc' : '.asc')).length)
        sort += '&asc=1'; 
    return sort;   
}

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

var imageZoom = function() {
if (typeof ($.fn.imagezoomsl) === "function") {
    $('.goodsLinkPhoto img').imagezoomsl({
        'zoomrange': [1,4], 
        'stepzoom':0.2
    });
}
};

var imageHover = function() {
$('.imageList').on('mouseenter', 'a', function(){
    var $this = $(this);
    if (!$this.closest('.imageItem').hasClass('activeImg')){
        
        var $photo = $this.closest('.goodsDetail').find('.goodsLinkPhoto');
        $this.closest('.imageItem').addClass('activeImg').siblings().removeClass('activeImg');
    
        $photo.find('img').stop().fadeOut(100, function(){$(this).attr({'src': $this.data('middle'), 'data-large': $this.attr('href')}).stop().fadeIn(300)});
        $photo.find('a').attr('href', $this.attr('href'));
    }
})
};

var changeCount = function() {
$('.addCount').on('click', 'button', function(){
	var $input = $(this).closest('.addCount').find('input[name=addcartcount]');
		count = parseFloat($input.val()),
		step =  parseFloat($input.data('step'));  
	if (isNaN(step)) step = 1;
	if (isNaN(count)) count = step;
	count += $(this).data('action') == 'inc' ? step : (count > step ? -step : 0);

	$input.val(Math.round(count*1000)/1000).change();
	
});
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
    $('.goodsLinkPhoto').on('click', 'a', function(){
        $('.imageList .activeImg a').click();
        return false;
    })
}

$('.vitrineSort').on('change', 'select', function(){
    $(this).closest('form').submit();    
})

$('.quickView').click(function(){
    var id_price = $(this).data('id');
    $.ajax({
        url: params.ajax_url,
        type: 'post',
        data: {'quickview':id_price},
        dataType: 'json',
        beforeSend: function(){ 
            $.fancybox.showLoading();
        },
        success: function(data){  
            if (data && data.quickshow){
                $.fancybox({content:data.quickshow, width:800, autoSize: false, live:false});
                if (data.footer)
                    $('.quickShow').after(data.footer);
                if (data.header)
                    $('.quickShow').before(data.header);
                $('.quickShow .imageList a').click(function(){return false;});
                allLOad();   
            }
        },
        complete: function(){
            $.fancybox.hideLoading();
        }
    })
    return false;
})
var changeModifications = function(){
$('.modifications').off('change').on('change', 'input, select', function(){
    var $this = $(this),
        value = $this.val();
        $param = $this.closest('.itemFeature');
        $group = $this.closest('.groupFeature');
        $block_param = $this.closest('.modifications');
        $overlay = $block_param.find('.overlay').show();
        id_price = $block_param.data('goods');
    $.ajax({
        url: params.ajax_url,
        type: 'post',
        data: {'id_price':id_price,'group':$group.data('id'), 'param':$param.data('id'), 'value':value},
        dataType: 'json',
        success: function(data){
        $('.modifications[data-goods=' + id_price + ']').each(function(){
            $group = $(this).find('.groupFeature');
            var $product = $(this).closest('.goodsDetail, .productItem, .blockGoods');
            var type = $(this).data('type');
            if (type == undefined || type == '')
                type = data.type;
            if (data.price) {
                $product.find('.newPrice').html(data.price.new);
                $product.find('.oldPrice').html(data.price.old);    
            }
            if (data.presence) {
                $product.find('.presenceValue, .hpresence .presence').html(data.presence);    
            }
            if (data.count) {
                var $button = $product.find('.addcart');
                if (data.count=='0'){
                    $button.attr('disabled', true);
                    if (params.param233 == 'N')
                        $button.hide();
                }    
                else
                    $button.attr('disabled', false).show();    
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
                        if (type=='radio') {
                            $param.find('.itemValue').hide().find('input').removeAttr('checked');
                        }
                        else {
                            $param.find('option').hide().removeAttr('selected');    
                        }
                        var $prev = null;
                        for (var j in param.values) {
                            var value = param.values[j];
                            if (type=='radio') {
                                var $value = $param.find('.itemValue[data-id='+j+']'); 
                            }
                            else {
                                var $value = $param.find('option[data-id='+j+']');
                            }
                            if ($value.length)
                                $prev = $value.show();
                            else {
                                if (type=='radio') {
                                    var prefix = $product.is('.goodsDetail') ? 's_' : '';
                                    if (!$prev) $prev = $param.find('.nameFeature');
                                    $value = $('<label class="itemValue" title="'+value.value+'" data-id="'+j+'"><input type="radio" name="feature['+prefix+id_price+'_'+$group.data('id')+'_'+i+']" value="'+j+'"><span class="featureValue">'+value.value+'</span></label>').insertAfter($prev);
                                    if (param.type == 'colorlist') {
                                        if (value.image)
                                            $value.find('.featureValue').replaceWith('<img class="featureValue" src="' + value.image + '">');
                                        else
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
                                if (type=='radio') {
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
        });
        },
        complete: function(){
            $overlay.fadeOut(200);    
        }
    });
});
}
var allLOad = function(){
    imageHover();
    imageZoom();
    productCompare();
    imageCarousel();
    changeModifications();
    showDescription(params.param307, params.param308, params.param309);
    changeCount();
};allLOad();

function ga_showProduct(product) {
	if (typeof (ga) === 'function') {
		ga('ec:addProduct', {
		  'id': product.id,
		  'name': product.name,
		  'category': product.category,
		  'brand': product.brand,
		  'variant': product.variant
		});
		ga('ec:setAction', 'detail');
		ga('send', 'pageview'); 
	}
}

if (params.show_product){
    ga_showProduct(params.show_product)    
}

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
}
