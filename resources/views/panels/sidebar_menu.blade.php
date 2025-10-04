@foreach($menus as $menu)
    {{-- {{ dd($menu) }} --}}
    @can($menu['permission'])
      <li class="slide {{ Route::is($menu['permission'] . '.*') ? 'active' : '' }}">
            <a href="{{ $menu['url'] ?: '#!' }}" class="side-menu__item" role="menuitem">
                <span class="side_menu_icon"><i class="{{ $menu['icon'] ?? 'ri-layout-line' }}"></i></span>
                <span class="side-menu__label">{{ $menu['name'] }}</span>

                @if(isset($menu['children']) && count($menu['children']) > 0)
                <i class="ri-arrow-down-s-line side-menu__angle"></i>
                @endif
            </a>

            @if(isset($menu['children'] )&& count($menu['children']) > 0)
            <ul class="slide-menu" role="menu">
                {{-- @include('panels.side-menu', ['menus' => $menu['children']]) --}}
                @foreach($menu['children'] as $sub_menu)
                        {{-- {{ dd($menu) }} --}}
                    @can($sub_menu['permission'])
                     <li class="slide {{ Route::is($sub_menu['permission'] . '.*') ? 'active' : '' }}">
                        <a href="{{ $sub_menu['url'] ?: '#!' }}" class="side-menu__item" role="menuitem">
                            {{-- <span class="side_menu_icon"><i class="{{ $sub_menu['icon'] ?? 'ri-layout-line' }}"></i></span> --}}
                            <span class="side-menu__label">{{ $sub_menu['name'] }}</span>

                            @if(isset($sub_menu['children']) && count($sub_menu['children']) > 0)
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                            @endif
                        </a>

                        @if(isset($sub_menu['children'] )&& count($sub_menu['children']) > 0)
                        <ul class="slide-menu" role="menu">
                            {{-- @include('panels.side-menu', ['menus' => $menu['children']]) --}}
                        </ul>
                        @endif
                    </li>

                    @endcan
                    @endforeach
            </ul>
            @endif
        </li>

    @endcan
@endforeach
