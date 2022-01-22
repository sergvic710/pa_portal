<?php

namespace App\Orchid\Screens\News;

use App\Models\News\Category;
use App\Models\News\News;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Illuminate\Http\Request;

class NewsEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Новая';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(News $news): array
    {
        $this->exists = $news->exists;
        if ($this->exists) {
            $this->name = 'Редактировать новость';
        }

        return [
            'news' => $news
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
            Button::make('Записать')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),
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
            Layout::rows([
                Select::make('news.category_id')
                    ->title('Категория')
                    ->required()
                    ->fromModel(Category::class, 'name'),
                Input::make('news.slug')
                    ->title('Slug')
                    ->placeholder('Введите slug'),
                Input::make('news.subject')
                    ->title('Тема')
                    ->required()
                    ->placeholder('Введите тему новости'),
                Picture::make('news.preview_picture')
                    ->title('Картинка анонса'),
                SimpleMDE::make('news.preview_text')
                    ->title('Текст анонса'),
                Picture::make('news.detail_picture')
                    ->title('Детальная картинка'),
                SimpleMDE::make('news.detail_text')
                    ->title('Детальный текст'),
//                    ->help('Название категории'),
//                Input::make('category.slug')
//                    ->title('Slug')
//                    ->placeholder('Введите slug')
//                    ->help('Введите ыдгп или оставте поле пустым, тогда slug будет создан автоматически.'),
            ])
        ];
    }

    public function createOrUpdate(News $news, Request $request) {
        $req = $request->get('news');
        if( !$req['slug']) {
            $req['slug'] = Str::slug($req['subject'],'-');
        }
//        if( $category->id ) {
//            Alert::info('Категория успешно изменена');
//        } else {
//            Alert::info('Категория успешно добавлена');
//        }
        $news->fill($req)->save();


        return redirect()->route('platform.news');

//        Category::create($request->all());
//        $catModel = new Category();
//        $catModel->name = $name;
//        $catModel->slug = $slug;
//
//        $catModel->save();
    }
    /**
     * @param Category $category
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(News $news)
    {
        $news->delete();

        Alert::info('Вы успешно удалили запись.');

        return redirect()->route('platform.news');
    }
}
