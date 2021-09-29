@if (count($wishListProducts) > 0)
  <div class="buttonMenuWish buttonMenuWishElements">
    <span>{{count($wishListProducts)}}</span>
    <div class="btnBcg"></div>
  </div>
@else
  <div class="buttonMenuWish">
    <span></span>
    <div class="btnBcg"></div>
  </div>
@endif
