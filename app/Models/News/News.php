<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class News extends Model
{
    use HasFactory;
    use AsSource;

    protected $fillable = [
        'category_id','subject','slug','preview_text','detail_text',
        'preview_picture','detail_picture'
    ];
}
