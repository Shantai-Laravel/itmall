@extends('front.app')
@section('content')
@include('front.inc.header')
<div id="cover">
  <div class=" wish">
     <div class="container">
       <div class="row justify-content-center">
          <div class="col-12">
             <h4>{{trans('front.wishList.page')}}</h4>
          </div>
          <div class="col-lg-9 col-md-12">
             <div class="row">
                <div class="col-12">
                   <div class="row wishListBlock">
                      @include('front.inc.wishListBlock')
                   </div>
                </div>
             </div>
          </div>
       </div>
     </div>
  </div>

  <div class="modal" id="modalError">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-body">
                  <div class="row">
                      <div class="col-6 message">

                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@include('front.modals.messagesModal')
@include('front.inc.footer')
@stop
