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
        <div class="logo"><a href="#"><img src="images/logo.png" alt="" /></a></div>
        <div class="center-name"><img src="images/c-name.png" alt="" /></div>
        <div class="language">
            <ul>
                <li><a href="#" class="active">en</a></li>
                <li><a href="#">ru</a></li>
                <li><a href="#">uk</a></li>
            </ul>
        </div>
    </div>
</div><!-- .header -->
<div class="menu">
    <div class="container">
        <nav><ul class="nav-top inner">
                <?=CHtml::tag('li',array(), CHtml::link('Home',array('/')))?>
                <?=CHtml::tag('li',array(), CHtml::link('ABOUT COMPANY',array('site/about')))?>
                <?=CHtml::tag('li',array(), CHtml::link('GALLERY',array('/site/gallery')))?>
                <?=CHtml::tag('li',array(), CHtml::link('PRINCIPLES',array('/site/principles')))?>
                <?=CHtml::tag('li',array(), CHtml::link('PARTNERS',array('/site/partners')))?>
                <?=CHtml::tag('li',array(), CHtml::link('CONTACTS',array('/site/contacts')))?>
            </ul>
        </nav>
    </div>
</div>