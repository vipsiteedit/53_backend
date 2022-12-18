<header:css>
    [include_css]
</header:css>
<footer:js>
    [js:jquery/jquery.min.js]
    [include_js]
</footer:js>
<div class="<?php if(strval($section->parametrs->param1)=='n'): ?>container<?php else: ?>container-fluid<?php endif; ?>">
    <div class="content ashop_order_list row" >
        <div class="invitation col-xs-12 col-md-12">
            <div class="cabinet-tab-header">
                <div class="ordertr">
                    <div class="ordertd ordertd_order" data-title="<?php echo $section->language->lang045 ?>">
                        <span><?php echo $section->language->lang045 ?></span>
                    </div>
                    <div class="ordertd ordertd_date" data-title="<?php echo $section->language->lang046 ?>">
                        <span><?php echo $section->language->lang046 ?></span>
                    </div>
                    <div class="ordertd ordertd_price" align="right" data-title="<?php echo $section->language->lang047 ?>">
                        <span><?php echo $section->language->lang047 ?></span>
                    </div>
                    <div class="ordertd ordertd_delivery" data-title="<?php echo $section->language->lang048 ?>">
                        <span><?php echo $section->language->lang048 ?></span>
                    </div>
                    <div class="ordertd ordertd_status" data-title="<?php echo $section->language->lang049 ?>">
                        <span><?php echo $section->language->lang049 ?></span>
                    </div>
                </div>
            </div>
            <div id="cabinet-tabs" class="lnkout">
                <?php if(file_exists($__MDL_ROOT."/php/subpage_orderitem.php")) include $__MDL_ROOT."/php/subpage_orderitem.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_orderitem.tpl")) include $__data->include_tpl($section, "subpage_orderitem"); ?>
            </div>
            <?php echo $MANYPAGE ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
