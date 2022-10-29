<?php

namespace Ophim\ThemePmc;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ThemePmcServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultThemeCustomizer();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'themes');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/pmc')
        ], 'pmc-assets');
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['themes' => array_merge(config('themes', []), [
            'pmc' => [
                'name' => 'Theme PMC',
                'author' => 'opdlnf01@gmail.com',
                'package_name' => 'ophimcms/theme-pmc',
                'publishes' => ['pmc-assets'],
                'preview_image' => '',
                'options' => [
                    [
                        'name' => 'recommendations_limit',
                        'label' => 'Recommendations Limit',
                        'type' => 'number',
                        'hint' => 'Number',
                        'value' => 10,
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'latest',
                        'label' => 'Home Page',
                        'type' => 'code',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_more_url|show_template (section_poster_1|section_poster_2)',
                        'value' => "Phim lẻ mới||type|single|updated_at|desc|12|/danh-sach/phim-le|section_poster_1\r\nPhim bộ mới||type|series|updated_at|desc|10|/danh-sach/phim-bo|section_poster_2\r\nPhim thịnh hành||is_copyright|0|view_week|desc|7||section_poster_1",
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'additional_css',
                        'label' => 'Additional CSS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'body_attributes',
                        'label' => 'Body attributes',
                        'type' => 'text',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'additional_header_js',
                        'label' => 'Header JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_body_js',
                        'label' => 'Body JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_footer_js',
                        'label' => 'Footer JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'footer',
                        'label' => 'Footer',
                        'type' => 'code',
                        'value' => <<<EOT
                        <div id="footer">
                            <div class="container">
                                <a id="footer-logo" class="column" href="">
                                    <img src="https://ophim.cc/logo-ophim-5.png" alt="" />
                                </a>
                                <div class="column contact">
                                    <p>Phim Mới</p>
                                    <ul>
                                        <li><a href="" title="Phim chiếu rạp">Phim chiếu rạp</a></li>
                                        <li><a href="" title="Phim lẻ hay">Phim lẻ</a></li>
                                        <li><a href="" title="Phim bộ hay">Phim bộ</a></li>
                                    </ul>
                                </div>
                                <div class="column ">
                                    <p>Phim Hay</p>
                                    <ul>
                                        <li><a href="" title="Phim Mỹ">Phim Mỹ</a></li>
                                        <li><a href="" title="Phim Hàn Quốc">Phim Hàn Quốc</a></li>
                                    </ul>
                                </div>
                                <div class="column">
                                    <p>Phim Hot</p>
                                    <ul>
                                        <ul>
                                            <li><a title="phimmoi" href="">Phimmoi</a></li>
                                        </ul>
                                    </ul>
                                </div>
                                <div class="column">
                                    <p>Trợ giúp</p>
                                    <ul>
                                        <li><a href="javascript:void(0)">Hỏi đáp</a></li>
                                        <li><a rel="nofollow" href="">Liên hệ</a></li>
                                        <li><a href="javascript:void(0)">Tin tức</a></li>
                                    </ul>
                                </div>
                                <div class="column">
                                    <p>Thông tin</p>
                                    <ul>
                                        <li><a href="">Điều khoản sử dụng</a></li>
                                        <li><a href="">Chính sách riêng tư</a></li>
                                        <li><a href="">Khiếu nại bản quyền</a></li>
                                        <li>&copy; 2022</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'tag_box',
                        'label' => 'Tag Box',
                        'type' => 'code',
                        'value' => <<<EOT
                        <div class="container" id="tag-box">
                            <p>
                                <a class="btn btn-dark btn-xs btn-rounded" title="quái vật" href="">quái vật</a>
                                <a class="btn btn-dark btn-xs btn-rounded" title="xã hội đen" href="">xã hội đen</a>
                                <a class="btn btn-dark btn-xs btn-rounded" title="khủng bố" href="">khủng bố</a>
                                <a class="btn btn-dark btn-xs btn-rounded" title="phù thủy" href="">phù thủy</a>
                                <a class="btn btn-dark btn-xs btn-rounded" title="châu tinh trì" href="">châu tinh trì</a>
                            </p>
                        </div>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'ads_header',
                        'label' => 'Ads header',
                        'type' => 'code',
                        'value' => <<<EOT
                        <img src="" alt="">
                        EOT,
                        'tab' => 'Ads'
                    ],
                    [
                        'name' => 'ads_catfish',
                        'label' => 'Ads catfish',
                        'type' => 'code',
                        'value' => <<<EOT
                        <img src="" alt="">
                        EOT,
                        'tab' => 'Ads'
                    ]
                ],
            ]
        ])]);
    }
}
