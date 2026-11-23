<?php

namespace Database\Seeders;

use App\Models\Topic;
use App\Models\TopicBlock;
use App\Models\Banner;
use App\Models\Setting;
use App\Models\WebmasterSetting;
use App\Models\WebmasterBanner;
use App\Models\WebmasterSection;
use Illuminate\Database\Seeder;

/**
 * Domanda content structure. Run after the standard seeders:
 * php artisan db:seed --class=DomandaSeeder
 *
 * Content and palette are taken from the supplied Doman brand guidelines.
 */
class DomandaSeeder extends Seeder
{
    public function run(): void
    {
        $home = Topic::query()->where('webmaster_id', 1)
            ->where('seo_url_slug_en', 'home')->firstOrFail();

        // Keep the starter blocks editable, but hide them from the Domanda homepage.
        TopicBlock::query()->where('topic_id', $home->id)
            ->where('block_name', 'not like', 'Domanda: %')
            ->update(['status' => 0]);

        $modules = WebmasterSection::query()->whereIn('title_en', [
            'Services', 'Products', 'News', 'Partners',
        ])->get()->keyBy('title_en');

        foreach (['Services', 'Products', 'News', 'Partners'] as $name) {
            if (!isset($modules[$name])) {
                throw new \RuntimeException("Required module is missing: {$name}");
            }
        }

        $hero = WebmasterBanner::query()->firstOrCreate(
            ['title_en' => 'Domanda hero'],
            ['row_no' => 4, 'title_ar' => 'واجهة دومان', 'width' => 1600,
                'height' => 600, 'desc_status' => 1, 'link_status' => 0,
                'icon_status' => 0, 'type' => 0, 'status' => 1, 'created_by' => 1]
        );
        $profile = WebmasterBanner::query()->firstOrCreate(
            ['title_en' => 'Domanda identity banners'],
            [
                'row_no' => 5, 'title_ar' => 'بنرات هوية دومان',
                'width' => 1600, 'height' => 600, 'desc_status' => 1,
                'link_status' => 0, 'icon_status' => 0, 'type' => 0,
                'status' => 1, 'created_by' => 1,
            ]
        );
        WebmasterSetting::query()->update(['home_banners_section_id' => $hero->id]);

        $this->banner($hero->id, 1, 'دومان للألبان والأغذية', 'Doman Dairy & Food Co.',
            'منتجات غذائية موثوقة تجمع بين الجودة والطبيعة والبساطة الحديثة.',
            'Trusted nutritional products combining quality, nature, and modern simplicity.');
        $this->banner($profile->id, 1, 'رؤيتنا', 'Our vision',
            'أن نكون الوجهة المفضلة لمستهلكي الألبان ومشتقاتها من خلال تقديم منتجات تجمع بين الجودة والثقة والطبيعة بأسلوب إنتاج حديث ومستدام.',
            'To become the preferred destination for dairy consumers by delivering products that combine quality, trust, and natural value through modern and sustainable production methods.');
        $this->banner($profile->id, 2, 'رسالتنا', 'Our mission',
            'تقديم منتجات غذائية ذات قيمة وجودة موثوقة من خلال اتباع طرق أكثر ذكاءً في إنتاج الألبان ومشتقاتها بما يحقق احتياجات المستهلك ويعزز جودة الصناعات المحلية.',
            'To provide trusted, high-quality nutritional products through smarter dairy production methods that meet consumer needs and contribute to strengthening local industries.');

        Setting::query()->where('status', 1)->update([
            'site_title_ar' => 'دومان للألبان والأغذية',
            'site_title_en' => 'Doman Dairy & Food Co.',
            'site_desc_ar' => 'شركة يمنية متخصصة في إنتاج الألبان ومشتقاتها، تقدم منتجات غذائية موثوقة تجمع بين الجودة والطبيعة والبساطة الحديثة.',
            'site_desc_en' => 'A Yemeni dairy and food brand delivering trusted nutritional products that combine quality, nature, and modern simplicity.',
            'style_color1' => '#333399', 'style_color2' => '#000066',
            'style_color3' => '#339933', 'style_color4' => '#FFCC00',
            'style_footer_bg' => null,
        ]);

        $blocks = [
            ['الواجهة الرئيسية', 'Hero', 2, $this->bannerContent($hero->id, 'slider')],
            ['من نحن', 'About Domanda', 0, $this->staticContent('من نحن', 'About us',
                'شركة دومان للألبان والأغذية علامة تجارية يمنية متخصصة في إنتاج الألبان ومشتقاتها. تأسست لتقديم منتجات غذائية موثوقة تجمع بين الجودة والطبيعة والبساطة الحديثة، وتلبي احتياجات المستهلك اليومية مع التركيز على الجودة المستقرة والقيمة الغذائية والثقة.',
                'Doman Dairy & Food Co. is a Yemeni brand specialized in dairy products and food derivatives. It delivers trusted nutritional products combining quality, nature, and modern simplicity, with consistent quality, nutritional value, and trust at its core.')],
            ['الرؤية والرسالة', 'Vision and mission', 2, $this->bannerContent($profile->id, 'banners')],
            ['قيمنا', 'Core values', 0, $this->staticContent('قيمنا الأساسية', 'Our core values',
                'الجودة: معايير مستقرة وموثوقة. الثقة: علاقة طويلة الأمد مع المستهلك. الطزاجة: الحفاظ على الطابع الطبيعي والطازج. البساطة: الوضوح في المنتجات والتواصل. الاستدامة: تطوير حلول تعكس الاستمرارية والنمو.',
                'Quality: consistent and reliable standards. Trust: lasting consumer relationships. Freshness: natural character. Simplicity: clarity in products and communication. Sustainability: solutions that support continuity and growth.')],
            ['قصتنا', 'Brand story', 0, $this->staticContent('قصتنا', 'Our story',
                'انطلقت دومان برؤية تهدف إلى تقديم منتجات ألبان وأغذية تجمع بين الجودة والطبيعة والثقة ضمن هوية حديثة تعكس تطور الصناعات الغذائية المحلية. وتعمل على بناء علاقة قريبة من المستهلك تقوم على الاعتمادية والاستمرارية والاهتمام بالتفاصيل.',
                'Doman was established to deliver dairy and food products combining quality, nature, and trust. It aims to build close consumer relationships through reliability, continuity, and attention to detail.')],
            ['منتجاتنا', 'Products', 3, $this->moduleContent('منتجاتنا', 'Our products', $modules['Products']->id, 'News', 8)],
            ['خدماتنا', 'Services', 3, $this->moduleContent('خدماتنا', 'Our services', $modules['Services']->id, 'News', 6)],
            ['آخر الأخبار', 'News', 3, $this->moduleContent('آخر الأخبار', 'Latest news', $modules['News']->id, 'News', 3)],
            ['شركاؤنا', 'Partners', 3, $this->moduleContent('شركاؤنا', 'Our partners', $modules['Partners']->id, 'Partners', 12)],
        ];

        foreach ($blocks as $index => [, $name, $type, $content]) {
            TopicBlock::query()->updateOrCreate(
                ['topic_id' => $home->id, 'block_name' => "Domanda: {$name}"],
                [
                    'row_no' => $index + 1, 'type' => $type,
                    'content' => json_encode($content, JSON_UNESCAPED_UNICODE),
                    'title_status' => in_array($type, [0, 3], true) ? 1 : 0,
                    'desc_status' => 0, 'image_status' => 0,
                    'divider_status' => 0, 'more_btn_status' => 0,
                    'status' => 1, 'created_by' => 1,
                ]
            );
        }
    }

