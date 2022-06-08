<?php

namespace Ll\llcms\Http\Controllers;

use Ll\llcms\Repositories\Category;
use Dcat\Admin\Form;
use Ll\llcms\Actions\Menu\Show;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Tree;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form as WidgetForm;
use Dcat\Admin\Http\Controllers\AdminController;

class CategoryController extends AdminController
{
    public function title()
    {
        return '文章分类';
    }

    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description('列表')
            ->body(function (Row $row) {
                $row->column(7, $this->treeView()->render());

                $row->column(5, function (Column $column) {
                    $form = new WidgetForm();
                    $form->action(admin_url('cms-category'));

                    $menuModel = \Ll\llcms\Models\Category::class;

                    $form->select('parent_id', trans('admin.parent_id'))->options($menuModel::selectOptions());
                    $form->text('title', trans('admin.title'))->required();
                    $form->icon('icon', trans('admin.icon'))->help($this->iconHelp());
                    $form->text('uri', trans('admin.uri'));

                    $form->width(9, 2);

                    $column->append(Box::make(trans('admin.new'), $form));
                });
            });
    }

    /**
     * @return \Dcat\Admin\Tree
     */
    protected function treeView()
    {
        $menuModel = \Ll\llcms\Models\Category::class;

        return new Tree(new $menuModel(), function (Tree $tree) {
            $tree->disableCreateButton();
            $tree->disableQuickCreateButton();
            $tree->disableEditButton();
            $tree->maxDepth(3);

            $tree->actions(function (Tree\Actions $actions) {
                if ($actions->getRow()->extension) {
                    $actions->disableDelete();
                }

                $actions->prepend(new Show());
            });

            $tree->branch(function ($branch) {
                $payload = "<i class='fa {$branch['icon']}'></i>&nbsp;<strong>{$branch['title']}</strong> id:{$branch['id']}";

                if (! isset($branch['children'])) {
//                    if (url()->isValidUrl($branch['uri'])) {
//                        $uri = $branch['uri'];
//                    } else {
//                        $uri = admin_base_path($branch['uri']);
//                    }
                    $uri = $branch['uri'];

                    $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"$uri\" class=\"dd-nodrag\">$uri</a>";
                }

                return $payload;
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $menuModel = \Ll\llcms\Models\Category::class;
        return Form::make(Category::with(), function (Form $form) use ($menuModel) {
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
            });

            $form->display('id', 'ID');

            $form->select('parent_id', trans('admin.parent_id'))->options(function () use ($menuModel) {
                return $menuModel::selectOptions();
            })->saving(function ($v) {
                return (int) $v;
            });
            $form->text('title', trans('admin.title'))->required();
            $form->icon('icon', trans('admin.icon'))->help($this->iconHelp());
            $form->text('uri', trans('admin.uri'));
            $form->switch('show', trans('admin.show'));
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        })->saved(function (Form $form, $result) {
            $response = $form->response()->location('cms-category');

            if ($result) {
                return $response->success(__('admin.save_succeeded'));
            }

            return $response->info(__('admin.nothing_updated'));
        });
    }

    /**
     * Help message for icon field.
     *
     * @return string
     */
    protected function iconHelp()
    {
        return 'For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>';
    }
}
