<?php

namespace App\Orchid\Screens\News;

use App\Models\News\Category;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Support\Facades\Layout;

class CategoryNewsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Категории';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'category' => Category::paginate()
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Новая категория')
                ->icon('pencil')
                ->route('platform.news.category.edit')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::table('category', [
                TD::make('name')
                    ->render(function (Category $category) {
                        return Link::make($category->name)
                            ->route('platform.news.category.edit', $category);
                    }),
                TD::make('slug'),
            ])
        ];
    }
}
