@php
    $listingLanguage = Helper::currentLanguage()->code;
    $listingDefaultLanguage = config('smartend.default_language');
    $listingTitle = $Topic->{'title_'.$listingLanguage} ?: $Topic->{'title_'.$listingDefaultLanguage};
    $listingDetails = trim(strip_tags($Topic->{'details_'.$listingLanguage} ?: $Topic->{'details_'.$listingDefaultLanguage}));
    $listingUrl = Helper::topicURL($Topic->id, '', $Topic);
    $listingImage = '';
    $listingPhoto = $Topic->photo_file ?: optional($Topic->photos->first())->file;
    if (!$listingPhoto) {
        foreach ($Topic->webmasterSection->customFields->where('type', 8) as $listingPhotoField) {
            if ($listingPhotoField->lang_code === 'all' || $listingPhotoField->lang_code === $listingLanguage) {
                $listingPhoto = optional($Topic->fields->firstWhere('field_id', $listingPhotoField->id))->field_value;
                if ($listingPhoto) break;
            }
        }
    }
    if ($listingPhoto) {
        $listingImage = route('fileView', ['path' => 'topics/'.$listingPhoto]);
        $listingImage .= $listingType === 'news' ? '?w=1280&h=720&r=fit' : '?w=900&h=900&r=fit';
    }
    $listingCategory = $Topic->category($Topic->id);
    $listingCategoryTitle = $listingCategory ? ($listingCategory->{'title_'.$listingLanguage} ?: $listingCategory->{'title_'.$listingDefaultLanguage}) : '';
@endphp

<article class="doman-listing-card {{ $listingType === 'news' ? 'doman-listing-news-card' : 'doman-listing-product-card' }} {{ $listingType === 'news' && $loop->first && $Topics->currentPage() === 1 ? 'is-featured' : '' }}">
    <a href="{{ $listingUrl }}" class="doman-listing-card-link" aria-label="{{ $listingTitle }}">
        <div class="doman-listing-card-media">
            @if($listingImage)
                <img src="{{ $listingImage }}" alt="{{ Helper::topicPhotoAlt($Topic) }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}" width="{{ $listingType === 'news' ? 1280 : 900 }}" height="{{ $listingType === 'news' ? 720 : 900 }}">
            @else
                <span class="doman-listing-card-fallback" aria-hidden="true">{{ __('doman.brand_wordmark') }}</span>
            @endif
            @if($listingType === 'product' && $listingCategoryTitle)
                <span class="doman-listing-product-category">{{ $listingCategoryTitle }}</span>
            @endif
        </div>
        <div class="doman-listing-card-body">
            @if($listingType === 'news')
                <div class="doman-listing-card-meta">
                    <span>{{ $listingCategoryTitle ?: __('doman.news.category') }}</span>
                    @if($Topic->date)
                        <span aria-hidden="true"></span>
                        <time datetime="{{ date('Y-m-d', strtotime($Topic->date)) }}">{{ Helper::formatDate($Topic->date) }}</time>
                    @endif
                </div>
            @else
                <span class="doman-listing-card-kicker">{{ __('doman.products.collection_label') }}</span>
            @endif
            <h2>{{ $listingTitle }}</h2>
            @if($listingDetails)
                <p>{{ \Illuminate\Support\Str::limit($listingDetails, $listingType === 'news' ? 170 : 100) }}</p>
            @endif
            <span class="doman-listing-card-action">
                {{ $listingType === 'news' ? __('doman.news.read_article') : __('doman.products.card_link') }}
                <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
            </span>
        </div>
    </a>
</article>
