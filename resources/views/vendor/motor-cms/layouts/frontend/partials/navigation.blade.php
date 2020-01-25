<div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium">
    <button class="menu-icon" type="button" data-toggle="responsive-menu"></button>
    <div class="title-bar-title">Menu</div>
</div>

<div class="top-bar" id="responsive-menu">
    <div class="top-bar">
        <ul class="dropdown menu" data-dropdown-menu>
            <li class="menu-text">Revision 2020</li>
            @foreach($navigationItems as $item)
                @if ($item->is_visible && $item->is_active)
                    <li class="@if($activeNavigationSlugs[0] == $item->full_slug)active @endif">
                        <a href="{{ route('frontend.pages.index', ['slug' => $item->full_slug])}}">{{$item->name}}</a>
                        @if ($item->children->count() > 0)
                            <ul class="menu vertical">
                                @foreach ($item->children as $child)
                                    @if ($child->is_active && $child->is_visible)
                                        <li>
                                            <a href="{{ route('frontend.pages.index', ['slug' => $child->full_slug])}}">{{$child->name}}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
