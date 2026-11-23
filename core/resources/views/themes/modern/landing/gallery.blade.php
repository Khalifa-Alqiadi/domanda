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
$PhotosLimit = @$TopicBlockContents->records_count;
if (@$TopicBlockContents->module_id) {
    $BlockTopics = Helper::Topics(@$TopicBlockContents->module_id, @$TopicBlockContents->category_ids,
        @$TopicBlockContents->records_count, 0, @$TopicBlockContents->records_order);
    $section_url = Helper::sectionURL(@$TopicBlockContents->module_id);
}
?>

@if(count($BlockTopics) >0)
    <section id="landing-block-{{ @$TopicBlock->id }}" class="gallery landing-block doman-gallery {{ @$TopicBlock->css_classes  }}" style="{{ $block_style }}">
        <div class="container">
            <div class="doman-gallery-heading">
                <div class="doman-gallery-heading-copy">
                    <span class="doman-gallery-eyebrow"><span aria-hidden="true"></span>{{ __('doman.gallery.eyebrow') }}</span>
                    @if(@$TopicBlock->title_status)
                        <h2>{{ @$TopicBlockContents->$title_var ?: @$TopicBlockContents->$title_var2 }}</h2>
                    @endif
                    @if(@$TopicBlock->desc_status)
                        <p>{{ strip_tags(@$TopicBlockContents->{"desc_".@Helper::currentLanguage()->code} ?: @$TopicBlockContents->{"desc_".config('smartend.default_language')}) }}</p>
                    @endif
                </div>
                @if(@$TopicBlock->more_btn_status)
                    <a href="{{ url($section_url) }}" class="doman-gallery-all">
                        <span>{{ __('doman.gallery.view_all') }}</span>
                        <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
                    </a>
                @endif
            </div>
        </div>

        <div class="container-fluid gallery-showcase">
            <div class="gallery-deck" role="list">
                    <?php
                    $ph_count = 0;
                    ?>
                @foreach($BlockTopics as $BlockTopic)
                        <?php
                        if ($BlockTopic->$title_var != "") {
                            $title = $BlockTopic->$title_var;
                        } else {
                            $title = $BlockTopic->$title_var2;
                        }

                        ?>
                    @foreach($BlockTopic->photos as $photo)
                        @if($ph_count<$PhotosLimit)
                            <div class="gallery-deck-item" role="listitem">
                                <div class="gallery-item" data-motion="fade-up" data-motion-delay="{{ min(($ph_count % 8) * 85, 520) }}">
                                    <a href="{{ route("fileView",["path" =>'topics/'.$photo->file ]) }}"
                                       class="galelry-lightbox gallery-card-link" title="{{ $title }}"
                                       aria-label="{{ $title }}">
                                        <img src="{{ route("fileView",["path" =>'topics/'.$photo->file ]) }}?w=1200&h=960"
                                             width="1200" height="960" loading="lazy"
                                             sizes="(min-width: 992px) 50vw, (min-width: 576px) 50vw, 100vw"
                                             alt="{{ $title }}" class="gallery-card-image">
                                        <span class="doman-gallery-card-index" aria-hidden="true">{{ str_pad((string) ($ph_count + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                        <span class="doman-gallery-card-footer">
                                            <span class="doman-gallery-card-copy">
                                                <small>{{ __('doman.gallery.image_label') }}</small>
                                                <strong>{{ $title }}</strong>
                                            </span>
                                            <span class="gallery-card-action" aria-hidden="true">
                                                <i class="bi bi-arrow-up-right"></i>
                                            </span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        @else
                            @break
                        @endif
                            <?php
                            $ph_count++;
                            ?>
                    @endforeach
                @endforeach

            </div>
        </div>
    </section>
@endif
