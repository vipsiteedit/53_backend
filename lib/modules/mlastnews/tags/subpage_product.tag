<noempty:{$products}>
    <repeat:products name=product>
        <div class="product-item">
            <h3 class="product-item-title">[product.name]</h3>
            <div class="product-item-image">
                <img src="[product.image]"></img>
            </div>
            <div class="product-item-description">
                [product.description]
            </div>
            <div class="product-item-buttons">
                <form class="form_addCart" method="post">
                    <input type="hidden" name="addcart" value="[product.id]">
                    <button class="buttonSend">В корзину</button>
                    <a class="" href="[product.url]">Подробнее</a>
                </form>
            </div>
        </div>
    </repeat:products>
</noempty>
