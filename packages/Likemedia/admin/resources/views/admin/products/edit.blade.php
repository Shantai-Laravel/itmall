@extends('admin::admin.app')
@include('admin::admin.nav-bar')
@include('admin::admin.left-menu')
@section('content')


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/back') }}">Control Panel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.category' , ['category' => Request::get('category')]) }}">Produse</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit products</li>
    </ol>
</nav>
<div class="title-block">
    <h3 class="title"> Edit products
        @if (!is_null($category))
            @if (!is_null($category->translation->first()))
                [ {{ $category->translation->first()->name }} ]
            @endif
        @endif
    </h3>
    @include('admin::admin.list-elements', [
    'actions' => [
    trans('variables.add_element') => route('products.create', ['category' => Request::get('category')]),
    ]
    ])
</div>

@include('admin::admin.alerts')

<div class="list-content">
    <form class="form-reg" method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        {{ csrf_field() }} {{ method_field('PATCH') }}
        <input type="hidden" id="category_id" name="categories_id" value="">

        <div class="row">
            <div class="col-md-4">
                <ul>
                    <li>
                        <label>Categorie</label>
                        <select name="category_id">
                        @foreach($categories as $category)
                            <option {{ $category->id == $product->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->translation()->first()->name }}</option>
                        @endforeach
                        </select>
                    </li>
                </ul>
            </div>
           <div class="col-md-3">
                <ul>
                    <li>
                        <label>Brand</label>
                        <select name="brand_id">
                        <option value="0">No brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->translation()->first()->name }}</option>
                        @endforeach
                        </select>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <ul>
                    <li>
                        <label>Promotion</label>
                        <select name="prommotion_id">
                        <option value="0">No promotion</option>
                        @foreach($promotions as $promotion)
                        <option value="{{ $promotion->id }}" {{ $product->promotion_id == $promotion->id ? 'selected' : '' }}>{{ $promotion->translation()->first()->name }}</option>
                        @endforeach
                        </select>
                    </li>
                </ul>
            </div>
        </div>
        @if (!empty($langs))
        <div class="tab-area" style="margin-top: 25px;">
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
        @foreach ($langs as $lang)
        <div class="tab-content {{ $loop->first ? ' active-content' : '' }}" id={{ $lang->
            lang }}>
            <div class="part left-part">
                <ul style="padding: 25px 0;">
                    <li>
                        <label>{{trans('variables.title_table')}} [{{ $lang->lang }}]</label>
                        <input type="text" name="name_{{ $lang->lang }}" class="name" data-lang="{{ $lang->lang }}"
                        @foreach($product->translations as $translation)
                        @if ($translation->lang_id == $lang->id)
                        value="{{ $translation->name }}"
                        @endif
                        @endforeach
                        >
                    </li>
                    <li>
                        <label for="">{{trans('variables.description')}} [{{ $lang->lang }}]</label>
                        <textarea name="description_{{ $lang->lang }}" id="description-{{ $lang->lang }}"
                            data-type="ckeditor">
                                         @foreach($product->translations as $translation)
                                            @if ($translation->lang_id == $lang->id)
                                                {!! $translation->description !!}
                                            @endif
                                        @endforeach
                                    </textarea>
                        <script>
                            CKEDITOR.replace('description-{{ $lang->lang }}', {
                                language: '{{$lang->lang}}',
                            });
                        </script>
                    </li>
                    <li>
                        <label for="">{{trans('variables.body')}} [{{ $lang->lang }}]</label>
                        <textarea name="body_{{ $lang->lang }}" id="body-{{ $lang->lang }}"
                            data-type="ckeditor">
                                         @foreach($product->translations as $translation)
                                            @if ($translation->lang_id == $lang->id)
                                                {!! $translation->body !!}
                                            @endif
                                        @endforeach
                                    </textarea>
                        <script>
                            CKEDITOR.replace('body-{{ $lang->lang }}', {
                                language: '{{$lang->lang}}',
                            });
                        </script>
                    </li>
                </ul>
                {{-- @include('admin::admin.products.propertiesMultilang') --}}
            </div>
            <div class="part right-part">
                <ul>
                    <li>
                        <label>Slug [{{ $lang->lang }}]</label>
                        <input type="text" name="slug_{{ $lang->lang }}"
                        class="slug form-control"
                        id="slug-{{ $lang->lang }}"
                        @foreach($product->translations as $translation)
                        @if ($translation->lang_id == $lang->id)
                        value="{{ $translation->alias }}"
                        @endif
                        @endforeach
                        >
                    </li>
                    <hr>
                    <h6>Seo texts</h6>
                    <li>
                        <label>{{trans('variables.meta_title_page')}} [{{ $lang->lang }}]</label>
                        <input type="text" name="meta_title_{{ $lang->lang }}"
                        @foreach($product->translations as $translation)
                        @if ($translation->lang_id == $lang->id)
                        value="{{ $translation->seo_title }}"
                        @endif
                        @endforeach
                        >
                    </li>
                    <li>
                        <label>{{trans('variables.meta_keywords_page')}} [{{ $lang->lang }}]</label>
                        <input type="text" name="meta_keywords_{{ $lang->lang }}"
                        @foreach($product->translations as $translation)
                        @if ($translation->lang_id == $lang->id)
                        value="{{ $translation->seo_keywords }}"
                        @endif
                        @endforeach
                        >
                    </li>
                    <li>
                        <label>{{trans('variables.meta_description_page')}} [{{ $lang->lang }}]</label>
                        <input type="text" name="meta_description_{{ $lang->lang }}"
                        @foreach($product->translations as $translation)
                        @if ($translation->lang_id == $lang->id)
                        value="{{ $translation->seo_description }}"
                        @endif
                        @endforeach
                        >
                    </li>

                </ul>
            </div>
        </div>
        @endforeach
        @endif
        <div class="part left-part">
            @include('admin::admin.products.parameters')
            <ul>
                <li>
                    <label>Stock</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" step="any">
                </li>
                <li>
                    <label>Price</label>
                    <input type="number" name="price" value="{{ $product->price }}" step="any">
                </li>
                <li>
                    <label>Disount</label>
                    <input type="number" name="discount" value="{{ $product->discount }}" step="any">
                </li>

                <li>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="hit" {{$product->hit == 1 ? 'checked' : ''}}>
                            <span>Top</span>
                        </label>
                    </div>
                </li>

                <li>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="recomended" {{$product->recomended == 1 ? 'checked' : ''}}>
                            <span>Recomended</span>
                        </label>
                    </div>
                </li>


                <li>
                    <div class="row">
                        <hr>
                        <div class="col-md-4">
                            Upload  images
                            <div class="form-group">
                                  <label for="upload">choice images</label>
                                  <input type="file" id="upload_file" name="images[]" onchange="preview_image();" multiple/>
                                  <div id="image_preview"></div>
                                  <hr>
                            </div>
                        </div>
                        <div class="col-md-8">
                            Gallery
                                @if (!empty($images))
                                    @foreach ($images as $key => $image)
                                        <div class="row image-list">
                                            <div class="col-md-5 text-center">
                                                <img src="{{ asset('/images/products/og/'.$image->src) }}" alt="" class="{{ $image->main == 1 ? 'main-image' : '' }}" style="height:200px; width: auto;">
                                            </div>
                                            <div class="col-md-6">
                                                @foreach ($langs as $key => $lang)
                                                    <div class="form-group row">
                                                       <div class="col-md-4 text-right">
                                                            <label for="">Alt [{{ $lang->lang }}]</label>
                                                       </div>
                                                       <div class="col-md-8">
                                                           <input type="text" name="alt[{{ $image->id }}][{{ $lang->id }}]" class="form-control" value="{{ !is_null($image->translationByLanguage($lang->id)->first()) ? $image->translationByLanguage($lang->id)->first()->alt : '' }}">
                                                       </div>
                                                    </div>
                                                    <div class="form-group row">
                                                       <div class="col-md-4 text-right">
                                                            <label for="">Title [{{ $lang->lang }}]</label>
                                                       </div>
                                                       <div class="col-md-8">
                                                           <input type="text" name="title[{{ $image->id }}][{{ $lang->id }}]" class="form-control" value="{{ !is_null($image->translationByLanguage($lang->id)->first()) ?  $image->translationByLanguage($lang->id)->first()->title : '' }}">
                                                       </div>
                                                   </div><br>
                                                @endforeach
                                            </div>
                                            <div class="col-md-1">
                                                <a href="#" class="main-btn" data-id="{{ $image->id }}"><i class="fa fa-check"></i></a>
                                                <a href="#" class="delete-btn" data-id="{{ $image->id }}"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                        </div>
                    </div>
                </li>
                @include('admin::admin.products.subproducts')
            </ul>
        </div>

        <div class="part right-part">
            <hr>
            <h6>Similar products</h6>
            <li>
              <?php $property = 0; ?>
              @include('admin::admin.products.editCategoriesTree')
            </li>
        </div>

        <div class="part full-part">
            <li>
                <input type="submit" value="{{trans('variables.save_it')}}">
            </li>
        </div>
    </form>

    {{-- gallery modal window --}}
    {{-- @include('admin::admin.products.gallery') --}}


