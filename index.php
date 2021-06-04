<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="index.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <title>Payment Gateway Integration</title>
</head>

<body>
    <div class="card-info">
        <form action="index.php" method="POST" >
            <div class="row">
                <div class="col-50">
                    <h3 style="text-align: center; font-size: 25px;">Transaction Details</h3>
                    <label for="fname" style="font-weight: 900; font-size: 120%;">Full Name</label>
                    <input type="text" name="name" id="name" placeholder="Your Good Name" required />
                    <label for="email" style="font-weight: 900; font-size: 120%;">Email</label>
                    <input type="text" id="email" name="email" placeholder="john@example.com" required>
                    <label for="phone" style="font-weight: 900; font-size: 120%;">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="+91-123 4567 890" required>
                    <label for="amt" style="font-weight: 900; font-size: 120%;">Amount</label>
                    <input type="text" name="amt" id="amt" placeholder="Enter Amount" required />
                    <label for="ptype" style="font-weight: 900; font-size: 120%;">Payment Mode</label><br>
                    <label class="container">Credit or Debit Card
                        <input type="radio" name="payty" id="payty" value="card">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container">UPI/QR
                        <input type="radio" name="payty" id="payty" value="upi">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container">Netbanking
                        <input type="radio" name="payty" id="payty" value="netbanking">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container">Wallet
                        <input type="radio" name="payty" id="payty" value="wallet">
                        <span class="checkmark"></span>
                    </label><br>
                    <input type="checkbox" id="cond" name="cond" value="cond" checked>
                     <small>I want to receive transaction updates / alerts on given mail-id.</small><br>
                     <small>By proceeding, you are agreeing to Impact Guru’s <a href="#"> Terms of Use and Privacy Policy</a>.</small>
                    <input type="button" name="btn" class="btn" id="btn" value="Donate Now" onclick="pay_now()" />
  <script>
    (function(){
      var d=document; var x=!d.getElementById('razorpay-embed-btn-js')
      if(x){ var s=d.createElement('script'); s.defer=!0;s.id='razorpay-embed-btn-js';
      s.src='https://cdn.razorpay.com/static/embed_btn/bundle.js';d.body.appendChild(s);} else{var rzp=window['_rzp_'];
      rzp && rzp.init && rzp.init()}})();
  </script>
</div>

                </div>
            </div>
        </form>

       
    </div>

<script>
    function pay_now(){
        var name=jQuery('#name').val();
        var amt=jQuery('#amt').val();
        var phone=jQuery('#phone').val();
        var email=jQuery('#email').val();
        var payty=jQuery("input[name='payty']:checked").val();
        
         jQuery.ajax({
               type:'post',
               url:'payment_process.php',
               data:{ amt: amt,
			        email: email,
					name: name,
                    payty: payty,
	                 },
               success:function(result){
                   var options = {
                        "key": "rzp_test_5jYxflbT1M8dXO", 
                        "amount":amt*100, 
                        "currency": "INR",
                        "name": "PRP Financial Ventures",
                        "description": "Donate to needy",
                        "image": "https://image.freepik.com/free-vector/logo-sample-text_355-558.jpg",
                        "prefill.contact":phone,
                        "prefill.email":email,
                        "prefill.method":payty,
                        "handler": function (response){
                           jQuery.ajax({
                               type:'post',
                               url:'payment_process.php',
                               data:"payment_id="+response.razorpay_payment_id,
                               success:function(result){
                                payment_id=response.razorpay_payment_id;
                                   window.location.href="thank_you.php?payment_id="+payment_id;
                               }
                           });
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
               }
           });
        
        
    }
</script>