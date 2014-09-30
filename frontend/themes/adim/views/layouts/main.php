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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>title</title>

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
            <h3>Do you have a question for us?</h3>
            <div class="f-f-group">
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <div class="input-group">

                            <input class="form-control" type="text" placeholder="Your email">
                        </div>
                    </div>
                    <div class="form-group">

                        <textarea placeholder="Your message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-send">Sign in</button>
                </form>
            </div>
        </div>
        <div class="column">
            <h3>Follow us:</h3>
            <div class="social">
                <ul>
                    <li class="fb"><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li class="tw"><a href="#"><i class="fa fa-twitter"></i></i></a></li>
                    <li class="vk"><a href="#"><i class="fa fa-vk"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="column">
            <h3>Contact us:</h3>
            <p>T: +971 50 100 6810</p>
            <p>E: sales@macondevillas.com</p>
        </div>
        <div class="column">
            <div class="copy">© ADIMENSION <br />
                DESIGN GROUP 2014</div>
        </div>
    </div>
</div>
</div>

</body>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

            </div>
            <div class="modal-body">
                <div class="form-wrap">
                    <input type="text" class="form-control" placeholder="Your name">
                    <input type="text" class="form-control" placeholder="Your mail">
                    <textarea class="form-control" rows="3" placeholder="Your message"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-modal">MAKE AN ORDER</button>
            </div>
        </div>
    </div>
</div>
</html>