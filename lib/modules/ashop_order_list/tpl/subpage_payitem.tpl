<div class="paySelect">
    <div class="ashop-header-text"><?php echo $section->language->lang043 ?></div>
    <div class="ashop-header-text order-summ"><?php echo $section->language->lang044 ?> <?php echo $order_amount ?></div>
    <?php foreach($section->paymentlist as $item): ?>
        <div class="obj">
            <a class="objectImageArea" href="<?php echo $item->invnum ?>" title="<?php echo $item->name_payment ?>"><img class="objectImage" src="<?php echo $item->image ?>"></a>
            <div class="objectNote"><?php echo $item->note ?></div>
        </div>
    
<?php endforeach; ?>
</div>
