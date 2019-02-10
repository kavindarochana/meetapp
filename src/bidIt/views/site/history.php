<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

echo '
<div class="page-title">
      <div class="container">
        <h1>Bid History</h1>
        
      </div>
    </div>
    <!-- Page Content-->
    <div class="container padding-bottom-3x mb-2">
      <div class="row">
       
        <div class="col-lg-8">
          <div class="table-responsive text-sm">
            <table class="table table-hover margin-bottom-none">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Date</th>
                  <th>Type</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
              '; 
               foreach ($data as $i) {
               echo ' <tr>
                  <td class="align-middle"><a class="text-medium navi-link" href="#" data-toggle="modal" data-target="#orderDetails">'.$i['name'].'</a></td>
                  <td class="align-middle">'. $i['date']. '</td>
                  <td class="align-middle"> ' ;
                  echo  $i['type'] == 1 ? '<span style = "border-radius: 10px;" class="dd-inline-block bg-info text-white text-xs p-1">Buy</span>' 
                  : '<span style = "border-radius: 10px;" class="dd-inline-block bg-warning text-white text-xs p-1"> Bid</span>';
                  
                  echo '</td>
                  <td class="align-middle"><span class="text-medium">' . $i['bid_price'] . '</span></td>
                </tr>';
              } 
             echo  '
              </tbody>
            </table>
          </div>
          <hr class="mb-3">
        </div>
      </div>
    </div> ';

    // <div class="text-right"><a class="btn btn-outline-secondary mb-0" href="#"><i class="material-icons file_download"></i>&nbsp;Order Details</a></div>
        
  //   <ul class="breadcrumbs">
  //   <li><a href="index.html">Home</a>
  //   </li>
  //   <li class="separator">&nbsp;/&nbsp;</li>
  //   <li><a href="account-orders.html">Account</a>
  //   </li>
  //   <li class="separator">&nbsp;/&nbsp;</li>
  //   <li>Bid History</li>
  // </ul>

    // <tr>
    //               <td class="align-middle"><a class="text-medium navi-link" href="#" data-toggle="modal" data-target="#orderDetails">34VB5540K83</a></td>
    //               <td class="align-middle">July 21, 2017</td>
    //               <td class="align-middle"><span class="d-inline-block bg-info text-white text-xs p-1">In Progress</span></td>
    //               <td class="align-middle"><span class="text-medium">$665.32</span></td>
    //             </tr>
    //             <tr>
    //               <td class="align-middle"><a class="text-medium navi-link" href="#" data-toggle="modal" data-target="#orderDetails">112P45A90V2</a></td>
    //               <td class="align-middle">June 15, 2017</td>
    //               <td class="align-middle"><span class="d-inline-block bg-warning text-white text-xs p-1">Delayed</span></td>
    //               <td class="align-middle"><span class="text-medium">$1,264.00</span></td>
    //             </tr>
    //             <tr>
    //               <td class="align-middle"><a class="text-medium navi-link" href="#" data-toggle="modal" data-target="#orderDetails">28BA67U0981</a></td>
    //               <td class="align-middle">May 19, 2017</td>
    //               <td class="align-middle"><span class="d-inline-block bg-success text-white text-xs p-1">Delivered</span></td>
    //               <td class="align-middle"><span class="text-medium">$198.35</span></td>
    //             </tr>
    //             <tr>
    //               <td class="align-middle"><a class="text-medium navi-link" href="#" data-toggle="modal" data-target="#orderDetails">502TR872W2</a></td>
    //               <td class="align-middle">April 04, 2017</td>
    //               <td class="align-middle"><span class="d-inline-block bg-success text-white text-xs p-1">Delivered</span></td>
    //               <td class="align-middle"><span class="text-medium">$2,133.90</span></td>
    //             </tr>
    //             <tr>
    //               <td class="align-middle"><a class="text-medium navi-link" href="#" data-toggle="modal" data-target="#orderDetails">47H76G09F33</a></td>
    //               <td class="align-middle">March 30, 2017</td>
    //               <td class="align-middle"><span class="d-inline-block bg-success text-white text-xs p-1">Delivered</span></td>
    //               <td class="align-middle"><span class="text-medium">$86.40</span></td>
    //             </tr>