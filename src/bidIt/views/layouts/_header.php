<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
    <meta charset="<?=Yii::$app->charset?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <?=Html::csrfMetaTags()?>
    <title><?=Html::encode($this->title)?></title>
    <?php $this->head()?>
    <!-- SEO Meta Tags-->
    <meta name="description" content="Unishop - Universal E-Commerce Template">
    <meta name="keywords" content="shop, e-commerce, modern, flat style, responsive, online store, business, mobile, blog, bootstrap 4, html5, css3, jquery, js, gallery, slider, touch, creative, clean">
    <meta name="author" content="Rokaux">
    <!-- Mobile Specific Meta Tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Favicon and Apple Icons-->
    <link rel="icon" type="image/x-icon" href="unishop/v3.0/template-2/favicon.ico">
    <link rel="icon" type="image/png" href="unishop/v3.0/template-2/favicon.png">
    <link rel="apple-touch-icon" href="unishop/v3.0/template-2/touch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="152x152" href="unishop/v3.0/template-2/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="180x180" href="unishop/v3.0/template-2/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="167x167" href="unishop/v3.0/template-2/touch-icon-ipad-retina.png">
    <!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="unishop/v3.0/template-2/css/vendor.min.css">
    <!-- Main Template Styles-->
    <link id="mainStyles" rel="stylesheet" media="screen" href="unishop/v3.0/template-2/css/styles.min.css">
    <!-- Customizer Styles-->
    <link rel="stylesheet" media="screen" href="unishop/v3.0/template-2/customizer/customizer.min.css">
    <!-- Google Tag Manager-->
    <!-- Modernizr-->
    <script src="unishop/v3.0/template-2/js/modernizr.min.js"></script>
    <!-- <script data-require="jquery@*" data-semver="2.0.3" src="js/jquery-2.0.3.min.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/jquery.growl.js" type="text/javascript"></script>
    <link href="css/jquery.growl.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>




    <!-- <style>
    div#w0-success-0 {
      opacity: 1 !important;
    }
    .toast {
      opacity: 1 !important;
    }

    #toast-container > div {
      opacity: 1 !important;
    }
    div#w0-success-0 {
    bottom: -9px;
}
    </style> -->
</head>
<body>


<script type="text/javascript">
var ul = "'" + <?php Url::base(true); ?> + "'";

$(document).on("click", "#eee", function () {
    console.log('Ok');
    var myImageId = $(this).data('id');
    var pack = $(this).data('pack');
    var name = $(this).data('name');
    var price = $(this).data('price');
    var validity = $(this).data('validity');
    var qty = $(this).data('qty');
    console.log(pack);
    $(".modal-body #myImage").attr("src", myImageId);
    $('.modal-body #model-price').html(price);
    $('.modal-body #model-bid-amount').html(qty);
    $('.modal-body #model-validity').html('Unimited');
    $('.modal-body #model-name').html(name);

    
    $('#aqw').on('click', function (event) {
      
      $.ajax({
       url: '<?php echo Yii::$app->request->baseUrl. '/index.php?r=site/purchase' ?>',
       type: 'post',
       data: {
                 msisdn:'<?=$this->params['user']->cust->msisdn;?>', 
                 pack:pack , 
                 _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
             },
       success: function (data) {
          console.log('a');
          window.location='<?="index.php?msisdn=".$this->params['user']->cust->msisdn;?>';

          //this.redirect;
       }
  });
});
    
});
</script>

// Pack Purchase Model
<div class="modal fade" id="gardenImage" tabindex="-1" role="dialog" aria-labelledby="gardenImageLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
            <h4 class="product-title" id = "model-name"></h4>
            <div class="product-item"><a><img id="myImage" class="img-responsive" src="" alt=""></a></div>
                <ul class="list-unstyled text-sm mb-4">
                  <li><span class="text-dark text-medium">Price: </span> <span id = "model-price"></span>LKR</li>
                  <li><span class="text-dark text-medium">Bids: </span><span id = "model-bid-amount"></span> bids</li>
                  <li><span class="text-dark text-medium">Validity: </span> <a href="#" class="navi-link"><span id = "model-validity"></span></a></li>
                </ul>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             <button type="button" id = "aqw" class="btn btn-primary">Purchase</button>
            </div>
        </div>
    </div>
