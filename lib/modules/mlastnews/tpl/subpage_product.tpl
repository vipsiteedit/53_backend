<?php if(!empty($products)): ?>
    <?php foreach($section->products as $product): ?>
        <div class="product-item">
            <h3 class="product-item-title"><?php echo $product->name ?></h3>
            <div class="product-item-image">
                <img src="<?php echo $product->image ?>"></img>
            </div>
            <div class="product-item-description">
                <?php echo $product->description ?>
            </div>
            <div class="product-item-buttons">
                <form class="form_addCart" method="post">
                    <input type="hidden" name="addcart" value="<?php echo $product->id ?>">
                    <button class="buttonSend">В корзину</button>
                    <a class="" href="<?php echo $product->url ?>">Подробнее</a>
                </form>
            </div>
        </div>
    
<?php endforeach; ?>
<?php endif; ?>
