<header id="header" class="doman-header {{ Helper::GeneralSiteSettings('style_header') ? 'fixed-top' : '' }}">
    <div class="container doman-header-shell">
        <a class="doman-identity" href="{{ Helper::homeURL() }}" aria-label="{{ Helper::GeneralSiteSettings('site_title_' . @Helper::currentLanguage()->code) }}">
            @if(Helper::GeneralSiteSettings('style_logo_' . @Helper::currentLanguage()->code))
                <img class="doman-identity-logo"
                     src="{{ route('fileView', ['path' => 'settings/'.Helper::GeneralSiteSettings('style_logo_' . @Helper::currentLanguage()->code)]) }}"
                     alt="" width="100" height="52">
            @endif
        </a>
        @include(theme_view('layouts.menu'))
    </div>
</header>
