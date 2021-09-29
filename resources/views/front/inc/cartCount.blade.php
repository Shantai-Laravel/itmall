@if (count($cartProducts) > 0)
  <div class="buttonMenuCart buttonMenuCartElements">
    <span>{{count($cartProducts)}}</span>
    <div class="btnBcg"></div>
  </div>
@else
  <div class="buttonMenuCart">
    <div class="btnBcg"></div>
  </div>
@endif
