<?php

namespace Ll\llcms;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;

class LlcmsServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/index.js',
    ];
	protected $css = [
		'css/index.css',
	];
    protected $menu = [
        [
            'title' => '内容管理',
            'uri'   => '',
            'icon'  => 'feather icon-grid',
        ],
        [
            'parent' => '内容管理', // 指定父级菜单
            'title' => '文章管理',
            'uri'   => 'articles',
            'icon'  => 'feather icon-file-minus',

        ],
        [
            'parent' => '内容管理', // 指定父级菜单
            'title' => '标签管理',
            'uri'   => 'tags',
            'icon'  => 'feather icon-flag',

        ],
    ];
	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

		//

	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
