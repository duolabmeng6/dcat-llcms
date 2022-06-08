<?php

namespace Ll\llcms\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ll\llcms\Models\Article;

class Tag extends Model
{
    protected $table = 'cms_tags';

    use HasFactory;
    use HasDateTimeFormatter;
    protected $fillable = ['name'];

    public function articles()
    {
        return $this->belongsToMany(Article::class,'cms_article_tag')->withTimestamps();
    }
}
