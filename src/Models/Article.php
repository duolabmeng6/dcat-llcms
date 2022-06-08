<?php

namespace Ll\llcms\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'cms_articles';
    use HasFactory;
    use HasDateTimeFormatter;
    use SoftDeletes;
    protected $fillable = [
        'title', 'content', 'show',
    ];
    public function tags()
    {
        return $this->belongsToMany(Tag::class,'cms_article_tag')->withTimestamps();
    }

}
