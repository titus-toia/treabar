@if(!empty($only_data))
  @yield('data')
@else
  @yield('before')
  @yield('data')
  @yield('after')
@endif
