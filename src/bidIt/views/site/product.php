<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\helpers\Url;



echo '
<div class="bg-secondary pb-4 padding-top-3x">
      <div class="container">
        <div class="row">
          <!-- Product Gallery-->
          <div class="col-md-6 mb-30">
            <div class="product-gallery">';
            
            if ($data->status = 1 ){
               echo '<span class="product-badge text-danger">Live</span>';
            } else if ($data->status = 0) {
               echo '<span class="product-badge text-alert">Queue</span>';
            } else {
               echo  '<span style = "color:#dc9814" class="product-badge btn-link-secondary">End</span>';
            }
            echo '
              <div class="product-carousel owl-carousel gallery-wrapper owl-loaded owl-drag" data-pswp-uid="1">
                
              <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1160px;"><div class="owl-item active" style="width: 290px;"><div class="gallery-item" data-hash="one"><a href="#" data-size="555x480"><img src="'.Url::base(true) . $data->image.'" alt="Product"></a></div></div></div>
            
            </div>
          </div>
          <!-- Product Info-->
          <div class="col-md-6 mb-30">
            <div class="card border-default bg-white pt-2 box-shadow">
              <div class="card-body">
                <h2 class="mb-3">'.$data->name.'</h2>
                <h3 class="text-normal">'.$data->price.' LKR</h3>
                <p class="text-sm text-muted">'.$data->description.'</p>
                <div class="row">
                 
                </div>
               
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';




    // <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1160px;"><div class="owl-item active" style="width: 290px;"><div class="gallery-item" data-hash="one"><a href="#" data-size="555x480"><img src="'.Url::base(true) . $data->image.'" alt="Product"></a></div></div><div class="owl-item" style="width: 290px;"><div class="gallery-item" data-hash="two"><a href="img/shop/single/02.jpg" data-size="555x480"><img src="img/shop/single/02.jpg" alt="Product"></a></div></div><div class="owl-item" style="width: 290px;"><div class="gallery-item" data-hash="three"><a href="' .Url::base(true) . $data->image. '" data-size="555x480"><img src="' .Url::base(true) . $data->image. '" alt="Product"></a></div></div><div class="owl-item" style="width: 290px;"><div class="gallery-item" data-hash="four"><a href="' .Url::base(true) . $data->image. '" data-size="555x480"><img src="' . Url::base(true) . $data->image. '" alt="Product"></a></div></div></div></div><div class="owl-nav disabled"><div class="owl-prev">prev</div><div class="owl-next">next</div></div><div class="owl-dots disabled"></div></div>
    //           <ul class="product-thumbnails">
    //             <li class="active"><a href="#one"><img src="img/shop/single/th01.jpg" alt="Product"></a></li>
    //             <li><a href="#two"><img src="img/shop/single/th02.jpg" alt="Product"></a></li>
    //             <li><a href="#three"><img src="img/shop/single/th03.jpg" alt="Product"></a></li>
    //             <li><a href="#four"><img src="img/shop/single/th04.jpg" alt="Product"></a></li>
    //           </ul>