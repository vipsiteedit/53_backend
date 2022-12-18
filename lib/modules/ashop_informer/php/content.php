<?php

if($user_id){   
    $count_wish = $psg->getGoodsWishCount($user_id);
}else{
    $count_wish = 0;
}

$count_compare = $plugin_compare->getCountAllCompare();
    
$count_cart = $total_cart['count'];
?>
