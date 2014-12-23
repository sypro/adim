<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 30.09.14
 * Time: 4:09
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="container">
    <h1 class="page-title"><?=t('Principles of operation')?></h1>
    <div class="col-sm-9">
        <div class="row">
            <div class="princ">
                <div class="circle-grey"><img src="images/meet.png" /><div class="c-overlay"><p><?=config('PRINCIPLES_TEXT_1')?></p></div></div>

                <p><?=t('Meeting the client')?></p>
            </div>
            <div class="arrow"><img src="images/arrow.png" /></div>
            <div class="princ">
                <div class="circle-grey"><img src="images/design.png" /><div class="c-overlay"><p><?=config('PRINCIPLES_TEXT_2')?></p></div></div>

                <p><?=t('Design assignment (formed on the basis of the customer\'s wishes')?> </p>
            </div>
            <div class="arrow"><img src="images/arrow.png" /></div>
            <div class="princ">
                <div class="circle-grey"><img src="images/project.png" /><div class="c-overlay"><p><?=config('PRINCIPLES_TEXT_3')?></p></div></div>

                <p><?=t('Project')?> </p>
                <div class="arrow-down"><img src="images/arrow.png" /></div>
            </div>

            <div class="princ">
                <div class="circle-grey"><img src="images/friends.png" /><div class="c-overlay"><p><?=config('PRINCIPLES_TEXT_4')?></p></div></div>

                <p><?=t('Remain good friends with the customer')?></p>
            </div>
            <div class="arrow left"><img src="images/arrow.png" /></div>
            <div class="princ">
                <div class="circle-grey"><img src="images/date.png" /><div class="c-overlay"><p><?=config('PRINCIPLES_TEXT_5')?></p></div></div>

                <p><?=t('Release Date')?> </p>
            </div>
            <div class="arrow left"><img src="images/arrow.png" /></div>
            <div class="princ">
                <div class="circle-grey"><img src="images/tools.png" /><div class="c-overlay"><p><?=config('PRINCIPLES_TEXT_6')?></p></div></div>
                <p><?=t('Author\'s support of the project and the client')?> </p>

            </div>
        </div>
    </div>
    <?php echo $this->renderPartial('_order');  ?>

</div>