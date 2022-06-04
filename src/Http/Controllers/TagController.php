<?php

namespace Ll\llcms\http\Controllers;

use Ll\llcms\Repositories\Tag;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class TagController extends AdminController
{
    protected $title = '标签管理';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Tag::with('articles'), function (Grid $grid) {

            $grid->disableRefreshButton();

            $grid->filter(function ($filter) {
                $filter->panel();
                $filter->like('name');
            });


            $grid->column('id')->sortable();
            $grid->column('name')->editable();
            $grid->column('文章数量')->display(function ($comments) {
                $count = $this->articles()->count();
                return $count;
            });

//            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Tag(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Tag(), function (Form $form) {
            $form->display('id');
            $form->text('name');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
