@php
    $readAlsoTopics = Helper::relatedTopics($Topic->id, $WebmasterSection->id, 4)->load('photos');
@endphp

@if($readAlsoTopics->isNotEmpty())
    <section class="doman-topic-related" aria-labelledby="doman-topic-related-title">
        <div class="doman-topic-related-heading">
            <div>
                <span class="doman-topic-related-eyebrow" aria-hidden="true"><span></span><span></span></span>
                <h2 id="doman-topic-related-title">{{ __('frontend.readAlso') }}</h2>
            </div>
            <span class="doman-topic-related-rule" aria-hidden="true"></span>
        </div>

        <div class="doman-topic-related-grid">
            @foreach($readAlsoTopics as $readAlsoTopic)
                @php
                    $readAlsoTitle = $readAlsoTopic->{$title_var} ?: $readAlsoTopic->{$title_var2};
                    $readAlsoUrl = Helper::topicURL($readAlsoTopic->id, '', $readAlsoTopic);
                    $readAlsoPhoto = $readAlsoTopic->photo_file ?: optional($readAlsoTopic->photos->first())->file;
                @endphp
                <a href="{{ $readAlsoUrl }}" class="doman-topic-related-card">
                    <span class="doman-topic-related-media">
                        @if(filled($readAlsoPhoto))
                            <img src="{{ route('fileView', ['path' => 'topics/'.$readAlsoPhoto]) }}?w=560&h=360&r=fit"
                                 alt="{{ Helper::topicPhotoAlt($readAlsoTopic) }}"
                                 width="560" height="360" loading="lazy" decoding="async">
                        @else
                            <span class="doman-topic-related-placeholder" aria-hidden="true"><i class="fa-regular fa-image"></i></span>
                        @endif
                        <span class="doman-topic-related-index" aria-hidden="true">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    </span>
                    <span class="doman-topic-related-content">
                        @if ($readAlsoTopic->date)
                            <time datetime="{{ date('Y-m-d', strtotime($readAlsoTopic->date)) }}">{{ Helper::formatDate($readAlsoTopic->date) }}</time>
                        @endif
                        <strong>{{ $readAlsoTitle }}</strong>
                        <span class="doman-topic-related-action">
                            <span>{{ __('frontend.readMore') }}</span>
                            <span class="doman-topic-related-arrow" aria-hidden="true"><i class="fa-solid fa-arrow-left-long"></i></span>
                        </span>
                    </span>
                </a>
            @endforeach
        </div>
    </section>
@endif
