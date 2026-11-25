<?php
$title_var = "title_".@Helper::currentLanguage()->code;
$title_var2 = "title_".config('smartend.default_language');
$details_var = "details_".@Helper::currentLanguage()->code;
$details_var2 = "details_".config('smartend.default_language');

$block_style = "";
if (@$TopicBlock->bg_color != "") {
    $block_style = "background-color: ".@$TopicBlock->bg_color.";";
}
if (@$TopicBlock->divider_status) {
    @$TopicBlock->css_classes .= " divider";
}
if (@$TopicBlock->image_status && @$TopicBlockContents->{"bg_".@Helper::currentLanguage()->code} != "") {
    $block_style .= "background-image: url(".route("fileView",
            ["path" => 'topics/'.@$TopicBlockContents->{"bg_".@Helper::currentLanguage()->code}]).");background-size:cover;background-repeat: no-repeat;background-position: center top;";
}
$BlockTopics = [];
$section_url = "";
$blockCssClasses = preg_split('/\s+/', trim((string) @$TopicBlock->css_classes), -1, PREG_SPLIT_NO_EMPTY);
$isProductsBlock = in_array('products', $blockCssClasses, true);
$isNewsBlock = in_array('latest-news', $blockCssClasses, true);
if (@$TopicBlockContents->module_id) {
    $BlockTopics = Helper::Topics(@$TopicBlockContents->module_id, @$TopicBlockContents->category_ids,
        @$TopicBlockContents->records_count, 0, @$TopicBlockContents->records_order);
    $section_url = Helper::sectionURL(@$TopicBlockContents->module_id);
}
?>

