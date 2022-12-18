<header:css>
    [include_css]
</header:css>
<div class="<?php if(strval($section->parametrs->param1)=='n'): ?>container<?php else: ?>container-fluid<?php endif; ?>">
    <div class="content ashop_order_list order_page row" >
        <div class="invitation col-xs-12 col-md-12">
            <div class="ashop-header-text">Заказ № <?php echo $order_num ?></div>
            <div class="cabinet-tab-header">
                <div class="ordertr">
                    <div class="ordertd ordertd_order" data-title="№">
                        <span>№</span>
                    </div>
                    <div class="ordertd ordertd_date" data-title="<?php echo $section->language->lang051 ?>">
                        <span><?php echo $section->language->lang051 ?></span>
                    </div>
                    <div class="ordertd ordertd_price" align="right" data-title="<?php echo $section->language->lang052 ?>">
                        <span><?php echo $section->language->lang052 ?></span>
                    </div>
                    <div class="ordertd ordertd_delivery" data-title="<?php echo $section->language->lang053 ?>">
                        <span><?php echo $section->language->lang053 ?></span>
                    </div>
                    <div class="ordertd ordertd_status" data-title="<?php echo $section->language->lang054 ?>">
                        <span><?php echo $section->language->lang054 ?></span>
                    </div>
                    <div class="ordertd ordertd_status" data-title="<?php echo $section->language->lang055 ?>">
                        <span><?php echo $section->language->lang055 ?></span>
                    </div>
                </div>
            </div>
            <div id="cabinet-tabs" class="lnkout">
                <?php if(file_exists($__MDL_ROOT."/php/subpage_orderpageitem.php")) include $__MDL_ROOT."/php/subpage_orderpageitem.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_orderpageitem.tpl")) include $__data->include_tpl($section, "subpage_orderpageitem"); ?>
            </div>
            
            <?php if($delivery_type): ?>
            <div class="block-delivery-info cabinet-tab">
                <div class="title-delivery ashop-header-text"><span><?php echo $section->language->lang064 ?></span></div>
                <div class="ordertr">
                    <div class="ordertd"><span><?php echo $section->language->lang062 ?></span></div>
                    <div class="ordertd"><span><?php echo $delivery_name ?></span></div>
                </div>
                <div class="ordertr">
                    <div class="ordertd"><span><?php echo $section->language->lang055 ?></span></div>
                    <div class="ordertd"><span><?php echo $delivery_sum ?></span></div>
                </div>
                <div class="ordertr">
                    <div class="ordertd"><span><?php echo $section->language->lang063 ?></div>
                    <div class="ordertd"><span><?php echo $delivery_status ?></span></div>
                </div>
            </div>
            <?php endif; ?>
            <?php if($order_paid): ?>
            <div class="block-paid-info cabinet-tab">
                <div class="title-paid ashop-header-text"><span><?php echo $section->language->lang065 ?></span></div>
                <div class="ordertr">
                    <div class="ordertd"><span><?php echo $section->language->lang066 ?></span></div>
                    <div class="ordertd"><span><?php echo $payment_name ?></span></div>
                </div>
                <div class="ordertr">
                    <div class="ordertd"><span><?php echo $section->language->lang067 ?></span></div>
                    <div class="ordertd"><span><?php echo $transact_id ?></span></div>
                </div>
                <div class="ordertr">
                    <div class="ordertd"><span><?php echo $section->language->lang068 ?></span></div>
                    <div class="ordertd"><span><?php echo $payment_sum ?></span></div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="result-orderpage">
                <div class="ashop-header-text"><?php echo $section->language->lang056 ?> <?php echo $discount ?></div>
                <div class="ashop-header-text"><?php echo $section->language->lang057 ?> <?php echo $amount ?></div>
            </div>
            
            <div class="navigation-orderpage">
                <form action="<?php echo seMultiDir()."/".$_page."/" ?>" method="post">
                    <button class="btn-default"><?php echo $section->language->lang058 ?></button>
                    <?php if($show_cancel): ?>
                    <input type="hidden" name="order" value="<?php echo $order_id ?>">
                    <button class="btn-default" name="delete_order"><?php echo $section->language->lang059 ?></button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <div class="clearfix"</div>
    </div>
    <div class="clearfix"></div>
</div>
