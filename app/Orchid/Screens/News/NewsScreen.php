<?php

namespace App\Orchid\Screens\News;

use App\Models\News\Category;
use App\Models\News\News;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;

class NewsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Новости';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'news' => News::paginate()
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        if (Category::all()->count()) {

            return [
                Link::make('Новая ')
                    ->icon('pencil')
                    ->route('platform.news.edit')
            ];
        } else {
            Alert::info('Нет не одной категории. Сначала создайте.');
            return [];
        }
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::table('news', [
                TD::make('subject')
                    ->render(function (News $news) {
                        return Link::make($news->subject)
                            ->route('platform.news.edit', $news);
                    }),
                TD::make('slug'),
            ])
        ];
    }
}
