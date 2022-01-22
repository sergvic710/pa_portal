<?php

namespace App\Orchid\Screens\News;

use App\Models\News\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Illuminate\Http\Request;

class CategoryNewsEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Новая категория';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Category $category): array
    {
        $this->exists = $category->exists;
        if($this->exists){
            $this->name = 'Редактировать категорию';
        }

        return [
            'category' => $category
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
            Button::make('Create post')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Remove')
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
                Input::make('category.name')
                    ->title('Название')
                    ->required()
                    ->placeholder('Введите название категории')
                    ->help('Название категории'),
                Input::make('category.slug')
                    ->title('Slug')
                    ->placeholder('Введите slug')
                    ->help('Введите ыдгп или оставте поле пустым, тогда slug будет создан автоматически.'),
            ])
        ];
    }

    public function createOrUpdate(Category $category, Request $request) {
        $req = $request->get('category');
        if( $req['slug'] == '') {
            $req['slug'] = Str::slug($req['name'],'-');
        }
        if( $category->id ) {
            Alert::info('Категория успешно изменена');
        } else {
            Alert::info('Категория успешно добавлена');
        }
        $category->fill($req)->save();


        return redirect()->route('platform.news.category');
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
    public function remove(Category $category)
    {
        $category->delete();

        Alert::info('Вы успешно удалили категорию.');

        return redirect()->route('platform.news.category');
    }
}
