<div class="doman-topic-share" aria-label="{{ __('frontend.share') }}">
    <span class="doman-topic-share-label"><i class="fa-solid fa-share-nodes" aria-hidden="true"></i> {{ __('frontend.share') }}</span>
    <div class="doman-topic-share-links">
        @foreach (['facebook' => 'fa-facebook-f', 'whatsapp' => 'fa-whatsapp', 'twitter' => 'fa-x-twitter', 'linkedin' => 'fa-linkedin-in'] as $network => $icon)
            <a href="{{ Helper::SocialShare($network, @$PageTitle) }}" target="_blank" rel="noopener noreferrer"
               aria-label="{{ __('frontend.shareOn') }} {{ __('frontend.social_' . $network) }}"
               title="{{ __('frontend.social_' . $network) }}">
                <i class="fa-brands {{ $icon }}" aria-hidden="true"></i>
            </a>
        @endforeach
    </div>
</div>
