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

            <?php

            $i=1;
            $j=1;
            $a = array_chunk($model,3);
            
            foreach($a as $b){
                foreach($b as $row){
                     ?>
                        <div class="princ">
                            <div class="circle-grey"><?=\fileProcessor\helpers\FPM::image($row->image_id,'page','principles',$row->label)?>
                                <div class="c-overlay">
                                    <p><?=$row->announce ?></p>
                                </div>
                        </div>

                        <p><?=$row->label ?></p>
                        <?php
                        // echo ' <div class="arrow-down"><img src="/images/arrow.png" /></div>';
                        // if($j%3 == 0 && count($b)%3==0) echo ' <div class="arrow-down"><img src="/images/arrow.png" /></div>';
                        ?>
                    </div>

                    <?php
                    // if($i%3 == 0 && $i<count($model)) echo ' <div class="arrow-down"><img src="/images/arrow.png" /></div>';
                    
                    if($i%3!=0 && $j<3){
                        if($i%2 != 0 ){
                                echo '<div class="arrow"><img src="/images/arrow.png" /></div>'; 
                            }
                            else{ 
                                echo '<div class="arrow left"><img src="/images/arrow.png" /></div>';
                            }
                        }
                    $j++;
                }
                $j=0;
                $i++;
            }



            ?>

        </div>
    </div>
    <?php echo $this->renderPartial('_order');  ?>

</div>


