<?php if(!empty($path_list)): ?>    
    <div class="groupPath" itemscope itemtype="http://schema.org/BreadcrumbList">
        <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a class="lnkPath" href="home.html" itemprop="item"><span itemprop="name"><?php echo $section->language->lang007 ?></span></a>
            <meta itemprop="position" content="1">
        </span>
        <span class="separPath"><?php echo $section->parametrs->param17 ?></span>
        <?php foreach($section->pathgroup as $path): ?> 
            <?php if($path->link!=''): ?>
                <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a class="lnkPath" href="<?php echo $path->link ?>" itemprop="item"><span itemprop="name"><?php echo $path->name ?></span></a>
                    <meta itemprop="position" content="<?php echo $path->pos ?>">
                </span>
            <?php else: ?>
                <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <span class="lnkPath" itemprop="name"><?php echo $path->name ?></span>
                    <meta itemprop="position" content="<?php echo $path->pos ?>">
                </span>
            <?php endif; ?>
            <?php if(!empty($path->separator)): ?>
                <span class="separPath"><?php echo $path->separator ?></span>
            <?php endif; ?>
        
<?php endforeach; ?>
    </div>
<?php endif; ?>
