<?php

namespace Ll\llcms\Actions\Menu;

use Dcat\Admin\Tree\RowAction;

class Show extends RowAction
{
    public function handle()
    {
        $key = $this->getKey();
        $menuModel = \Ll\llcms\Models\Category::class;
        $menu = $menuModel::find($key);

        $menu->update(['show' => $menu->show ? 0 : 1]);

        return $this
            ->response()
            ->success(trans('admin.update_succeeded'))
            ->location('category');
    }

    public function title()
    {
        $icon = $this->getRow()->show ? 'icon-eye-off' : 'icon-eye';

        return "&nbsp;<i class='feather $icon'></i>&nbsp;";
    }
}
