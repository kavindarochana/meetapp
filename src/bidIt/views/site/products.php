<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;



echo '
<div class="page-title">
      <div class="container">
        <h1>Product List</h1>
        
      </div>
    </div>
    <!-- Page Content-->
    <div class="container padding-bottom-3x mb-2">
      <div class="row">';

foreach ($list as $i) {
echo
            '<div class="col-sm-6 mb-30"><a class="category-card flex-wrap text-center pt-0" href="#">
                <div class="category-card-thumb w-100"><img src="'.Url::base(true).$i->image.'" alt="' . $i->name . '"></div>
                <div class="category-card-info w-100">
                  <h3 class="category-card-title">' . $i->name . '</h3>
                  <h4 class="category-card-subtitle">Started from <b>' . $i->price . '</b> LKR</h4>'; 
                  if (1 * $i->winId !== 0) {
                      echo '
                    <h4 class="category-card-subtitle">Won by <div class="d-inline text-success"><b>'. $i->winner .'</b></div></h4>
                    <h4 class="category-card-subtitle">Wining bid <b>'. $i->winner_bid .'</b> LKR</h4>';
                  } 
                  else {
                    echo '
                    <h4 class="category-card-subtitle"> <div style="color:#dc9814" class="d-inline text-alert"><b>No winner</b></div></h4>
                  <h4 class="category-card-subtitle">Wining bid <b> - </b> </h4>';
                  }
                  echo '
                </div></a></div>';
}
echo                
    '</div>';




?>
