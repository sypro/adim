<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 30.09.14
 * Time: 2:41
 * To change this template use File | Settings | File Templates.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->getPageTitle()?></title>

    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php
    cs()->registerPackage('theme.adim');
    cs()->registerPackage('frontend.main');
    ?>
</head>
<body>

<?php echo $content; ?>
<div class="footer">
    <div class="container">
        <div class="column-first">
            <h3><?=t('Do you want site like this?')?></h3>

            <div class="f-f-group">
                <form action="/site/newsite" method="get" class="form-inline site-builders" role="form">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" placeholder="<?=t('Name')?>">
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="<?=t('Email')?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-send"><?=t('Send')?></button>
                </form>
            </div>
        </div>
        <div class="column">
            <h3><?=t('Follow us')?>:</h3>
            <div class="social">
                <ul>
                    <li class="fb"><a href="<?=config('fb')?>"><i class="fa fa-facebook"></i></a></li>
                    <li class="tw"><a href="<?=config('tw')?>"><i class="fa fa-twitter"></i></i></a></li>
                    <li class="vk"><a href="<?=config('vk')?>"><i class="fa fa-vk"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="column">
            <h3><?=t('Contact us')?>:</h3>
            <p>T: <?=config('PHONE')?></p>
            <p>E: <?=CHtml::mailto( config("EMAIL"), config("EMAIL"))?></p>
        </div>
        <div class="column">
            <div class="copy">© ADIMENSION <br />
                DESIGN GROUP 2014</div>
        </div>
    </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php $this->widget(\frontend\widgets\OrderForm::getClassName())?>
        </div>
    </div>
</div>
</body>

</html>
