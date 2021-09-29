@extends('admin::admin.app')
@include('admin::admin.nav-bar')
@include('admin::admin.left-menu')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/back') }}">Control Panel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('promotions.index') }}">Portfolio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Portfolio</li>
    </ol>
</nav>
<div class="title-block">
    <h3 class="title"> Create Portfolio </h3>
    @include('admin::admin.list-elements', [
    'actions' => [
            'add new' => route('promotions.create'),
        ]
    ])
</div>

@include('admin::admin.alerts')

<div class="list-content">
    <form class="form-reg" role="form" method="POST" action="{{ route('promotions.store') }}" id="add-form"
        enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="tab-area">
            <ul class="nav nav-tabs nav-tabs-bordered">
                @if (!empty($langs))
                @foreach ($langs as $key => $lang)
                <li class="nav-item">
                    <a href="#{{ $lang->lang }}" class="nav-link  {{ $key == 0 ? ' open active' : '' }}"
                        data-target="#{{ $lang->lang }}">{{ $lang->lang }}</a>
                </li>
                @endforeach
                @endif
            </ul>
        </div>
        @if (!empty($langs))
        @foreach ($langs as $key  => $lang)
        <div class="tab-content {{ $key == 0  ? ' active-content' : '' }}" id={{ $lang->lang }}>
            <div class="part left-part">
                <ul>
                    <li>
                        <label for="name-{{ $lang->lang }}">{{trans('variables.title_table')}}  [{{ $lang->lang }}]</label>
                        <input type="text" name="title_{{ $lang->lang }}" class="name"
                            id="title-{{ $lang->lang }}">
                    </li>
                    <li>
                        <label for="description-{{ $lang->lang }}">Description [{{ $lang->lang }}]</label>
                        <textarea name="description_{{ $lang->lang }}"
                            id="description-{{ $lang->lang }}"></textarea>
                    </li>
                    <li class="ckeditor">
                        <label for="body-{{ $lang->lang }}">{{trans('variables.body')}} [{{ $lang->lang }}]</label>
                        <textarea name="body_{{ $lang->lang }}" id="body-{{ $lang->lang }}"
                            data-type="ckeditor"></textarea>
                        <script>
                            CKEDITOR.replace('body-{{ $lang->lang }}', {
                                language: '{{$lang}}',
                            });
                        </script>
                    </li>
                    <li>
                        <label for="seo_text_{{ $lang->lang }}">Meta Text [{{ $lang->lang }}]</label>
                        <textarea name="seo_text_{{ $lang->lang }}"
                            id="seo_text_{{ $lang->lang }}"></textarea>
                    </li>

                </ul>
            </div>
            <div class="part right-part">

                <ul>
                    <hr>
                    <h6>Mata Data [{{ $lang->lang }}]:</h6>
                    <li>
                        <label for="seo_title_{{ $lang->lang }}">Seo Title [{{ $lang->lang }}]</label>
                        <input type="text" name="seo_title_{{ $lang->lang }}"
                            id="seo_title_{{ $lang->lang }}">
                    </li>
                    <li>
                        <label for="seo_descr_{{ $lang->lang }}">Seo Description [{{ $lang->lang }}]</label>
                        <input type="text" name="seo_descr_{{ $lang->lang }}"
                            id="seo_descr_{{ $lang->lang }}">
                    </li>
                    <li>
                        <label for="seo_keywords_{{ $lang->lang }}">Seo Keywords [{{ $lang->lang }}]</label>
                        <input type="text" name="seo_keywords_{{ $lang->lang }}"
                            id="seo_keywords_{{ $lang->lang }}">
                    </li>
                    <hr>
                    <h6>Fields [{{ $lang->lang }}]:</h6>
                    <li>
                        <label for="field_1{{ $lang->lang }}">Fiels 1 [{{ $lang->lang }}]</label>
                        <input type="text" name="field_1{{ $lang->lang }}" id="field_1{{ $lang->lang }}">
                    </li>
                    <li>
                        <label for="field_2{{ $lang->lang }}">Fiels 2 [{{ $lang->lang }}]</label>
                        <input type="text" name="field_2{{ $lang->lang }}" id="field_2{{ $lang->lang }}">
                    </li>
                    <li>
                        <label for="field_3{{ $lang->lang }}">Fiels 3 [{{ $lang->lang }}]</label>
                        <input type="text" name="field_3{{ $lang->lang }}" id="field_3{{ $lang->lang }}">
                    </li>
                    <li>
                        <label for="field_4{{ $lang->lang }}">Fiels 4 [{{ $lang->lang }}]</label>
                        <input type="text" name="field_4{{ $lang->lang }}" id="field_4{{ $lang->lang }}">
                    </li>
                    <li>
                        <label for="field_5{{ $lang->lang }}">Fiels 5 [{{ $lang->lang }}]</label>
                        <input type="text" name="field_5{{ $lang->lang }}" id="field_5{{ $lang->lang }}">
                    </li>
                </ul>
            </div>
        </div>
        @endforeach
        @endif
        <div class="part full-part">
            <div class="row">
                <div class="col-md-6">
                    <label for="banner_1">Banner 1</label>
                    <input type="file" name="banner_1" value="">
                </div>
                <div class="col-md-6">
                    <label for="banner_2">Banner 2</label>
                    <input type="file" name="banner_2" value="">
                </div>
            </div>
            <ul>
                <li>

                </li>
                <li><br>
                    <input type="submit" value="{{trans('variables.save_it')}}" data-form-id="add-form">
                </li>
            </ul>
        </div>
    </form>
</div>
@stop
@section('footer')
<footer>
    @include('admin::admin.footer')
</footer>
@stop