</div>


<noscript>
      <iframe src="index.html" height="0" width="0" style="display: none; visibility: hidden;"></iframe>
    </noscript>
    <!-- Template Customizer-->
    <div class="customizer-backdrop"></div>
    <!-- Navbar-->
    <!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page.-->
    <header class="navbar navbar-sticky">
      <!-- Site Branding-->
      <div class="site-branding"><a class="site-logo hidden-xs-down" href="<?=Url::to(["site/index"]) .'&msisdn='. $this->params['user']->cust->msisdn ?>"><img src="unishop/v3.0/template-2/img/logo/logo.png" alt="Unishop"></a><a class="site-logo logo-sm hidden-sm-up" href="<?=Url::to(["site/index"]).'&msisdn='.$this->params['user']->cust->msisdn?>"><img style = "max-width: 120px; max-height: 36px;" src="unishop/v3.0/template-2/img/logo/logo-sm.png" alt="Unishop"></a>
        <div class="lang-currency-switcher">
          <div class="lang-currency-toggle"><img src="unishop/v3.0/template-2/img/flags/GB.png" alt="English"><span>USD</span><i class="material-icons arrow_drop_down"></i>
          </div>
        </div>
      </div>
      <!-- Main Navigation-->
      <nav class="site-menu">
        <ul>
          <li class="active"><a href="<?=Url::to(["site/index"]) . '&msisdn=' . $this->params['user']->cust->msisdn?>"><span>Home</span></a>
            
          </li>

          <li><a href="#"><span>Account</span></a>
            <ul class="sub-menu">
      
                <li><a href="<?=Url::to(["site/history"]).'&msisdn='.$this->params['user']->cust->msisdn?>">Bid History</a></li>
               
            </ul>
          </li>

        </ul>
      </nav>
      <!-- Toolbar-->
      <div class="toolbar">
        <div class="inner"><a class="toolbar-toggle mobile-menu-toggle" href="#mobileMenu"><i class="material-icons menu"></i></a><a class="toolbar-toggle search-toggle" href="#search"><i class="material-icons search"></i></a><a class="toolbar-toggle" href="#account"><i class="material-icons person"></i></a><a class="toolbar-toggle" href="#cart"><i><span class="material-icons shopping_basket"></span><span style = "display: table; border-radius: 39%; right: -12px;" class="count"><?=$this->params['user']->bid_balance+$this->params['user']->daily_bid_balance;?></span></i></a></div>
        <!-- Toolbar Dropdown-->
        <div class="toolbar-dropdown">
          <!-- Mobile Menu Section-->
          <div class="toolbar-section" id="mobileMenu">
            <!-- Slideable (Mobile) Menu-->
            <nav class="slideable-menu mt-4">
              <ul class="menu">
                <li class=""><span><a href="<?=Url::to(["site/index"]) .'&msisdn='. $this->params['user']->cust->msisdn?>"><span>Home</span></a><span class="sub-menu-toggle"></span></span>

                </li>
                <li class="has-children"><span><a href="#"><span>Products</span></a><span class="sub-menu-toggle"></span></span>
                  <ul class="slideable-submenu">
                      <li><a href="<?=Url::to(["site/products"]).'&msisdn='.$this->params['user']->cust->msisdn?>">Closed Product List</a></li>
                  </ul>
                </li>
                <li class="has-children"><span><a href="#"><span>Account</span></a><span class="sub-menu-toggle"></span></span>
                  <ul class="slideable-submenu">
                      <li><a href="<?=Url::to(["site/history"]).'&msisdn='.$this->params['user']->cust->msisdn?>">Bid History</a></li>
                      
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
          <!-- Search Section-->
          <div class="toolbar-section" id="search">
            <form class="search-form mb-2" method="get">
              <input type="search" placeholder="Type search query"><i class="material-icons search"></i>
            </form>
            <!-- Products-->
            <div class="widget widget-featured-products">
              <h3 class="widget-title">Found in Products</h3>
              <!-- Entry-->
              <div class="entry">
                <div class="entry-thumb"><a href="#"><img src="unishop/v3.0/template-2/img/shop/widget/01.png" alt="Product"></a></div>
                <div class="entry-content">
                  <h4 class="entry-title"><a href="#">Max <span class='text-highlighted'>Task Chair</span></a></h4><span class="entry-meta">299.00LKR</span>
                </div>
              </div>
              <!-- Entry-->
              <div class="entry">
                <div class="entry-thumb"><a href="#"><img src="unishop/v3.0/template-2/img/shop/widget/02.png" alt="Product"></a></div>
                <div class="entry-content">
                  <h4 class="entry-title"><a href="#"><span class='text-highlighted'>Drawer</span> File Cabinet</a></h4><span class="entry-meta">265.00LKR</span>
                </div>
              </div>
              <!-- Entry-->
              <div class="entry">
                <div class="entry-thumb"><a href="#"><img src="unishop/v3.0/template-2/img/shop/widget/03.png" alt="Product"></a></div>
                <div class="entry-content">
                  <h4 class="entry-title"><a href="#">Campfire <span class='text-highlighted'>Paper</span> Table</a></h4><span class="entry-meta">570.00LKR</span>
                </div>
              </div>
            </div>
            <!-- Blog-->
            <div class="widget widget-featured-products">
              <h3 class="widget-title">Found in Blog</h3>
              <!-- Entry-->
              <div class="entry">
                <div class="entry-thumb"><a href="#"><img src="unishop/v3.0/template-2/img/blog/widget/01.jpg" alt="Post"></a></div>
                <div class="entry-content">
                  <h4 class="entry-title"><a href="#"><span class='text-highlighted'>Modern</span> Working Space</a></h4><span class="entry-meta">May 09</span>
                </div>
              </div>
              <!-- Entry-->
              <div class="entry">
                <div class="entry-thumb"><a href="#"><img src="unishop/v3.0/template-2/img/blog/widget/02.jpg" alt="Post"></a></div>
                <div class="entry-content">
                  <h4 class="entry-title"><a href="#">Interior <span class='text-highlighted'>Design</span> Tricks</a></h4><span class="entry-meta">April 18</span>
                </div>
              </div>
            </div>
          </div>
          <!-- Account Section-->
          <div class="toolbar-section" id="account">
            <ul class="nav nav-tabs nav-justified" role="tablist">
              <li class="nav-item"><a class="nav-link active" href="#myAccount" data-toggle="tab" role="tab">My Account</a></li>
              <li class="nav-item"><a class="nav-link" href="#signup" data-toggle="tab" role="tab">Edit Account</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="myAccount" role="tabpanel">

              <div class="col-md-6">
                <li class="media mb-4"><img class="d-flex rounded-circle align-self-start mr-3" src="<?=Url::base(true) . $this->params['user']->cust->propic?>" width="120" alt="Media">
                  <div class="media-body">
                    <ul class="list-unstyled text-sm mb-4">
                      <li><strong>MSISDN:</strong>  <?=@$this->params['user']->cust->msisdn;?></li>
                      <li><strong>Name:</strong>  <?=@$this->params['user']->cust->name;?></li>
                      <li><strong>NIC:</strong>  <?=@$this->params['user']->cust->nic;?></li>
               
                      <li><strong>Balance:</strong>  <?=@$this->params['user']->bid_balance + @$this->params['user']->daily_bid_balance;?> bids</li>
                      <li><strong>Status:</strong>  <?=@$this->params['user']->cust->status == 1 ? '<span class="text-success">Subscribed</span> ' . Html::a('Deactivate',
    ['site/unsubscribe', 'uid' => @$this->params['user']->cust->id, 'msisdn' => @$this->params['user']->cust->msisdn], ['class' => 'text-danger']) :
