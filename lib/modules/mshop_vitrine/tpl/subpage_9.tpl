<?php if($analogscount!=0): ?>
            <a name="goodsanalogs"></a> 
            <div class="goodsAnalogs goods">
                
                <h3 class="goodsAnalogsHat goodsHat"><?php echo $section->parametrs->param29 ?></h3>
                <div class="goodsNavigator top"><?php echo $SE_NAVIGATOR_SAME ?></div>
                <form style="margin:0px;" method="post" action="">
                    <table border="0" class="tableTable tablePrice" cellSpacing="0" cellPadding="0">
                        <tr class="tableRow tableHeader" valign="top">
                            <?php if($section->parametrs->param145!='N'): ?>
                                
                                <th class="hpicture">
                                    <span class="htitle"><?php echo $section->parametrs->param151 ?></span>
                                </th>
                            <?php endif; ?>
                            <th class="hname">
                                <span class="htitle">
                                    <noindex>
                                        <a class="<?php echo $classsort_n ?>" href="?orderby=<?php echo $order_n ?>#productlst" rel='nofollow'><?php echo $section->parametrs->param172 ?>&nbsp;</a>
                                    </noindex>
                                </span><?php echo $imgsort_n ?>    
                            </th>
                            <?php if($section->parametrs->param146!='N'): ?>
                                
                                <th class="hnote">
                                    <span class="htitle"><?php echo $section->parametrs->param152 ?></span>
                                </th>
                            <?php endif; ?>
                            <?php if($section->parametrs->param147!='N'): ?>
                                
                                <th class="hmanuf">
                                    <span class="htitle">
                                        <noindex>
                                            <a class="<?php echo $classsort_m ?>" href="?orderby=<?php echo $order_m ?>#productlst" rel='nofollow'><?php echo $section->parametrs->param153 ?>&nbsp;</a>
                                        </noindex>
                                    </span><?php echo $imgsort_m ?>
                                </th>
                            <?php endif; ?>
                            <?php if($section->parametrs->param149!='N'): ?>
                                
                                <th class="hpresence">
                                    <span class="htitle"><?php echo $section->parametrs->param156 ?>&nbsp;</span>
                                </th>
                            <?php endif; ?>
                            <?php if($section->parametrs->param143!='N'): ?>
                                <th class="hprice">
                                     
                                    <span class="htitle">
                                        <noindex>
                                            <a class="<?php echo $classsort_p ?>" href="?orderby=<?php echo $order_p ?>#productlst" rel='nofollow'><?php echo $section->parametrs->param158 ?>&nbsp;</a>
                                        </noindex>
                                    </span><?php echo $imgsort_p ?>
                                </th>
                            <?php endif; ?>
                            <th width="15%" class="hcart">&nbsp;</th>
                        </tr>
                        <?php foreach($section->analogs as $record): ?>
                            <?php if(file_exists($__MDL_ROOT."/php/subpage_6.php")) include $__MDL_ROOT."/php/subpage_6.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_6.tpl")) include $__MDL_ROOT."/tpl/subpage_6.tpl"; ?>
                        
<?php endforeach; ?>
                    </table>
                </form>
            </div>
        <?php endif; ?>
