@extends('front.app')
@section('content')
@include('front.inc.header')
    <div id="cover">
      {!!$page->translationByLanguage($lang->id)->first()->body!!}

      <div class="modal" id="modalForm">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="formPresentation">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="titleForm">{{trans('front.feedback.title')}}</div>
              <form class="row aboutUsForm align-items-center feedBackPopup">
                <div class="col-12">
                  <div class="alert alert-danger" style="display: none">

                  </div>
                </div>
                <div class="col-12">
                  <div class="alert alert-success" style="display: none">

                  </div>
                </div>
                <div class="col-12">
                  <input type="text" placeholder="{{trans('front.feedback.fullname')}}" name="fullname" required>
                </div>
                <div class="col-12">
                  <input type="text" placeholder="{{trans('front.feedback.phone')}}" name="phone" required>
                </div>
                <div class="col-12">
                  <input type="text" placeholder="{{trans('front.feedback.company')}}" name="company" required>
                </div>
                <div class="col-12">
                  <div class="btnGreen">
                    <div class="btnGreenHover">
                      <input type="submit" value="{{trans('front.feedback.btn')}}">
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
@include('front.inc.footer')
@stop