'<span class="text-danger">Unsubscribe</span>
<select class="form-control" id="select-input">
  <option value = "0">Choose Pack...</option>
  <option value = "1">Daily - 5 LKR - 3bids</option>
  <option value = "2">Weekly  - 10 LKR - 7bids</option>
  <option value = "3">Monthly - 15 LKR - 12bids</option>
</select><a  id= "sub-btn" class = "btn btn-pill btn-sm btn-success">Activate</a>'?> </li>
                  </ul>
                    <img src="bid/data/images/img/ajax-loader.gif" id="loading-indicator-sub" style="display:none; width:40px;height:40px;position: absolute;left: 40%; z-index: 2;" />
                  </div>
                </li>
              </div>
<script>

$('#sub-btn').on('click', function (event) {

  var packId = ($('#select-input').val());

  if (packId == 0 ) {
    $('#select-input').css({'border-color':'#ef0568'});
  } else {
    $('#select-input').css({'border-color':'#a7c04d', 'color': '#999', 'cursor': 'not-allowed'});
    $('#loading-indicator-sub').show();
    $('#sub-btn').css('cursor', 'not-allowed');
    $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=site/subscribe' ?>',
        method: 'POST',
        data: {
            pId: packId,
            uId: '<?=$this->params['user']->cust->id?>',
            msisdn: '<?=$this->params['user']->cust->msisdn?>',
            _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
          },
        success: function(data){
          $('#spinner').hide();
          window.location='<?="index.php?msisdn=" . $this->params['user']->cust->msisdn;?>';
        },
        error: function(){
          setTimeout(() => {
            $('#loading-indicator').hide();
          },2000);
        }
      });
  }

});
  

