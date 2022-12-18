<?php foreach($section->orderlist as $order): ?>
<div class="cabinet-tab">
    <div class="ordertr">
        <div class="ordertd ordertd_order" data-title="<?php echo $section->language->lang045 ?>">
            <div><?php echo $section->language->lang045 ?></div>
            <a href="<?php echo $order->urlitem ?>"><?php echo $order->id_order ?></a>
        </div>
        <div class="ordertd ordertd_date" data-title="<?php echo $section->language->lang046 ?>">
            <div><?php echo $section->language->lang046 ?></div>
            <span><?php echo $order->date ?></span>
        </div>
        <div class="ordertd ordertd_price" align="right" data-title="<?php echo $section->language->lang047 ?>">
            <div><?php echo $section->language->lang047 ?></div>
            <span class="orderPrice"><?php echo $order->amount ?></span>
        </div>
        <div class="ordertd ordertd_delivery" data-title="<?php echo $section->language->lang048 ?>">
            <div><?php echo $section->language->lang048 ?></div>
            <span><?php echo $order->delivery ?></span>
        </div>
        <div class="ordertd ordertd_status" data-title="<?php echo $section->language->lang049 ?>">
            <div><?php echo $section->language->lang049 ?></div>
            <?php if($order->status=='N'): ?>
                <button class="btn-default pay-order-btn"><?php echo $section->language->lang034 ?></button>
            <?php else: ?>
                <span class="payment_status"><?php echo $order->status_text ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="tab-content">
    <?php echo $order->payments ?>
</div>

<?php endforeach; ?>