</div>

@stop
@section('footer')
<footer>
    @include('admin::admin.footer')
    <script>
        $('button.tag').click(function(e) {
            e.preventDefault();

            $input = $(this).siblings().last().clone().val('');
            $(this).parent().append($input);
        });

    </script>

    <script>
    function preview_image(){
        var total_file=document.getElementById("upload_file").files.length;
        for(var i=0; i < total_file; i++){
            $('#image_preview').append(
                "<div class='row append'><div class='col-md-12'><img src='"+URL.createObjectURL(event.target.files[i])+"'alt=''></div><div class='col-md-12'>@foreach ($langs as $key => $lang)<label for=''>Alt[{{ $lang->lang }}]</label><input type='text' name='alt_[{{ $lang->id }}][]'><label for=''>Title[{{ $lang->lang }}]</label><input type='text' name='title_[{{ $lang->id }}][]'>@endforeach </div><hr><br>"
            );
        }
    }

    $().ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });

        $('.main-btn').on('click', function(){
            $id = $(this).attr('data-id');
            $productId = '{{ $product->id }}';

            $.ajax({
                type: "POST",
                url: '/back/products/gallery/main',
                data: {
                    id: $id,
                    productId: $productId,
                },
                success: function(data) {
                    if (data === 'true') {
                        location.reload();
                    }
                }
            });
        });

        $('.delete-btn').on('click', function(){
            $id = $(this).attr('data-id');
            $productId = '{{ $product->id }}';

            $.ajax({
                type: "POST",
                url: '/back/products/gallery/delete',
                data: {
                    id: $id,
                    productId: $productId,
                },
                success: function(data) {
                    if (data === 'true') {
                        location.reload();
                    }
                }
            });
        });
    });
</script>
</footer>
@stop
