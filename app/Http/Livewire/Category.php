<?php

namespace App\Http\Livewire;

use App\Models\Categorie;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $title, $description = '', $category_parent = 0, $perPage = 5, $query,$selectedId, $action='store';

    public function store() {

        $this->validate([

            'title'=> 'required|string|unique:categories,title',
            'description'=> 'string',
            'category_parent'=> 'numeric|nullable',

        ]);

        $category = new Categorie();
        $category->title=$this->title;
        $category->description=$this->description;
        $category->slug=Str::slug($this->title);
        $this->category_parent !== 0 ? $category->category_parent=$this->category_parent : '';

        if($category->save()){
            session()-> flash('success',"categorie ajouter avec succes ");
            $this->reset();
        }else{
            session()->flash('error','une erreur est survenu lors de creation.');
        }

    }

    public function edit($id)
    {
        $category=Categorie::find($id);
        if ($category) {
            $this->title=$category->title;
            $this->description=$category->description;
            $this->category_parent=$category->category_parent;

            $this->action="update($id)";
        }
    }

    public function update($id) {

        $this->validate([

            'title'=> 'required|string|unique:categories,title,'.$id,
            'description'=> 'string',
            'category_parent'=> 'numeric|nullable',

        ]);

        $category = Categorie::find($id);
        $category->title=$this->title;
        $category->description=$this->description;
        $category->slug=Str::slug($this->title);
        $category->category_parent=$this->category_parent;

        if($category->update()){
            session()-> flash('success',"categorie modifier avec succes ");
            $this->reset();
            $this->action='store';
        }else{
            session()->flash('error','une erreur est survenu lors de creation.');
        }

    }

    public function delete($id)
    {
        $category = Categorie::find($id);
        if ($category) {
            $category->delete();
            session()-> flash('success',"categorie suppprimer avec succes ");
        }
    }
        public function selectId($id)
        {
            $this-> selectedId=$id;
        }

    public function allCategories()
    {
        $columns = Schema::getColumnListing('categories');
        $categoryQuery = Categorie::query();
        foreach ($columns as $column) {
            $categoryQuery->orWhere($column, 'LIKE', '%'.$this->query.'%')->orderByDesc('id');
        }

        $result = $categoryQuery->paginate($this->perPage);

        return $result;
    }


    public function render()
    {
        return view('admin.livewire.category.index', [
            'categories' => $this->allCategories(),
            'all_categories' => Categorie::orderBy('title')->get(),
        ]);
    }
}
