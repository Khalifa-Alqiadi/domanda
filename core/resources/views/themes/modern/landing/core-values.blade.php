@php
    $languageCode = @Helper::currentLanguage()->code;
    $blockTitle = (string) ($TopicBlockContents->{'title_'.$languageCode} ?? '');
    $blockDescription = (string) ($TopicBlockContents->{'desc_'.$languageCode} ?? '');
    $valueCount = count($BannersList);
@endphp
<section class="doman-values" aria-labelledby="doman-values-title-{{ (int) $TopicBlock->id }}">
    <div class="container">
        <div class="doman-values-heading">
            <div class="doman-values-heading-copy">
                <span class="doman-values-eyebrow">{{ __('doman.values.eyebrow') }}</span>
                <h2 id="doman-values-title-{{ (int) $TopicBlock->id }}">{{ $TopicBlock->title_status && $blockTitle !== '' ? $blockTitle : __('doman.values.heading') }}</h2>
                <p>{{ $TopicBlock->desc_status && $blockDescription !== '' ? $blockDescription : __('doman.values.description') }}</p>
            </div>
            <div class="doman-values-heading-mark" aria-hidden="true">
                <span>{{ str_pad((string) $valueCount, 2, '0', STR_PAD_LEFT) }}</span>
                <small>{{ __('doman.values.mark_label') }}</small>
            </div>
        </div>

        <div class="doman-values-grid">
            @foreach($BannersList as $TextBanner)
                @php
                    $valueTitle = (string) ($TextBanner->$title_var ?: $TextBanner->$title_var2);
                    $valueDetails = (string) ($TextBanner->$details_var ?: $TextBanner->$details_var2);
                    $valueFile = (string) ($TextBanner->$file_var ?: $TextBanner->$file_var2);
                    $valueLink = (string) $TextBanner->$link_var;
                @endphp
                <article class="doman-value-card {{ $loop->first ? 'doman-value-card--featured' : '' }}">
                    <div class="doman-value-card-art" aria-hidden="true"><span></span><span></span></div>
                    <div class="doman-value-card-top">
                        {{-- <span class="doman-value-card-number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span> --}}
                        <span class="doman-value-card-symbol" aria-hidden="true">
                            @if($TextBanner->icon)
                                <i class="{{ $TextBanner->icon }}"></i>
                            @elseif($valueFile !== '')
                                <img src="{{ route('fileView', ['path' => 'banners/'.$valueFile]) }}" alt="" loading="lazy">
                            @else
                                <span class="doman-value-card-glyph"></span>
                            @endif
                        </span>
                    </div>
                    <div class="doman-value-card-content">
                        @if($valueTitle !== '')<h3>{{ $valueTitle }}</h3>@endif
                        @if($valueDetails !== '')<p>{!! nl2br(e($valueDetails)) !!}</p>@endif
                    </div>
                    <div class="doman-value-card-bottom">
                        <span>{{ __('doman.brand_wordmark') }}</span>
                        @if($valueLink !== '')
                            <a href="{{ $valueLink }}" aria-label="{{ $valueTitle }}"><i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
                        @else
                            <span class="doman-value-card-end" aria-hidden="true"></span>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
        <div class="doman-values-footer" aria-hidden="true">
            <span>{{ __('doman.values.footer_left') }}</span>
            <span>{{ __('doman.values.footer_right') }}</span>
        </div>
    </div>
</section>
