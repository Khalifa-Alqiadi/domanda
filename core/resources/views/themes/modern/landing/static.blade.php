<?php
$block_style = "";
if (@$TopicBlock->bg_color != "") {
    $block_style = "background-color: ".@$TopicBlock->bg_color.";";
}
if (@$TopicBlock->divider_status) {
    @$TopicBlock->css_classes .= " divider";
}
if (@$TopicBlock->image_status && @$TopicBlockContents->{"bg_".@Helper::currentLanguage()->code} !="") {
    $block_style .= "background-image: url(".route("fileView",["path" =>'topics/'.@$TopicBlockContents->{"bg_". @Helper::currentLanguage()->code}]).");background-size:cover;background-repeat: no-repeat;background-position: center top;";
}
?>
@php
    $isAboutBlock = in_array('about-us', preg_split('/\s+/', trim((string) @$TopicBlock->css_classes), -1, PREG_SPLIT_NO_EMPTY), true);
    $staticDetails = (string) (@$TopicBlockContents->{"details_" . @Helper::currentLanguage()->code} ?? '');
    $aboutImage = '';
    if ($isAboutBlock && preg_match('/<img\b[^>]*>/i', $staticDetails, $aboutImageMatch)) {
        $aboutImage = $aboutImageMatch[0];
        $staticDetails = preg_replace('/<img\b[^>]*>/i', '', $staticDetails, 1);
        $staticDetails = preg_replace('/<p\b[^>]*>\s*(?:&nbsp;|<br\s*\/?\s*>|\s)*<\/p>/i', '', $staticDetails);
    }
@endphp
<section id="landing-block-{{ @$TopicBlock->id }}" class="landing-block {{ @$TopicBlock->css_classes  }}" style="{{ $block_style }}">
    <div class="container">
        @if($isAboutBlock)
            <div class="doman-about-layout">
                <div class="doman-about-copy">
                    <span class="doman-about-eyebrow"><span aria-hidden="true"></span>{{ __('frontend.aboutStory') }}</span>
                    @if(@$TopicBlock->title_status || @$TopicBlock->desc_status)
                        <div class="section-title">
                            @if(@$TopicBlock->title_status)
                                <h2>{{ @$TopicBlockContents->{"title_".@Helper::currentLanguage()->code} }}</h2>
                            @endif
                            @if(@$TopicBlock->desc_status)
                                <p>{!! nl2br(@$TopicBlockContents->{"desc_".@Helper::currentLanguage()->code}) !!}</p>
                            @endif
                        </div>
                    @endif
                    <div class="doman-about-prose">{!! str_replace('"#','"'.Request::url().'#', $staticDetails) !!}</div>
                </div>
                @if($aboutImage !== '')
                    <div class="doman-about-visual">
                        <div class="doman-about-visual-frame">
                            <span class="doman-about-visual-orbit" aria-hidden="true"></span>
                            <div class="doman-about-visual-logo">{!! $aboutImage !!}</div>
                            <span class="doman-about-visual-mark" aria-hidden="true"></span>
                        </div>
                    </div>
                @endif
            </div>
        @else
        @if(@$TopicBlock->title_status || @$TopicBlock->desc_status)
            <div class="section-title">
                @if(@$TopicBlock->title_status)
                    <h2>{{ @$TopicBlockContents->{"title_".@Helper::currentLanguage()->code} }}</h2>
                @endif
                @if(@$TopicBlock->desc_status)
                    <p>{!! nl2br(@$TopicBlockContents->{"desc_".@Helper::currentLanguage()->code}) !!}</p>
                @endif
            </div>
        @endif
        {!! str_replace('"#','"'.Request::url().'#',@$TopicBlockContents->{"details_".@Helper::currentLanguage()->code}) !!}
        @endif
    </div>
</section>
