<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 30.09.14
 * Time: 3:20
 * To change this template use File | Settings | File Templates.
 */
?>
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
        <nav><ul class="nav-top inner">
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