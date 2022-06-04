<?php

namespace Ll\llcms\http\Controllers;

use Ll\llcms\Repositories\Article;
use Ll\llcms\Models\Tag;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Markdown;

class ArticleController extends AdminController
{
    protected $title = '文章管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Article::with('tags'), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');

//            $grid->disableFilter();
//            $grid->disableFilterButton();
            $grid->disableRefreshButton();
            $grid->filter(function ($filter) {
                $filter->panel();
//                $filter->expand(true);
                $filter->like('title');
                $filter->like('content');
                $filter->equal('tags.id', "标签")->select(Tag::all()->pluck('name', 'id'));
            });


            $grid->column('id')->sortable();
            $grid->column('title')->editable();

//            $grid->column('tags', '文章标签')->label();
            //实时查询标签
            $grid->column('tags', '标签')->display(function ($comments) {
//                $res = $this->tags()->get()->pluck('name')->toArray();
                $comments = $this->tags()->get()->pluck('name','id')->toArray();
                foreach ($comments as $id=>$name) {

                    $res[] = "<a href='?tags%5Bid%5D={$id}'><span class='label' style='background:#586cb1'>{$name}</span></a>";
                }

                return join(" ", $res);

                return $res;
            });

            $grid->column('show')->switch();
            $grid->column('created_at');
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
        return Show::make($id, new Article(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('tags', '文章标签');
            $show->field('content')->unescape()->as(function ($content) {
                return Card::make(
                    Markdown::make($content)
                );
            });;
//            $show->field('show')->switch();
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
        return Form::make(Article::with('tags'), function (Form $form) {
            $form->saving(function (Form $form) {
                if ($form->input('tags')){
                    $tags = implode(',', $form->input('tags'));
                    $form->repository()->model()->tags = $tags;
                }

            });

            $form->display('id');
            $form->text('title')->rules('required|min:1');


            $form->tags('tags', '文章标签')
                ->help('随意打上标签，输入后按空格创建，再按回车确定。')
                ->pluck('name', 'name')
                ->options(Tag::all())
                ->saving(function ($value) {
                    $ids = [];
                    foreach ($value as $tag) {
                        $tagModel = Tag::firstOrCreate(['name' => $tag]);
                        $id       = $tagModel->id;
                        $ids[]    = $id;
                    }
                    return $ids;
                });


            $form->markdown('content')->rules('required|min:1');;
            $form->switch('show')->default(1);

        });
    }
}