    private function bannerContent(int $id, string $style): array
    {
        return ['title_ar' => '', 'desc_ar' => '', 'title_en' => '',
            'desc_en' => '', 'banner_area_id' => (string) $id,
            'banner_style' => $style];
    }

    private function staticContent(string $ar, string $en, string $bodyAr, string $bodyEn): array
    {
        return ['title_ar' => $ar, 'desc_ar' => '', 'details_ar' => '<p>'.e($bodyAr).'</p>',
            'bg_ar' => null, 'title_en' => $en, 'desc_en' => '',
            'details_en' => '<p>'.e($bodyEn).'</p>', 'bg_en' => null];
    }

    private function banner(int $section, int $order, string $ar, string $en, string $bodyAr, string $bodyEn): void
    {
        Banner::query()->updateOrCreate(
            ['section_id' => $section, 'row_no' => $order],
            ['title_ar' => $ar, 'title_en' => $en, 'details_ar' => $bodyAr,
                'details_en' => $bodyEn, 'status' => 1, 'created_by' => 1]
        );
    }

    private function moduleContent(string $ar, string $en, int $id, string $style, int $count): array
    {
        return ['title_ar' => $ar, 'desc_ar' => '', 'bg_ar' => null,
            'title_en' => $en, 'desc_en' => '', 'bg_en' => null,
            'module_id' => (string) $id, 'category_ids' => null,
            'records_count' => (string) $count, 'records_order' => '1',
            'view_style' => $style];
    }
}
