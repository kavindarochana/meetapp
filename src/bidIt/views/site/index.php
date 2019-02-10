<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'BidIt';

//NOtice message - Toats
$msg = json_decode(Yii::$app->cache->get($this->params['user']->cust->id . 'notice_message'));

$message = ($msg == null ? @$message : $msg);
// print_r($message);exit;
if (@$message[0] == 'success') {

    echo "<script type=\"text/javascript\">
              $.growl.notice({ title: \"\", message: \"$message[1]\" });
          </script>";
}

if (@$message[0] == 'error') {
    echo "<script type=\"text/javascript\">
              $.growl.error({ title: \"\", message: \"$message[1]\" });
          </script>";
}

if (@$message[0] == 'alert') {
    echo "<script type=\"text/javascript\">
            $.growl({ title: \"\", message: \"$message[1]\" });
        </script>";
}

if (@$message[0] == 'warning') {
    echo "<script type=\"text/javascript\">
            $.growl.warning({ title: \"\", message: \"$message[1]\" });
        </script>";
}

// Yii::$app->session->set('notice_message', null);
// $.growl.error({ message: "The kitten is attacking!" });
// $.growl.notice({ message: "The kitten is cute!" });
// $.growl.warning({ message: "The kitten is ugly!" });

//End notice message
?>

<script>
// $(

// ".screenshot-link").click(function () {
// var site = $(this).attr("site");
// var num = $(this).attr("num");
// // $.post(

// // "/Development/Main/Screenshot",
// // {

// // site: site, num: num }
// // );
// $.confirm({

//   content: x,
// });
// $('a.twitter').confirm({
//   buttons: {
//       hey: function(){
//          // location.href = this.$target.attr(\'href\');
//       }
//   }
// });

// console.log(num);
// });
</script>

<?php $a = 'aaaa';
echo '
<script>


var x = $("#er").data(\'id\');


$(\'a.twitter\').confirm({
  content: $("#er").data(\'id\'),
  buttons: {
      hey: function(){
          location.href = this.$target.attr(\'href\');
      }
  }
});

function openDialog() {
  console.log(2131);
}
</script>';

?>




<!-- Modal
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div> -->

<!-- Sub list if not sub-->
<?php
$user = $this->params['user'];
if (($user->daily_bid_balance + $user->bid_balance) == 0 && $user->daily_bid_balance_stauts == 0) {
  echo '
<section class="container padding-top-2x padding-bottom-3x">  
<div class="card">
            <div class="card-body">
              <h5 class="card-title text-danger text-sm"><strong>Your Subscription has been ended. Please subscribe.</strong></h5>
              <p class="card-text"><h5 class= "text-sm">Subscribe for:</h5>
<select class="form-control" id="select-input">
  <option value = "0">Choose Pack...</option>
  <option value = "1">Daily - 5 LKR - 3bids</option>
  <option value = "2">Weekly  - 10 LKR - 7bids</option>
  <option value = "3">Monthly - 15 LKR - 12bids</option>
</select><a  id= "sub-btn" class = "btn btn-pill btn-sm btn-success">Subscribe</a> </p>
            </div>
          </div>


 </section>
';}
?>


        <?php if (!@$products['active']) {
    if (@$products['next']) {echo
        '<section style = "margin-bottom: -45px; border-bottom: 0px solid #eaeaea;" class="container-fluid padding-top-1x pb-5 widget widget-colors">
      <h3 style = "margin-bottom: 15px !important;" class="text-center mb-30">Live Auction</h3>
      <div class="row">
        <!-- Special Offer-->
        <div class="col-xl-3 col-md-4">
        <div class="card pt-3 pb-2 mb-30">
    <div class="card-body text-center"><span class="product-badge text-info">Starting</span>
            <h4 style = "margin-bottom: 15px;  margin-top: -20px;">' . $products['next']->name . '</h4>
            <div style = "margin-top: -0.2rem !important;" class="mt-4">
              <span class="days_ref">Start In - <span class= "text-success"> ' . date('M d Y H:i', strtotime($products['next']->start_date)) . '</span></span>
                <div class="countdown countdown-alt" data-date-time="' . date('m/d/Y H:i:s', strtotime($products['next']->start_date)) . '">
                  <div class="item">
                    <div class="days">00</div><span class="days_ref">Days</span>
                  </div>
                  <div class="item">
                    <div class="hours">00</div><span class="hours_ref">Hours</span>
                  </div>
                  <div class="item">
                    <div class="minutes">00</div><span class="minutes_ref">Mins</span>
                  </div>
                  <div class="item">
                    <div class="seconds">00</div><span class="seconds_ref">Secs</span>
                  </div>
                </div>
            </div>
              <a class="d-inline-block" href="#"><img style = "max-width:100%;" src="' . Url::base(true) . $products['next']->image . '" alt="' . $products['next']->name . '"></a>
              <h3 style = "margin-bottom: 10px;" class="h5 text-normal pt-2"><a class="navi-link" href="#"></a></h3>
              <span id = "bidName" class ="h5 mb-30">Price - </span> <span style = "color:#e83e8c" id = "bidVal" class="h5"> ' . $products['next']->price . ' LKR</span>


              <div style = "margin-left: 14%; margin-top: 10px;" class = "row">
                <!-- <input style = "width:180px;" class="form-control form-control-pill form-control-sm" type="text" id="bidPrice" placeholder="Place your bid"> -->
                <img src="bid/data/images/img/ajax-loader.gif" id="loading-indicator" style="display:none; width:40px;height:40px;position: absolute;left: 40%; z-index: 2;" />
<input disabled = "true" style = "width:180px;" type = "number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "2" class="form-control form-control-pill form-control-sm"  id="bidPrice" placeholder="Place your bid">

<button disabled = "true" id = "bidBtn" style = "margin-top: 0px; margin-bottom:0px" class="btn btn-pill btn-success btn-sm btn-secondary" type="button">Bid</button>
       ';}} else {echo
    '<section style = "margin-bottom: -45px; border-bottom: 0px solid #eaeaea;" class="container-fluid padding-top-1x pb-5 widget widget-colors">
<h3 style = "margin-bottom: 15px !important;" class="text-center mb-30">Live Auction</h3>
<div class="row">
  <!-- Special Offer-->
  <div class="col-xl-3 col-md-4">
  <div class="card pt-3 pb-2 mb-30">
     <div class="card-body text-center"><span class="product-badge text-danger">Live</span>
            <h4 style = "margin-bottom: 15px;  margin-top: -20px;">' . $products['active']->name . '</h4>
            <div style = "margin-top: -0.2rem !important;" class="mt-4">
              <span class="days_ref">Expire On - <span class= "text-success"> ' . date('M d Y H:i', strtotime($products['active']->end_date)) . '</span></span>
                <div class="countdown countdown-alt" data-date-time="' . date('m/d/Y H:i:s', strtotime($products['active']->end_date)) . '">
                  <div class="item">
                    <div class="days">00</div><span class="days_ref">Days</span>
                  </div>
                  <div class="item">
                    <div class="hours">00</div><span class="hours_ref">Hours</span>
                  </div>
                  <div class="item">
                    <div class="minutes">00</div><span class="minutes_ref">Mins</span>
                  </div>
                  <div class="item">
                    <div class="seconds">00</div><span class="seconds_ref">Secs</span>
                  </div>
                </div>
            </div>
              <a class="d-inline-block" href="#"><img style = "max-width:100%;" src="' . Url::base(true) . $products['active']->image . '" alt="' . $products['active']->name . '"></a>
              <h3 style = "margin-bottom: 10px;" class="h5 text-normal pt-2"><a class="navi-link" href="#"></a></h3>
              <span id = "bidName" class ="h5 mb-30">Price - </span> <span style = "color:#e83e8c" id = "bidVal" class="h5"> ' . $products['active']->price . ' LKR</span>


              <div style = "margin-left: 14%; margin-top: 10px;" class = "row">
                <!-- <input style = "width:180px;" class="form-control form-control-pill form-control-sm" type="text" id="bidPrice" placeholder="Place your bid"> -->
                <img src="bid/data/images/img/ajax-loader.gif" id="loading-indicator" style="display:none; width:40px;height:40px;position: absolute;left: 40%; z-index: 2;" />
<input style = "width:180px;" type = "number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "9" class="form-control form-control-pill form-control-sm"  id="bidPrice" placeholder="Place your bid">

<button id = "bidBtn" style = "margin-top: 0px; margin-bottom:0px" class="btn btn-pill btn-success btn-sm btn-secondary" type="button">Bid</button>
       ';}?>

<script>
  var v1 =  '<?=@$products["active"]->price . " LKR"?>';
  var price = '<?=@$products["active"]->price?>';

  // if (1 * $('#bidPrice').val() == 0) {console.log(111);
  //   $('#bidBtn').prop('disabled', false);
  // }

  //bid value input validation
  $('#bidPrice').keyup(function () {

    $('#bidVal').text(parseInt(Math.abs($(this).val())) +" LKR");
    $('#bidName').text("Your Bid - ").val();
    $('#bidVal').css({'font-weight': '550', 'color':'#20c997',}); //The specific CSS changes after the first one, are, of course, just examples.
    $('#bidName').css({'font-weight': '550', 'color':'#404040', 'font-size': '18px'});
    $('#bidBtn').prop('disabled', false);

    // if($(this).val()%5 !== 0) {
    //   $('#bidName').css({'font-size': '14px', 'color': '#ff0f74'});
    //   // $('#bidVal').css({'color': '#e83e8c', 'font-weight': '400'});
    //   $('#bidVal').text('').val();
    //   $('#bidName').text("Invalid bid. Accept only divisible by 5 values...").val();
    //   $('#bidBtn').prop('disabled', true);
    // }

    if(1 * $(this).val() <= 1 * price ) {
      $('#bidName').css({'font-size': '14px', 'color': '#ff0f74'});
      // $('#bidVal').css({'color': '#e83e8c', 'font-weight': '400'});
      $('#bidVal').text('').val();
      $('#bidName').text("Invalid bid. Your bid shoud greater than " + v1).val();
      $('#bidBtn').prop('disabled', true);
    }


    if($(this).val() == '' || $(this).val() == 0) {
      $('#bidName').css({'font-weight': '400', 'color':'#404040', 'font-size': '18px'});
      $('#bidVal').css({'color': '#e83e8c', 'font-weight': '400'});
      $('#bidVal').text(v1).val();
      $('#bidName').text("Price - ").val();
      $('#bidBtn').prop('disabled', true);
    }

  });

  //bid click validation

  $('#bidBtn').click(function () {

    var pId = '<?=@$products['active']->id?>';
    $('#loading-indicator').show();

    if(parseInt(Math.abs($('#bidPrice').val())) <= 1 * price ) {
      $('#bidName').css({'font-size': '14px', 'color': '#ff0f74'});
      // $('#bidVal').css({'color': '#e83e8c', 'font-weight': '400'});
      $('#bidVal').text('').val();
      $('#bidName').text("Invalid bid. Your bid shoud greater than " + v1).val();
      $('#bidBtn').prop('disabled', true);
      $('#loading-indicator').hide();
      return;
    }


    if(0 == parseInt(Math.abs($('#bidPrice').val()))) {
      $('#bidName').css({'font-size': '14px', 'color': '#ff0f74'});
      // $('#bidVal').css({'color': '#e83e8c', 'font-weight': '400'});
      $('#bidVal').text('').val();
      $('#bidName').text("Invalid bid. Please place a valid amount.").val();
      $('#bidBtn').prop('disabled', true);
      $('#loading-indicator').hide();
    } else {
      $('#bidBtn').prop('disabled', true);
      $('#bidVal').prop('disabled', true);
      $('#loading-indicator').show(); //Show your spinner before the AJAX call
      $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=site/bid-now' ?>',
        method: 'POST',
        data: {
            pId:pId,
            bid:parseInt(Math.abs($('#bidPrice').val())),
            _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
          },
        success: function(data){
          $('#spinner').hide();
          window.location='<?="index.php?msisdn=" . $this->params['user']->cust->msisdn;?>';
        },
        error: function(){
          setTimeout(() => {
            $('#loading-indicator').hide();
            $('#bidName').css({'font-size': '14px', 'color': '#ff0f74'});
            $('#bidVal').text('').val();
            $('#bidVal').prop('disabled', false);
            $('#bidName').text("Can not place your bid right now.").val();
            $('#bidBtn').prop('disabled', false);
          },2000);
        }
      });
    }

  });


</script>
                </div>
          </div>
        </div>
      </div>
    </div>
    </section>

      <?php if (@$products['queue']) {
    echo '<h3 class="text-center mb-30">Upcoming</h3>' .
        '<section class="hero-slider" style = "min-height: auto;">' .
        '<div class="owl-carousel large-controls dots-inside pb-4" data-owl-carousel="{ &quot;nav&quot;: true, &quot;dots&quot;: true, &quot;loop&quot;: true, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 8000 }">'
    ;

    foreach ($products['queue'] as $q) {
        echo
        '<div class="col-md-3 col-sm-6 mb-30"><a class="category-card flex-wrap text-center pt-0" href="#">' .
        '<div class="container-fluid"><span class="product-badge text-success">Queue</span>'
        . '  <div style = "margin-top: 3em;" class="category-card-thumb w-100"><img src="' . Url::base(true) . $q->image . '" alt="Upcoming Products"></div>'
        . '<div class="category-card-info w-100">'
        . '  <h3 class="category-card-title">' . $q->name . '</h3>'
        . '  <h4 class="category-card-subtitle">Starting from ' . $q->price . ' LKR</h4>'
            . '</div></a>' .
            '</div>' .
            '</div>';
    }

    echo '</div></div>' .
        '</section>';

}?>

<section class="container padding-top-3x padding-bottom-3x">
      <h3 class="text-center mb-30">Past Auctions</h3>
      <div class="row">
      <?php
if ($products['end']) {
    if (!@$products['end']['id']) {
        foreach ($products['end'] as $prE) {
            echo '<div class="col-md-3 col-sm-6 mb-30"><div class="category-card flex-wrap text-center pt-0">
        <span class="product-rating text-warning"><i style = "font-size: 2em;font-weight: 600;" class="';
            echo (int) $prE->winId !== 0 ? 'material-icons flight_takeoff text-danger' : 'material-icons stop';
            echo '"></i></span>
            <div style= "padding: 4%;" class="category-card-thumb w-100"><img src="' . Url::base(true) . $prE->image . '" alt="' . $prE->image . '"></div>
            <span style = "color:#dc9814" class="product-badge btn-link-secondary">End</span>
            <div class="category-card-info w-100">
            <td>
            <div class="product-item">
              <div class="product-info">
                <h4 class="product-title">' . $prE->name . '</h4>
                <div class="text-lg text-medium text-muted">Started from ' . $prE->price . ' LKR</div>';
            if ($prE->winId == 0) {
                echo '
                  <div class="text-sm">Winner:
                  <div class="d-inline text-success"> No winner</div>
                </div>
                <div class="text-sm">Winning Bid:
                  <div class="d-inline text-success"> - </div>
                </div>';
            } else {
                echo '
                  <div class="text-sm">Winner:
                  <div class="d-inline text-success">' . $prE->winner . '</div>
                </div>
                <div class="text-sm">Winning Bid:
                  <div class="d-inline text-success">' . $prE->winner_bid . ' LKR</div>
                </div>';
            }
            echo '
              </div>
            </div>
          </td></div></div></div>';
        }
    } else {
        $prE = $products['end'];
        echo '<div class="col-md-3 col-sm-6 mb-30"><div class="category-card flex-wrap text-center pt-0">
          <span style = "color:#dc9814" class="product-rating text-warning"><i style = "font-size: 2em;font-weight: 600;" class="material-icons flight_takeoff text-danger"></i></span>
            <div class="category-card-thumb w-100"><img src="' . Url::base(true) . $prE['image'] . '" alt="Category"></div>
            <span class="product-badge btn-link-secondary">End</span>
            <div class="category-card-info w-100">
              <h3 class="category-card-title">' . $prE['name'] . '</h3>
              <h4 class="category-card-subtitle">Price ' . $prE['price'] . 'LKR</h4>
              <h4 class="category-card-subtitle">Winner ' . $prE['winner'] . '</h4>
              <h4 class="category-card-subtitle">Winning Bid  ' . $prE['winner_bid'] . '</h4>
            </div></div></div>';
    }
}

?>
      </div>
      <div class="text-center"><a class="btn btn-outline-secondary mb-0" href="<?=Url::to(["site/products"]) . '&msisdn=' . $this->params['user']->cust->msisdn?>">Load More</a></div>
    </section>




    <?php

//   Modal::begin([

//           'id'     => 'model',
//           'size'   => 'modal-dialog',
//           'footer' => '<div class="modal-footer">
//                         <button class="btn btn-white btn-sm" type="button" data-dismiss="modal">Close</button>
//                         <button class="btn btn-primary btn-sm" type="button">Save changes</button>
//                       </div>'
//   ]);

//   echo '<div id="modelContent">
// </div>';

//   Modal::end();
?>