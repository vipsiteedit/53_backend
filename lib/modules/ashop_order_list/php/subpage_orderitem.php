<?php

list($orderlist, $MANYPAGE) = $plugin_order->getUserOrders((int)$section->parametrs->param2);     

foreach ($orderlist as $line) {
    
    switch ($line['status']) {
        case 'Y': 
            $line['date_pay'] = date('d.m.Y', strtotime($line['date_payee']));
            $line['status_text'] = $section->language->lang035 . ' ' . $line['date_pay']; 
            break;
        case 'K': 
            $line['status_text'] = $section->language->lang036; 
            break;
        case 'P': 
            $line['status_text'] = $section->language->lang037; 
            break;
		case 'W': 
            $line['status_text'] = 'В ожидании'; 
            break;
		case '++': 
            $line['status_text'] = 'Возврат'; 
            break;
        case 'N':
        default: 
            $line['status_text'] = $section->language->lang038;
    }
    
    $line['delivery'] = '-';

    if (!empty($line['delivery_type'])) {
        switch ($line['delivery_status']) {
            case 'Y':
                $line['delivery'] = $section->language->lang039 . ' ' . date('d.m.Y', strtotime($line['delivery_date'])); 
                break;
            case 'P':
                $line['delivery'] = $section->language->lang040; 
                break;
			case 'M':
                $line['delivery'] = $section->language->lang069; 
                break;
            case 'N':
            default:
                $line['delivery'] = $section->language->lang041;
        }
    } 
    
    $line['date'] = date('d.m.Y', strtotime($line['date_order']));
    
    $line['id'] = $line['idorder'];
    $line['urlitem'] = seMultiDir() . '/' . $__data->getPageName() . '/orderpage/' . $line['id'] . SE_END;
    
    $line['id_order'] = sprintf('%06u', $line['idorder']); 
    
    $summ = se_MoneyConvert(($line['price_tovar'] + $line['delivery_payee'] - $line['discount']), $line['curr'], $showcurr, $line['date_order']);
    
    $line['amount'] = se_formatMoney($summ, $showcurr);
    
    if ($line['status'] != 'Y') {
        $line['payments'] = showPaymentList($section, $__MDL_ROOT, $line);
    }
    
    $__data->setItemList($section, 'orderlist', $line);
}

?>