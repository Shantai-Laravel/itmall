@if (count($blogs) > 0)
  @foreach ($blogs as $blog)
  <div class="col-md-6 col-12">
    <div class="itemBlog">
      @if ($blog->translationByLanguage($lang->id)->first()->image)
       <img src="{{ asset('images/posts/'.$blog->translationByLanguage($lang->id)->first()->image) }}" alt="{{$blog->translationByLanguage($lang->id)->first()->image_alt}}" title="{{$blog->translationByLanguage($lang->id)->first()->image_title}}" class="itemImg">
      @else
       <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
      @endif
      <div class="bannerBlock">
        <a href="{{ url($lang->lang.'/blogs/'.$blog->translationByLanguage($lang->id)->first()->url) }}">
          <div class="titleBlock">{{$blog->translationByLanguage($lang->id)->first()->title}}</div>
          <p>{!!substr($blog->translationByLanguage($lang->id)->first()->body, 0, 100) . '...'!!}</p>
        </a>
      </div>
    </div>
  </div>
  @endforeach
@endif
