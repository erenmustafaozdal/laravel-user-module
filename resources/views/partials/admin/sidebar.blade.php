{{-- sidebar menu --}}
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{!! trans('laravel-user-module::admin.title') !!}</h3>
        <ul class="nav side-menu">

            @foreach($items as $item)
                <li {{ (strpos(Route::currentRouteName(),$item->attribute('active')) !== false) ? 'class=active' : '' }}>
                    <a>
                        <i class="fa fa-{{ $item->attribute('data-icon') }}"></i>
                        <span>{!! $item->title !!}</span>
                        @if($item->hasChildren()) <span class="fa fa-chevron-down"></span> @endif
                    </a>
                    @if($item->hasChildren())
                        <ul class="nav child_menu" style="display: none">
                            @foreach($item->children() as $child)
                                <li>
                                    <a href="{{ $child->url() }}">
                                        <span> {!! $child->title !!} </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach

        </ul>
    </div>
</div>
{{-- /sidebar menu --}}