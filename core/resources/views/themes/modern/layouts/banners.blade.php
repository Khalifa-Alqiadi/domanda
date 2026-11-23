@if(@$BannersSettingsId >0)
        <?php
        $title_var = "title_".@Helper::currentLanguage()->code;
        $title_var2 = "title_".config('smartend.default_language');
        $details_var = "details_".@Helper::currentLanguage()->code;
        $details_var2 = "details_".config('smartend.default_language');

        // Get banners list array by settings ID (You can get settings ID from Webmaster >> Banners settings)
        $BannersList = Helper::BannersList($BannersSettingsId);
        ?>
    @if(count($BannersList)>0)
        <div class="widget">
            <!-- Slider -->
                <?php
                $SideBanner_type = 0;
                ?>
            @foreach($BannersList->slice(0,1) as $SideBanner)
                    <?php
                    try {
                        $SideBanner_type = $SideBanner->webmasterBanner->type;
                    } catch (Exception $e) {
                        $SideBanner_type = 0;
                    }
                    ?>
            @endforeach
                <?php
                $title_var = "title_".@Helper::currentLanguage()->code;
                $details_var = "details_".@Helper::currentLanguage()->code;
                $file_var = "file_".@Helper::currentLanguage()->code;
                $file_var2 = "file_".config('smartend.default_language');
                $link_var = "link_".@Helper::currentLanguage()->code;
                ?>
            @if(!empty($isCoreValuesBlock) && $SideBanner_type==0)
                @include(theme_view('landing.core-values'))
            @elseif(!empty($isMissionAndVisionBlock) && $SideBanner_type==0)
                <section class="doman-vm-stage" aria-labelledby="doman-vm-title-{{ (int) $TopicBlock->id }}">
                    <div class="container">
                        <div class="doman-vm-topline" aria-hidden="true">
                            <span>{{ __('doman.vision_mission.topline') }}</span>
                            <span>{{ __('doman.vision_mission.nature_line') }}</span>
                        </div>
                        <div class="doman-vm-layout">
                            <div class="doman-vm-intro">
                                <span class="doman-vm-kicker">{{ __('doman.vision_mission.kicker') }}</span>
                                <h2 id="doman-vm-title-{{ (int) $TopicBlock->id }}">{{ __('doman.vision_mission.heading') }}</h2>
                                <span class="doman-vm-intro-line" aria-hidden="true"></span>
                                <p>{{ __('doman.vision_mission.description') }}</p>
                                <span class="doman-vm-wordmark" aria-hidden="true">{{ __('doman.brand_wordmark') }}</span>
                            </div>
                            <div class="doman-vm-panels">
                                @foreach($BannersList as $TextBanner)
                                    @php
                                        $BTitle = $TextBanner->$title_var ?: $TextBanner->$title_var2;
                                        $BDetails = $TextBanner->$details_var ?: $TextBanner->$details_var2;
                                        $BLink = $TextBanner->$link_var;
                                    @endphp
                                    <article class="doman-vm-panel {{ $loop->first ? 'doman-vm-panel--vision' : 'doman-vm-panel--mission' }}">
                                        <div class="doman-vm-panel-art" aria-hidden="true"><span></span><span></span><span></span></div>
                                        <div class="doman-vm-panel-top">
                                            <span>{{ __('doman.vision_mission.panel_number', ['number' => str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT)]) }}</span>
                                            <span class="doman-vm-panel-mark" aria-hidden="true">✦</span>
                                        </div>
                                        <div class="doman-vm-panel-body">
                                            @if($BTitle !== '')<h3>{{ $BTitle }}</h3>@endif
                                            @if($BDetails !== '')<p>{!! nl2br(e($BDetails)) !!}</p>@endif
                                        </div>
                                        <div class="doman-vm-panel-bottom">
                                            <span>{{ __('doman.brand_company') }}</span>
                                            @if($BLink)
                                                <a href="{{ $BLink }}" aria-label="{{ $BTitle }}"><i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
                                            @else
                                                <span class="doman-vm-panel-dot" aria-hidden="true"></span>
                                            @endif
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            @elseif($SideBanner_type==0)
                {{-- Text/Code Banners--}}
                    <?php
                    $media_banners = $BannersList->where("icon", "!=", "")->count();
                    ?>
                <section class="{{ ($media_banners >0)?"services":"" }}">
                    <div class="container">
                        <div class="row">
                                <?php
                                $col_width = 12;
                                $col_md_width = 12;
                                if (count($BannersList) == 2) {
                                    $col_width = 6;
                                    $col_md_width = 6;
                                }
                                if (count($BannersList) == 3) {
                                    $col_width = 4;
                                    $col_md_width = 6;
                                }
                                if (count($BannersList) > 3) {
                                    $col_width = 3;
                                    $col_md_width = 6;
                                }
                                ?>
                            @foreach($BannersList as $TextBanner)
                                    <?php
                                    if ($TextBanner->$title_var != "") {
                                        $BTitle = $TextBanner->$title_var;
                                    } else {
                                        $BTitle = $TextBanner->$title_var2;
                                    }
                                    if ($TextBanner->$details_var != "") {
                                        $BDetails = $TextBanner->$details_var;
                                    } else {
                                        $BDetails = $TextBanner->$details_var2;
                                    }
                                    if ($TextBanner->$file_var != "") {
                                        $BFile = $TextBanner->$file_var;
                                    } else {
                                        $BFile = $TextBanner->$file_var2;
                                    }
                                    ?>
                                <div class="col-lg-{{$col_width}} col-md-{{ $col_md_width }} d-flex align-items-stretch mb-3">
                                    @if($TextBanner->$link_var !="")
                                        <a href="{!! $TextBanner->$link_var !!}">
                                            @endif
                                            <div class="{{ ($media_banners >0)?"icon-box":"" }}">
                                                @if($TextBanner->code !="")
                                                    {!! $TextBanner->code !!}
                                                @else

                                                    @if($TextBanner->icon !="")
                                                        <div class="icon">
                                                            <i class="{{$TextBanner->icon}} fa-3x"></i>
                                                        </div>
                                                    @elseif($BFile !="")
                                                        <img src="{{ route("fileView",["path" =>'banners/'.$BFile ]) }}" loading="lazy"
                                                             alt="{{ $BTitle }}"/>
                                                    @endif
                                                    <h2>{!! $BTitle !!}</h2>
                                                    @if($BDetails !="")
                                                        <p>{!! nl2br($BDetails) !!}</p>
                                                    @endif

                                                @endif
                                            </div>
                                            @if($TextBanner->$link_var !="")
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @elseif($SideBanner_type==1)
                {{-- Photo Slider Banners--}}
                <div class="container">
                    <div class="row">
                        @foreach($BannersList as $SideBanner)
                            <div class="col-lg-12 col-md-12 text-center">
                                @if($SideBanner->$link_var !="")
                                    <a href="{!! $SideBanner->$link_var !!}">
                                        @endif
                                        @if($SideBanner->$file_var !="")
                                            <img src="{{ route("fileView",["path" =>'banners/'.$SideBanner->$file_var ]) }}"
                                                 alt="{{ $SideBanner->$title_var }}"/>
                                        @endif
                                        @if($SideBanner->$link_var !="")
                                    </a>
                                @endif
                                @if($SideBanner->$details_var !="")
                                    <p>{!! nl2br($SideBanner->$details_var) !!}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Video Banners--}}
                <div class="container">
                    <div class="row">
                        @foreach($BannersList as $SideBanner)
                            <div class="col-lg-12 col-md-12 text-center">
                                @if($SideBanner->youtube_link !="")
                                    @if($SideBanner->video_type ==1)
                                            <?php
                                            $Youtube_id = Helper::Get_youtube_video_id($SideBanner->youtube_link);
                                            ?>
                                        @if($Youtube_id !="")
                                            {{-- Youtube Video --}}
                                            <iframe width="100%" height="500" frameborder="0" allowfullscreen
                                                    src="https://www.youtube.com/embed/{{ $Youtube_id }}?autoplay=1&mute=1" allow="autoplay">
                                            </iframe>
                                        @endif
                                    @elseif($SideBanner->video_type ==2)
                                            <?php
                                            $Vimeo_id = Helper::Get_vimeo_video_id($SideBanner->youtube_link);
                                            ?>
                                        @if($Vimeo_id !="")
                                            {{-- Vimeo Video --}}
                                            <iframe width="100%" height="500" frameborder="0" allowfullscreen
                                                    src="https://player.vimeo.com/video/{{ $Vimeo_id }}?title=0&amp;byline=0">
                                            </iframe>
                                        @endif
                                    @endif
                                @endif
                                @if($SideBanner->video_type ==0)
                                    @if($SideBanner->$file_var !="")
                                        {{-- Direct Video --}}
                                        <video width="100%" height="500" controls>
                                            <source src="{{ route("fileView",["path" =>'banners/'.$SideBanner->$file_var ]) }}"
                                                    type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                @endif
                                @if($SideBanner->$details_var !="")
                                    <div>{!! $SideBanner->$details_var !!}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <!-- end slider -->
        </div>
    @endif
@endif