</script>
              </div>
              <div class="tab-pane fade" id="signup" role="tabpanel">
                <form autocomplete="off" method = "POST" action = "<?=Url::to(["site/update-account"])?>" id="signup-form">
                  <div class="form-group">
                    <input class="form-control" name = "name" value = "<?=$this->params['user']->cust->name?>" type="text" placeholder="Full Name" required>
                  </div>
                  <div class="form-group">
                    <input class="form-control"  name = "nic" value = "<?=$this->params['user']->cust->nic?>" placeholder="NIC" required>
                  </div>
                  <div class="form-group">
                    <input class="form-control" name = "email" type="email" value = "<?=$this->params['user']->cust->email?>" placeholder="Email" required>
                  </div>
                  
                  <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                  <button class="btn btn-primary btn-block" type="submit">Update Account</button>
                  </form>
              </div>
            </div>
          </div>
          <!-- Shopping Cart Section-->
          <div class="toolbar-section" id="cart">
            <div class="table-responsive shopping-cart mb-0">
            <div class="form-group">
              <label class="entry-title" >Free Bids <span class="badge badge-danger badge-pill"><?=$this->params['user']->daily_bid_balance?></span></label>
              <label class="entry-title" >Walllet Balance <span class="badge badge-success badge-pill"><?=$this->params['user']->bid_balance?></span></label>
            </div>
              <table class="table">
                <thead>
                  <tr>
                    <th colspan="2">
                      <div class="d-flex justify-content-between align-items-center">Packages<a class="navi-link text-uppercase" href="#"></a></div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $packs = $this->params['packs'];
                foreach($packs as $p) {
                  echo '<tr>
                        <td>
                            <div class="product-item"><a class="product-thumb" href=""><img src="'.Url::base(true).$p->image.'" alt="Package"></a>
                              <div class="product-info">
                              <h4 class="product-title"><a id= "eee" data-price = "'.$p->price.'" data-qty = "'.$p->bids.'" data-name = "'.$p->name.'" data-validity = "-" data-pack="' . $p->id . '" data-id ="'.Url::base(true).$p->image.'" data-toggle="modal" data-id="" href="#gardenImage">'. $p->name .'</a></h4><span><em>Price:</em> '.$p->price.' LKR</span><span><em>Bids:</em> '.$p->bids.'</span>
                              <div class="text-sm">Availability:
                                <div class="d-inline text-success">In Stock</div>
                              </div>
                            </div>
                            </div>
                        </td>
                        <td class="text-center"><a id= "eee" data-price = "'.$p->price.'" data-qty = "'.$p->bids.'" data-name = "'.$p->name.'" data-validity = "-" data-pack="' . $p->id . '" data-id ="'.Url::base(true).$p->image.'" data-toggle="modal" data-id="" href="#gardenImage" class="remove-from-cart" href="#"><i class="material-icons arrow_forward"></i></a></td>
                      </tr>';
                }?>
                </tbody>
              </table>
            </div>
            <!-- <hr class="mb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
              <div class="pr-2 py-1 text-sm">Subtotal: <span class='text-dark text-medium'>622.40LKR</span></div><a class="btn btn-sm btn-success mb-0 mr-0" href="#">Checkout</a>
            </div> -->
          </div>
        </div>
      </div>
    </header>



   