@if(count($BlockTopics) >0)
    <section id="landing-block-{{ @$TopicBlock->id }}" class="landing-block modern-works {{ $isProductsBlock ? 'doman-products' : '' }} {{ $isNewsBlock ? 'doman-news' : '' }} {{ @$TopicBlock->css_classes  }}" style="{{ $block_style }}">
        <div class="container">
            @if($isProductsBlock)
                <div class="doman-products-intro">
                    <div class="doman-products-intro-copy">
                        <span class="doman-products-eyebrow"><span aria-hidden="true"></span>{{ __('doman.products.eyebrow') }}</span>
                        @if(@$TopicBlock->title_status)
                            <h2>{{ @$TopicBlockContents->$title_var ?: @$TopicBlockContents->$title_var2 }}</h2>
                        @endif
                        @if(@$TopicBlock->desc_status)
                            <p>{{ strip_tags(@$TopicBlockContents->{"desc_".@Helper::currentLanguage()->code} ?: @$TopicBlockContents->{"desc_".config('smartend.default_language')}) }}</p>
                        @endif
                    </div>
                    @if(@$TopicBlock->more_btn_status)
                        <a class="doman-products-all" href="{{ url($section_url) }}">
                            <span>{{ __('doman.products.view_all') }}</span>
                            <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
                        </a>
                    @endif
                </div>
            @elseif($isNewsBlock)
                <div class="doman-news-intro">
                    <div class="doman-news-intro-copy">
                        <span class="doman-news-eyebrow"><span aria-hidden="true"></span>{{ __('doman.news.eyebrow') }}</span>
                        @if(@$TopicBlock->title_status)
                            <h2>{{ @$TopicBlockContents->$title_var ?: @$TopicBlockContents->$title_var2 }}</h2>
                        @endif
                        @if(@$TopicBlock->desc_status)
                            <p>{{ strip_tags(@$TopicBlockContents->{"desc_".@Helper::currentLanguage()->code} ?: @$TopicBlockContents->{"desc_".config('smartend.default_language')}) }}</p>
                        @endif
                    </div>
                    @if(@$TopicBlock->more_btn_status)
                        <a class="doman-news-all" href="{{ url($section_url) }}">
                            <span>{{ __('doman.news.view_all') }}</span>
                            <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
                        </a>
                    @endif
                </div>
            @elseif(@$TopicBlock->title_status || @$TopicBlock->desc_status)
                <div class="section-title">
                    @if(@$TopicBlock->title_status)
                        <h2>{{ @$TopicBlockContents->{"title_".@Helper::currentLanguage()->code} }}</h2>
                    @endif
                    @if(@$TopicBlock->desc_status)
                        <p>{!! nl2br(@$TopicBlockContents->{"desc_".@Helper::currentLanguage()->code}) !!}</p>
                    @endif
                </div>
            @endif
            <div class="modern-works-slider {{ $isProductsBlock ? 'doman-products-slider' : '' }} {{ $isNewsBlock ? 'doman-news-slider' : '' }} swiper">
                <div class="swiper-wrapper">
                    @foreach($BlockTopics as $Topic)
                            <?php
                            if ($Topic->$title_var != "") {
                                $title = $Topic->$title_var;
                            } else {
                                $title = $Topic->$title_var2;
                            }
                            $details = $Topic->$details_var ?: $Topic->$details_var2;
                            $topic_link_url = Helper::topicURL($Topic->id, "", $Topic);
                            $HomeSectionType = @$Topic->webmasterSection->type;
                            if (!@$require_mp3_player && $HomeSectionType == 3) {
                                $require_mp3_player = 1;
                            }
                            ?>
                        <div class="swiper-slide modern-works-slide">
                            @if($isProductsBlock)
                                <?php
                                $productImage = '';
                                if (@$Topic->photo_file != '') {
                                    $productImage = route('fileView', ['path' => 'topics/'.$Topic->photo_file]).'?w=850&h=850';
                                } elseif (@$Topic->photos && count($Topic->photos) > 0) {
                                    $productImage = route('fileView', ['path' => 'topics/'.$Topic->photos->first()->file]).'?w=850&h=850';
                                } else {
                                    foreach (@$Topic->webmasterSection->customFields->where('type', 8) as $productPhotoField) {
                                        if ($productPhotoField->lang_code == 'all' || $productPhotoField->lang_code == @Helper::currentLanguage()->code) {
                                            foreach (@$Topic->fields->where('field_id', $productPhotoField->id) as $productPhoto) {
                                                if (@$productPhoto->field_value != '') {
                                                    $productImage = route('fileView', ['path' => 'topics/'.$productPhoto->field_value]).'?w=850&h=850';
                                                    break 2;
                                                }
                                            }
                                        }
                                    }
                                }
                                $productCategory = @$Topic->category($Topic->id);
                                $productCategoryTitle = @$productCategory->$title_var ?: @$productCategory->$title_var2;
                                ?>
                                <article class="doman-product-card">
                                    <a href="{{ $topic_link_url }}" class="doman-product-link" aria-label="{{ $title }}">
                                        <div class="doman-product-stage">
                                            @if($productCategoryTitle != '')
                                                <span class="doman-product-category">{{ $productCategoryTitle }}</span>
                                            @endif
                                            @if($productImage != '')
                                                <img class="doman-product-image" src="{{ $productImage }}" alt="{{ Helper::topicPhotoAlt($Topic) }}" loading="lazy">
                                            @else
                                                <span class="doman-product-placeholder" aria-hidden="true">{{ __('doman.brand_wordmark') }}</span>
                                            @endif
                                            {{-- <span class="doman-product-stage-mark" aria-hidden="true">{{ __('doman.brand_wordmark') }}</span> --}}
                                        </div>
                                        <div class="doman-product-info">
                                            <div>
                                                <span class="doman-product-info-label">{{ __('doman.products.collection_label') }}</span>
                                                <h3>{{ $title }}</h3>
                                                @if($details != '')
                                                    <p>{{ strip_tags($details) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="doman-product-bottom">{{ __('doman.products.card_link') }} <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
                                    </a>
                                </article>
                            @elseif($isNewsBlock)
                                <?php
                                $newsImage = '';
                                if (@$Topic->photo_file != '') {
                                    $newsImage = route('fileView', ['path' => 'topics/'.$Topic->photo_file]).'?w=1280&h=720&r=fit';
                                } elseif (@$Topic->photos && count($Topic->photos) > 0) {
                                    $newsImage = route('fileView', ['path' => 'topics/'.$Topic->photos->first()->file]).'?w=1280&h=720&r=fit';
                                } else {
                                    foreach (@$Topic->webmasterSection->customFields->where('type', 8) as $newsPhotoField) {
                                        if ($newsPhotoField->lang_code == 'all' || $newsPhotoField->lang_code == @Helper::currentLanguage()->code) {
                                            foreach (@$Topic->fields->where('field_id', $newsPhotoField->id) as $newsPhoto) {
                                                if (@$newsPhoto->field_value != '') {
                                                    $newsImage = route('fileView', ['path' => 'topics/'.$newsPhoto->field_value]).'?w=1280&h=720&r=fit';
                                                    break 2;
                                                }
                                            }
                                        }
                                    }
                                }
                                $newsCategory = @$Topic->category($Topic->id);
                                $newsCategoryTitle = @$newsCategory->$title_var ?: @$newsCategory->$title_var2;
                                $newsNumber = str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT);
                                ?>
                                <article class="doman-news-card">
                                    <a class="doman-news-card-link" href="{{ $topic_link_url }}" aria-label="{{ $title }}">
                                        <div class="doman-news-media">
                                            @if($newsImage != '')
                                                <img src="{{ $newsImage }}" alt="{{ Helper::topicPhotoAlt($Topic) }}" loading="lazy" width="1280" height="720">
                                            @else
                                                <span class="doman-news-image-fallback">{{ __('doman.brand_wordmark') }}</span>
                                            @endif
                                            {{-- <span class="doman-news-image-index" aria-hidden="true">{{ $newsNumber }}</span> --}}
                                            {{-- @if(@$Topic->date)
                                                <time class="doman-news-date" datetime="{{ date('Y-m-d', strtotime($Topic->date)) }}">{{ Helper::formatDate($Topic->date) }}</time>
                                            @endif --}}
                                        </div>
                                        <div class="doman-news-body">
                                            <div class="doman-news-meta">
                                                {{-- <span class="doman-news-category">{{ $newsCategoryTitle ?: __('doman.news.category') }}</span> --}}
                                                <span class="doman-news-meta-rule" aria-hidden="true"></span>
                                                <span>{{ __('doman.news.eyebrow') }}</span>
                                            </div>
                                            <h3>{{ $title }}</h3>
                                            @if($details != '')
                                                <p>{{ strip_tags($details) }}</p>
                                            @endif
                                            <span class="doman-news-read"><span>{{ __('doman.news.read_article') }}</span><i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
                                        </div>
                                    </a>
                                </article>
                            @else
                                @include(theme_view("topic.works-card"),["Topic"=>$Topic])
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="modern-works-slider-controls">
                    <button type="button" class="modern-works-slider-button modern-works-slider-prev"
                            aria-label="{{ html_entity_decode(__('pagination.previous')) }}">
                        <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i>
                    </button>
                    <div class="modern-works-slider-pagination" aria-hidden="true"></div>
                    <button type="button" class="modern-works-slider-button modern-works-slider-next"
                            aria-label="{{ html_entity_decode(__('pagination.next')) }}">
                        <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            @if (@$TopicBlock->more_btn_status && !$isProductsBlock && !$isNewsBlock)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="more-btn">
                            <a href="{{ url($section_url) }}" class="btn btn-theme">
                                {{ __('frontend.viewMore') }}
                                <i class="fa-solid fa-arrow-right-long staff-cta-arrow" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endif
