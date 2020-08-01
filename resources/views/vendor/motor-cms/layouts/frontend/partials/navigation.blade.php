<div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium">
    <button class="menu-icon" type="button" data-toggle="responsive-menu"></button>
    <div class="title-bar-title">Menu</div>
</div>

<div class="top-bar-container" data-sticky-container>
    <div class="sticky sticky-topbar" data-sticky data-options="anchor: page; marginTop: 0; stickyOn: small;">
<div class="top-bar" id="responsive-menu">
    <div class="top-bar">
        <ul class="dropdown menu" data-dropdown-menu>
            <li class="menu-text">
                <svg viewBox="0 0 1268 249" xmlns="http://www.w3.org/2000/svg" fill="#7381ff" stroke="#7381ff" stroke-width="0.6096" stroke-miterlimit="10">
                    <path d="M1267 143.128H1209.98V200.164H1267V143.128Z" stroke-miterlimit="10"></path>
                    <path d="M171.609 3.76013V200.164H103.089L69.5194 118.291V200.164H1V3.76013H69.5194L103.089 85.6333V3.76013H171.609Z"></path>
                    <path d="M263.121 1C319.224 1 346.586 25.148 346.586 67.6946V136.919C346.586 179.695 319.224 203.383 263.121 203.383C207.018 203.383 179.886 179.695 179.886 136.919V67.6946C180.116 24.918 207.248 1 263.121 1ZM252.544 142.438C252.544 147.498 256.223 151.178 263.351 151.178C270.709 151.178 274.388 147.498 274.388 142.438V61.715C274.388 57.1154 270.709 53.2058 263.351 53.2058C256.223 53.2058 252.544 57.1154 252.544 61.715V142.438Z"></path>
                    <path d="M345.896 3.76013H423.613L437.869 136.689L452.124 3.76013H529.611L492.362 200.164H383.145L345.896 3.76013Z"></path>
                    <path d="M610.547 1C666.65 1 694.012 25.148 694.012 67.6946V136.919C694.012 179.695 666.65 203.383 610.547 203.383C554.444 203.383 527.312 179.695 527.312 136.919V67.6946C527.542 24.918 554.674 1 610.547 1ZM599.97 142.438C599.97 147.498 603.649 151.178 610.777 151.178C618.135 151.178 621.814 147.498 621.814 142.438V61.715C621.814 57.1154 618.135 53.2058 610.777 53.2058C603.649 53.2058 599.97 57.1154 599.97 61.715V142.438Z"></path>
                    <path d="M787.364 1C843.467 1 870.829 25.148 870.829 67.6946V136.919C870.829 169.116 855.194 190.505 823.923 199.244L847.376 236.731L789.893 248L772.419 202.694C726.662 198.784 704.589 175.786 704.589 136.919V67.6946C704.129 24.9181 731.261 1 787.364 1ZM776.557 142.439C776.557 147.498 780.236 151.178 787.364 151.178C794.722 151.178 798.401 147.498 798.401 142.439V61.7151C798.401 57.1154 794.722 53.2058 787.364 53.2058C780.236 53.2058 776.557 57.1154 776.557 61.7151V142.439Z"></path>
                    <path d="M951.765 3.76013V137.839C951.765 142.669 955.214 146.808 962.342 146.808C969.93 146.808 973.149 142.899 973.149 137.839V3.76013H1044.43V136.689C1044.43 179.466 1017.3 203.154 962.342 203.154C907.618 203.154 880.487 179.466 880.487 136.689V3.76013H951.765Z"></path>
                    <path d="M1196.18 200.164H1055.92V3.76013H1193.19V61.9453H1127.2V76.2042H1190.43V128.18H1127.43V142.439H1196.41V200.164H1196.18Z"></path>
                </svg>
            </li>
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
    </div>
</div>
