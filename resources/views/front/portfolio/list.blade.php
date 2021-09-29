@extends('front.app')
@section('content')
@include('front.inc.header')
<div id="cover">
    <div class="portCat">
        <div class="posFixed">
            <h3>digital mall</h3>
        </div>
        <div class="slideServ">
            @if ($items->count()> 0)
                @foreach ($items as $key => $item)
                    <div class="itemServ">
                        <a href="{{ url('/'.$lang->lang.'/portfolio/'.$item->alias) }}">
                            <img src="/images/promotions/{{ $item->banner_1 }}" alt="">
                        </a>
                        <div class="nameHover">
                            <div><a href="{{ url('/'.$lang->lang.'/portfolio/'.$item->alias) }}">
                                {{ $item->translationByLanguage($lang->id)->first()->name }}
                            </a></div>
                        </div>
                        <a href="{{ url('/'.$lang->lang.'/portfolio/'.$item->alias) }}"> </a>
                        <div class="itemServDescr">
                            <ul>
                                @if ($item->translationByLanguage($lang->id)->first()->field_1)
                                    <li>{{ $item->translationByLanguage($lang->id)->first()->field_1 }}</li>
                                @endif
                                @if ($item->translationByLanguage($lang->id)->first()->field_2)
                                    <li>{{ $item->translationByLanguage($lang->id)->first()->field_2 }}</li>
                                @endif
                                @if ($item->translationByLanguage($lang->id)->first()->field_3)
                                    <li>{{ $item->translationByLanguage($lang->id)->first()->field_3 }}</li>
                                @endif
                                @if ($item->translationByLanguage($lang->id)->first()->field_4)
                                    <li>{{ $item->translationByLanguage($lang->id)->first()->field_4 }}</li>
                                @endif
                                @if ($item->translationByLanguage($lang->id)->first()->field_5)
                                    <li>{{ $item->translationByLanguage($lang->id)->first()->field_5 }}</li>
                                @endif
                            </ul>
                            <div class="btnGreen">
                                <div class="btnGreenHover"><a href="{{ url('/'.$lang->lang.'/portfolio/'.$item->alias) }}">View</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@include('front.inc.footer')
@stop
