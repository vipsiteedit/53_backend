<header:css>
    [include_css]
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
</header:css>
<footer:js>
[js:jquery/jquery.min.js]
[include_js()]
</footer:js>
<div class="<?php if(strval($section->parametrs->param1)=='n'): ?>container<?php else: ?>container-fluid<?php endif; ?>">
<section class="content ashop_user_pers row">
    <?php if(!empty($section->title)): ?>
    <h3 class="contentTitle"><span class="contentTitleTxt"><?php echo $section->title ?></span></h3>
    <?php endif; ?>
    <?php if(!empty($section->image)): ?>
    <img border="0" class="contentImage" src="<?php echo $section->image ?>" alt="<?php echo $section->image_alt ?>" title="<?php echo $section->image_alt ?>">
    <?php endif; ?>
    <?php if(!empty($section->text)): ?>
    <div class="contentText"><?php echo $section->text ?></div>
    <?php endif; ?>
    <div class="contentBody">
        <div class="avatar-block">
            <?php if(!empty($avatar)): ?>
            <div class="user-avatar">
                <img src="<?php echo $avatar ?>">
            </div>
            <?php endif; ?>
        </div>
        <div class="user-fullname">
                <span class="user-lastname"><?php echo $last_name ?></span>
                <span class="user-firstname"><?php echo $first_name ?></span>
                <span class="user-secname"><?php echo $sec_name ?></span>
                <a class="lnkLogout btn btn-link" href="?logout"><?php echo $section->language->lang002 ?></a>
        </div>
        <div class="personal-block">
            <a class="lnkPersonal btn btn-link" href="<?php echo $personallink ?>"><?php echo $section->language->lang003 ?>
                <i class="fa fa-pencil" aria-hidden="true"></i>
            </a>
            <a class="lnkPassword btn btn-link" href="<?php echo $passwlink ?>"><?php echo $section->language->lang004 ?>
                <i class="fa fa-lock" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>
</div>
