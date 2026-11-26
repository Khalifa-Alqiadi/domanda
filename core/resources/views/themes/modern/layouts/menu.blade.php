@if(Helper::GeneralWebmasterSettings("header_menu_id") >0)
    <?php
    // Get list of main menu links
    $MenuLinks = \App\Helpers\SiteMenu::List(Helper::GeneralWebmasterSettings("header_menu_id"));
    ?>
    @if(count($MenuLinks)>0)
        <nav id="navbar" class="navbar order-last order-lg-0" aria-label="{{ __('frontend.mainMenu') }}">
            <button type="button" class="doman-mobile-backdrop" tabindex="-1" aria-label="{{ __('frontend.closeMenu') }}"></button>
            <div class="doman-mobile-brand">
                @if(Helper::GeneralSiteSettings('style_logo_' . @Helper::currentLanguage()->code))
                    <img src="{{ route('fileView', ['path' => 'settings/'.Helper::GeneralSiteSettings('style_logo_' . @Helper::currentLanguage()->code)]) }}"
                         alt="" width="110" height="70">
                @else
                    <span>{{ Helper::GeneralSiteSettings('site_title_' . @Helper::currentLanguage()->code) }}</span>
                @endif
            </div>
            <ul id="doman-primary-links">
                @foreach($MenuLinks as $MenuLink)
                    <li class="{{ (@$MenuLink->sub)?"dropdown":"" }}"><a
                            class="nav-link {{ \App\Helpers\SiteMenu::ActiveLink(url()->current(),@$MenuLink,@$WebmasterSection) }}"
                            href="{{ @$MenuLink->url }}" target="{{ @$MenuLink->target }}">
                            {!! (@$MenuLink->icon)?"<i class='".@$MenuLink->icon."'></i> ":"" !!} {{ @$MenuLink->title }}
                            @if(@$MenuLink->sub)
                                <i class="drop-arrow bi bi-chevron-down"></i>
                            @endif
                        </a>

                        @if(@$MenuLink->sub)
                            <ul>
                                @foreach($MenuLink->sub as $SubLink)
                                    <li class="{{ (@$SubLink->sub)?"dropdown":"" }}"><a class="nav-link"
                                                                                        href="{{ @$SubLink->url }}"
                                                                                        target="{{ @$SubLink->target }}">{!! (@$SubLink->icon)?"<i class='".@$SubLink->icon."'></i> ":"" !!} {{ @$SubLink->title }}
                                            @if(@$SubLink->sub)
                                                <i class="drop-arrow bi bi-chevron-{{ @Helper::currentLanguage()->right }}"></i>
                                            @endif
                                        </a>
                                        @if(@$SubLink->sub)
                                            <ul>
                                                @foreach($SubLink->sub as $SubLink2)
                                                    <li class="{{ (@$SubLink2->sub)?"dropdown":"" }}"><a
                                                            class="nav-link"
                                                            href="{{ @$SubLink2->url }}"
                                                            target="{{ @$SubLink2->target }}">{!! (@$SubLink2->icon)?"<i class='".@$SubLink2->icon."'></i> ":"" !!} {{ @$SubLink2->title }}
                                                            @if(@$SubLink2->sub)
                                                                <i class="drop-arrow bi bi-chevron-{{ @Helper::currentLanguage()->right }}"></i>
                                                            @endif
                                                        </a>
                                                        @if(@$SubLink2->sub)
                                                            <ul>
                                                                @foreach($SubLink2->sub as $SubLink3)
                                                                    <li><a
                                                                            class="nav-link"
                                                                            href="{{ @$SubLink3->url }}"
                                                                            target="{{ @$SubLink3->target }}">{!! (@$SubLink3->icon)?"<i class='".@$SubLink3->icon."'></i> ":"" !!} {{ @$SubLink3->title }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
            <button type="button" class="bi bi-list mobile-nav-toggle"
                    aria-label="{{ __('frontend.openMenu') }}" aria-controls="doman-primary-links"
                    aria-expanded="false"></button>
        </nav>
        @push('after-scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const menu = document.getElementById('navbar');
                    if (!menu) return;
                    const toggle = menu.querySelector('.mobile-nav-toggle');
                    const backdrop = menu.querySelector('.doman-mobile-backdrop');
                    if (!toggle || !backdrop) return;
                    const syncMenu = () => {
                        const open = menu.classList.contains('navbar-mobile');
                        toggle.setAttribute('aria-expanded', String(open));
                        toggle.setAttribute('aria-label', open ? @json(__('frontend.closeMenu')) : @json(__('frontend.openMenu')));
                        document.body.classList.toggle('doman-menu-open', open);
                    };
                    toggle.addEventListener('click', () => requestAnimationFrame(syncMenu));
                    backdrop.addEventListener('click', () => {
                        if (menu.classList.contains('navbar-mobile')) toggle.click();
                    });
                    document.addEventListener('keydown', event => {
                        if (event.key === 'Escape' && menu.classList.contains('navbar-mobile')) {
                            toggle.click();
                            toggle.focus();
                        }
                    });
                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 992 && menu.classList.contains('navbar-mobile')) toggle.click();
                    });
                });
            </script>
        @endpush
    @endif
@endif
