@php
    $socialLinks = json_decode((string) Helper::GeneralSiteSettings('social_links'), true);
    $socialLinks = is_array($socialLinks) ? $socialLinks : [];
@endphp
@if(count($socialLinks) > 0)
    <div class="social-links text-center text-md-right pt-3 pt-md-0">
        @foreach($socialLinks as $link)
            @php
                $socialTitle = trim((string) ($link['title'] ?? ''));
                $socialClasses = strtolower((string) ($link['icon'] ?? ''));
                $socialName = strtolower($socialTitle);
                $socialIcon = null;
                foreach (['threads', 'snapchat', 'instagram', 'youtube', 'facebook', 'linkedin', 'telegram', 'whatsapp', 'pinterest', 'tiktok'] as $network) {
                    if (str_contains($socialName, $network) || str_contains($socialClasses, 'fa-'.$network)) {
                        $socialIcon = $network;
                        break;
                    }
                }
                if (in_array($socialName, ['x', 'x.com', 'twitter'], true) || str_contains($socialClasses, 'fa-x-twitter') || str_contains($socialClasses, 'fa-twitter')) {
                    $socialIcon = 'x';
                }
            @endphp
            <a href="{{ $link['url'] ?? '#' }}" data-bs-toggle="tooltip" title="{{ $socialTitle }}"
               aria-label="{{ $socialTitle }}" data-bs-placement="{{ $tt_position ?? 'top' }}"
               target="_blank" rel="noopener noreferrer">
                @if($socialIcon)
                    @include(theme_view('components.social-icon'), ['name' => $socialIcon])
                @else
                    <span class="doman-social-fallback" aria-hidden="true">{{ mb_strtoupper(mb_substr($socialTitle, 0, 1)) }}</span>
                @endif
            </a>
        @endforeach
    </div>
@endif
