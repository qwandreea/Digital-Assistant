@extends('layouts.app')

@section('content')
<style>
.free {
    color: #9390b8;
    display: block
}
.card-card{
   border-style: solid;
  border-width: thin;
  border-color:#E8E8E8;
}
.amount {
    color: #352f7a;
    font-weight: 700;
    font-size: 45px
}

.box {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100vh;
}

.paypal-logo {
  font-family: Verdana, Tahoma;
  font-weight: bold;
  font-size: 12px;
}

.paypal-logo i:first-child {
  color: #253b80;
}

.paypal-logo i:last-child {
  color: #179bd7;
}
  
.paypal-button {
  padding: 15px 30px;
  border: 1px solid #FF9933;
  border-radius: 5px;
  background-image: linear-gradient(#FFF0A8, #F9B421);
  margin: 0 auto;
  display: block;
  width: 90%;
  height: %;
  position: relative;
}
.paypal-button-title{
  font-size:14px;
}
    
.paypal-logo {
  display: inline-block;
  text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.6);
  font-size: 14px;
}

</style>
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-10">
         <div class="card">
            <div class="card-header">{{ __('Buy a package') }}</div>
            <div class="card-body">
               @if (session('status'))
               <div class="alert alert-success" role="alert">
                  {{ session('status') }}
               </div>
               @endif
               {{ __('You are logged in') }}
               
               <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col">
                        <form name="goBack" id="goBack" action="{{ url('/') }}" method="get"> {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary btn-sm"> <strong><<</strong> Go to landing page</button>
                        </form></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"> 
                        <form name="goBack" id="goBack" action="{{ url('/dashboard') }}" method="get"> {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary btn-sm">Go to dashboard <strong>>></strong></button>
                        </form></th>
                    </tr>
                    </thead>
                </table>
              
               <div class="container mt-5 mb-5">
                  <div class="row">
                     <div class="col-md-4">
                         
                          <div class="card-card p-3 mt-3">
                           <form method="POST" id="payment-form"  action="/payment/pay/paypal">
                              {{ csrf_field() }}
                              <div class="text-center">
                                 <span class="free">Personal</span> <span class="d-block mt-3 amount">5<span style="font-size:25px;">EUR</span> </span> 
                                   <!-- POST INPUTS -->
                                  <input name="amount" type="text" hidden="hidden" value="5">
                                   <input name="name" type="text" hidden="hidden" value="Personal">
                                   <input name="currency" type="text" hidden="hidden" value="EUR">
                                   <input name="no_checks" type="text" hidden="hidden" value="3">
                                   <p></p>
                                 <div class="mt-3">
                                   <p><strong>3</strong></p>
                                    <p>diagnostic checks</p>
                                   <button class="paypal-button"><span class="paypal-button-title">Buy now with  </span><span class="paypal-logo"><i>Pay</i><i>Pal</i></span></button>
                                </div>
                             </div>
                             </form>
                        </div>
                        </div>
                        
                        <div class="col-md-4">
                         <div class="card-card p-3 mt-3">
                           <form method="POST" id="payment-form"  action="/payment/pay/paypal">
                              {{ csrf_field() }}
                              <div class="text-center">
                                 <span class="free">Enterprise</span> <span class="d-block mt-3 amount">15<span style="font-size:25px;">EUR</span> </span> 
                                   <!-- POST INPUTS -->
                                  <input name="amount" type="text" hidden="hidden" value="15">
                                   <input name="name" type="text" hidden="hidden" value="Enterprise">
                                   <input name="currency" type="text" hidden="hidden" value="EUR">
                                   <input name="no_checks" type="text" hidden="hidden" value="10">
                                   <p></p>
                                 <div class="mt-3">
                                   <p><strong>10</strong></p>
                                    <p>diagnostic checks</p>
                                   <button class="paypal-button"><span class="paypal-button-title">Buy now with  </span><span class="paypal-logo"><i>Pay</i><i>Pal</i></span></button>
                                </div>
                             </div>
                             </form>
                        </div>
                        </div>
                         
                         <div class="col-md-4">
                        <div class="card-card p-3 mt-3">
                           <form method="POST" id="payment-form"  action="/payment/pay/paypal">
                              {{ csrf_field() }}
                              <div class="text-center">
                                 <span class="free">Premium</span> <span class="d-block mt-3 amount">40<span style="font-size:25px;">EUR</span> </span> 
                                   <!-- POST INPUTS -->
                                  <input name="amount" type="text" hidden="hidden" value="40">
                                   <input name="name" type="text" hidden="hidden" value="Premium">
                                   <input name="currency" type="text" hidden="hidden" value="EUR">
                                   <input name="no_checks" type="text" hidden="hidden" value="40">
                                   <p></p>
                                 <div class="mt-3">
                                   <p><strong>40</strong></p>
                                    <p>diagnostic checks</p>
                                   <button class="paypal-button"><span class="paypal-button-title">Buy now with  </span><span class="paypal-logo"><i>Pay</i><i>Pal</i></span></button>
                                </div>
                             </div>
                             </form>
                        </div>
                        </div>
                        
                    </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
