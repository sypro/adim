<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 30.09.14
 * Time: 4:07
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="container">
    <h1 class="page-title">Principles of operation</h1>
    <div class="col-sm-9">
        <div class="row">
            <?php foreach($model as $row):?>
            <div class="col-sm-4">
                <div class="princ-w">
                    <div class="circle-w"><?=\fileProcessor\helpers\FPM::image($row->image_id,'page','partners')?></div>
                    <div class="c-w-name"><p><?=$row->label?></p></div>
                </div>
            </div>
            <?php endforeach ?>

            <div class="col-sm-4">
                <div class="princ-w">
                    <div class="circle-w"><img src="images/sergo.png" /></div>
                    <div class="c-w-name"><p>SERGO, <br />Everything for your house</p></div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="princ-w">
                    <div class="circle-w"><img src="images/flats.png" /></div>
                    <div class="c-w-name"><p>Flats & Doors</p></div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="princ-w">
                    <div class="circle-w"><img src="images/friends.png" /></div>
                    <div class="c-w-name"><p>ARMONI</p></div>
                </div>
            </div>


        </div>
    </div>
    <div class="col-sm-3">
        <div class="t-order">
            <h1>BELIEVE </h1>
            <h3>professionals </h3>
            <h4>and immediately </h4>
            <a href="#" class="btn btn-order" data-toggle="modal" data-target="#myModal">MAKE AN ORDER</a>
        </div>
    </div>
</div>