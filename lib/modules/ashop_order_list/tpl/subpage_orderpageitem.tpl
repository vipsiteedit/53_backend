<?php foreach($section->orderpagelist as $orderpage): ?>
<div class="cabinet-tab">
    <div class="ordertr">
        <div class="ordertd" data-title="№">
            <div>№</div>
            <span><?php echo $orderpage->id ?></span>
        </div>
        <div class="ordertd" data-title="<?php echo $section->language->lang051 ?>">
            <div><?php echo $section->language->lang051 ?></div>
            <span><?php echo $orderpage->article ?></span>
        </div>
        <div class="ordertd" align="right" data-title="<?php echo $section->language->lang052 ?>">
            <div><?php echo $section->language->lang052 ?></div>
            <span class="orderPrice"><?php echo $orderpage->name ?></span>
        </div>
        <div class="ordertd" data-title="<?php echo $section->language->lang053 ?>">
            <div><?php echo $section->language->lang053 ?></div>
            <span><?php echo $orderpage->price ?></span>
        </div>
        <div class="ordertd" data-title="<?php echo $section->language->lang054 ?>">
            <div><?php echo $section->language->lang054 ?></div>
            <span><?php echo $orderpage->count ?></span>
        </div>
        <div class="ordertd" data-title="<?php echo $section->language->lang055 ?>">
            <div><?php echo $section->language->lang055 ?></div>
            <span><?php echo $orderpage->amount ?></span>
        </div>
    </div>
</div>

<?php endforeach; ?>
