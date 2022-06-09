<?php

return array(
    'title'         => __('Header with center menu, button and search icon', 'blockpress'),
    'categories'    => array('blockpress-header'),
    'blockTypes'    => array('core/template-part/header'),
    'viewportWidth' => 1280,
    'content'       => '  
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"25px","bottom":"25px"}}},"backgroundColor":"white","layout":{"inherit":true},"frStickyHeader":false} -->
<div class="wp-block-group alignfull has-white-background-color has-background" style="padding-top:25px;padding-bottom:25px"><!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide"><!-- wp:site-title {"level":0} /-->

<!-- wp:navigation {"isResponsive":true} -->
<!-- wp:navigation-link {"label":"First Item","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Second Item","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Download","url":"#","kind":"custom","isTopLevelLink":true, "className": "is-style-accentbutton fr-soft-rounded fr-cubebtnwhite"} /-->
<!-- /wp:navigation --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"color":{"background":"#f6f7f8"},"spacing":{"padding":{"top":"5px","right":"20px","bottom":"5px","left":"20px"}}},"layout":{"inherit":true},"frStickyHeader":false} -->
<div class="wp-block-group has-background" style="background-color:#f6f7f8;padding-top:5px;padding-right:20px;padding-bottom:5px;padding-left:20px"><!-- wp:group {"align":"wide","layout":{"type":"flex","allowOrientation":false,"justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide"><!-- wp:navigation {"isResponsive":true} /-->

<!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search","buttonText":"Search","buttonPosition":"button-inside","buttonUseIcon":true,"className":"is-style-floating-white-search"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:spacer {"height":10} -->
<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->  
    ',
);
