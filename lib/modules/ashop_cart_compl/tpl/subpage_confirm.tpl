<header:css>
[lnk:rouble/rouble.css]
[include_css]
</header:css>
<?php if(strval($section->parametrs->param20)!='d'): ?><div class="<?php if(strval($section->parametrs->param20)=='n'): ?>container<?php else: ?>container-fluid<?php endif; ?>"><?php endif; ?>
<section class="content pageConfirmOrder contShopCartNew b_shop_cart b_shop_cart-page_confirm">
    <h3 class="contentTitle"><span><?php echo $section->language->lang001 ?></span></h3>
    <div class="b_shop_cart-shoping_step">
        <div class="b_shop_cart-shoping_step_item ">
            <span class="b_shop_cart-shoping_step_link"><?php echo $section->language->lang091 ?></span>
        </div>
        <div class="b_shop_cart-shoping_step_item b_shop_cart-shoping_step_item__active">
            <span class="b_shop_cart-shoping_step_link"><?php echo $section->language->lang092 ?></span>
        </div>
        <div class="b_shop_cart-shoping_step_item">
            <span class="b_shop_cart-shoping_step_link"><?php echo $section->language->lang093 ?></span>
        </div>
    </div>
    <div class="b_shop_cart-confirm_shoping_list">
    <table class="tableOrder qwert" cellSpacing="0" cellPadding="0" border="0">
         <tbody class="tableBody">
        <?php foreach($section->objects as $record): ?>
           <tr class="tableRow">
                    <td class="tdConfirmOrderName"><?php echo $record->name ?><?php if(!empty($record->paramsname)): ?>(<?php echo $record->paramsname ?>)<?php endif; ?></td>
                    <td class="tdConfirmOrderPrice"><?php echo $record->newprice ?></td>
                    <td class="tdConfirmOrderCount"><?php echo $record->show_count ?></td>
                    <td class="tdConfirmOrderSum"><?php echo $record->newsum ?></td>
                </tr>
        
<?php endforeach; ?>
    </tbody>
    </table>
    </div>
    
    <div class="b_shop_cart-confirm_total_price">
    <table class="tableOrderTotal" cellSpacing="0" cellPadding="0" border="0">
        <tbody class="tableBody">
            <tr class="tableRow itogo">
                <td class="tdOrderTotalTitle"><?php echo $section->language->lang007 ?></td> 
                <td class="tdOrderTotalValue"><?php echo $total_sum_goods ?></td> 
            </tr> 
            <tr class="tableRow discount">
                <td class="tdOrderTotalTitle"><?php echo $section->language->lang008 ?></td> 
                <td class="tdOrderTotalValue"><?php echo $total_sum_discount ?></td>
            </tr> 
            <tr class="tableRow cupon">
                <td class="tdOrderTotalTitle"><?php echo $section->language->lang009 ?></td> 
                <td class="tdOrderTotalValue"><?php if($find_coupon): ?><?php echo $sum_coupon ?><?php else: ?><?php echo $section->language->lang010 ?><?php endif; ?></td>
            </tr>            
            <tr class="tableRow delivery">
                <td class="tdOrderTotalTitle"><?php echo $section->language->lang011 ?></td> 
                <td class="tdOrderTotalValue"><?php echo $delivery_price ?></td>
            </tr>        
            <tr class="tableRow total">
                <td class="tdOrderTotalTitle"><?php echo $section->language->lang012 ?></td>
                <td class="tdOrderTotalValue"><?php echo $sum_total_order ?></td>
            </tr> 
        </tbody>
    </table>
    </div>
    <div class="b_shop_cart-confirm_client_info">
    <table class="tableClientInfo" cellSpacing="0" cellPadding="0" border="0">
        <tbody class="tableBody">
            <tr class="tableRow name">
                <td class="tdClientInfoTitle">
                    <span><?php echo $section->language->lang013 ?></span>
                </td>             
                <td class="tdClientInfoValue">
                    <span class="order_name"><?php echo $contact_name ?></span>
                </td>
            </tr> 
            <tr id="tr_email" class="tableRow mail">
                <td class="tdClientInfoTitle">                 
                    <span><?php echo $section->language->lang014 ?></span>
                </td>
                <td class="tdClientInfoValue">
                    <span class="order_email"><?php echo $contact_email ?></span>                     
                </td> 
            </tr>             
            <tr id="tr_phone" class="tableRow phone">
                <td class="tdClientInfoTitle">
                    <span><?php echo $section->language->lang015 ?></span>
                </td>
                <td class="tdClientInfoValue">
                    <span class="order_phone"><?php echo $contact_phone ?></span> 
                </td> 
            </tr>
            <tr id="tr_index" class="tableRow index">
                <td class="tdClientInfoTitle">
                    <span><?php echo $section->language->lang016 ?></span>
                </td>
                <td class="tdClientInfoValue">
                    <span class="order_index"><?php echo $contact_post_index ?></span> 
                </td> 
            </tr>
            <tr id="tr_address" class="tableRow address">
                <td class="tdClientInfoTitle">
                    <span><?php echo $section->language->lang017 ?></span>
                </td>
                <td class="tdClientInfoValue">
                    <span class="order_address"><?php echo $contact_address ?></span> 
                </td> 
            </tr>              
        </tbody>
    </table>
    </div>
        
    <div class="b_shop_cart-confirm_delivery">
    <table class="tableDelivery" cellSpacing="0" cellPadding="0" border="0">
        <tbody class="tableBody">
            <tr class="tableRow">
                <td class="tableInfoTitle"><?php echo $section->language->lang018 ?></td> 
                <td class="tdInputInfo">
                    <span class="order_delivery"><?php echo $delivery_name ?></span>
                </td>
            </tr>
            <tr class="tableRow">
                <td class="tableInfoTitle"><?php echo $section->language->lang019 ?></td> 
                <td class="tdInputInfo">
                    <span class="order_payment"><?php echo $payment_name ?></span>
                </td>
            </tr>    
        </tbody>
    </table> 
    </div>
  
    <form class="buttonBlock b_shop_cart-confirm_button_block" action="?<?php echo $time ?>" method="post" enctype="multipart/form-data">
        <button class="btnReturnInCart buttonSend"><?php echo $section->language->lang051 ?></button>
        
        <button class="btnConfirmOrder buttonSend" name="confirm_order" value="<?php echo $section->language->lang020 ?>"><?php echo $section->language->lang020 ?></button>
    </form>
    
</section>
</div>
