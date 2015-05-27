<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 30.09.14
 * Time: 3:20
 * To change this template use File | Settings | File Templates.
 */
?>

<?php 
cs()->registerScript('
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter30417042 = new Ya.Metrika({id:30417042,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/30417042" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
'); ?> 

<div class="header">
    <div class="container">
        <div class="logo"><a href="/"><img src="/images/logo.png" alt="" /></a></div>
        <div class="center-name"><img src="/images/c-name.png" alt="" /></div>
        <div class="language">
            <ul>
                <?php $this->widget(\language\widgets\languageChecker\LanguageChecker::getClassName())?>
            </ul>
        </div>
    </div>
</div><!-- .header -->
<div class="menu">
    <div class="container">
        <nav class="cl-effect-1"><ul class="nav-top inner">
                <li><a href="/"><?=t('HOME')?></a></li>
                <?php //CHtml::tag('li',array(), CHtml::link(t('Home222'),array(Yii::app()->request->baseUrl)))?>
                <?=CHtml::tag('li',array(), CHtml::link(t('ABOUT COMPANY'),array('site/about')))?>
                <?=CHtml::tag('li',array(), CHtml::link(t('GALLERY'),array('/site/gallery')))?>
                <?=CHtml::tag('li',array(), CHtml::link(t('PRINCIPLES'),array('/site/principles')))?>
                <?=CHtml::tag('li',array(), CHtml::link(t('PARTNERS'),array('/site/partners')))?>
                <?=CHtml::tag('li',array(), CHtml::link(t('CONTACTS'),array('/site/contacts')))?>
            </ul>
        </nav>
    </div>
</div>