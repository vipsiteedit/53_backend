<table border="0" cellPadding="0" cellSpacing="0" class="tableTable tableListGoods" width="100%">
    <tbody class="tableBody">
        <?php foreach($section->objects as $record): ?>
            <tr class="tableRow itemCart" data-id="<?php echo $record->key ?>">
                <td class="itemImageCart">
                    <a href="<?php echo seMultiDir()."/".$section->parametrs->param1."/" ?><?php echo $record->link ?>" class="b_shop_cart-cart_item_image_link"><img class="b_shop_cart-cart_item_image" src="<?php echo $record->img ?>" alt=""></a>
                </td>
                <td class="itemInfoGoodsCart">
                    <a class="linkname" href="<?php echo seMultiDir()."/".$section->parametrs->param1."/" ?><?php echo $record->link ?>"><?php echo $record->name ?></a>
                    <?php if(!empty($record->paramsname)): ?>
                        <div class="cartitem_params"><?php echo $record->paramsname ?></div>
                    <?php endif; ?>
                    <div class="cartitem_article">
                        <?php echo $section->language->lang052 ?> <span><?php echo $record->article ?></span>
                    </div>
                    <div class="cartitem_presence">
                        <?php echo $section->language->lang053 ?> <span><?php echo $record->presence_count ?></span>
                    </div>
                    <div class="cartitem_price">
                        <?php if(!empty($record->discount)): ?>
                            <span class="itemOldPrice"><?php echo $record->oldprice ?></span>
                        <?php endif; ?>
                        <span class="itemNewPrice"><?php echo $record->newprice ?></span>
                    </div>
                </td>
                <td class="itemCountCart">
                    <div class="cartitem_count">
                        <a href="#" class="b_shop_cart-cartitem_count_button decCountItem" data-action="decrement" style="display:none;">-</a><!--
                        --><input class="cartitem_inputcn" type="text" name="countitem[<?php echo $record->key ?>]" value="<?php echo $record->count ?>" size="3" data-step="<?php echo $record->step ?>"><!--
                        --><a href="#" class="b_shop_cart-cartitem_count_button incCountItem" data-action="increment" style="display:none;">+</a>
                        <span class="measure"><?php echo $record->measure ?></span>
                    </div>
                </td>
                <td class="itemSumCart">
                    <span class="summBlock"><?php echo $record->newsum ?></span>
                </td>
                <td class="itemDeleteCart">
                    <a href="<?php echo seMultiDir()."/".$_page."/" ?>delcartname/<?php echo $record->key ?>/" class="btnDeleteItem b_shop_cart-button_delete_shop_item" title="<?php echo $section->language->lang025 ?>"> </a>
                </td>
            </tr>
        
<?php endforeach; ?>
    </tbody>
</table>
