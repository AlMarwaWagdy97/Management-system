<?php

namespace App\Http\Livewire\Admin\Cms\Categories;

use App\Models\Ads;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Http\Controllers\TestViewController;
use App\Models\Categories;
use Locale;

class Form extends Component
{
    use WithFileUploads;

    public $title = [], $slug = [], $description = [], $meta_title = [], $meta_description = [], $meta_key = [], $image, $parent_id = null,
          $status, $feature, $sort;

    public $imageExist;
    
    public $updateMode = false, $editMode, $showMode, $categoryID;
    // numeric

    protected $listeners = ['edit', 'getAdsData'];
    
    // create $ store  ------------------------------------------------------------------------------------------------------

    public function mount(){
        if($this->editMode == true || $this->showMode == true)  $this->edit($this->categoryID);
    }
    public function render()
    {
        // dd($this->section_bg, $this->background_color, $this->description, $this->content);
        // if($this->editMode == true || $this->showMode == true)  $this->edit($this->categoryID);
       
        return view('livewire.cms.admin.categories.create');
    }

    // create validate ------------------------------------------------------------------------------------------------------
    public function messages ()
    {
        $attr = [];
        foreach (config('translatable.locales') as $locale) {
            $attr += ['title.' . $locale  => 'Title ' . Locale::getDisplayName($locale) . trans('message.admin.required')];
            $attr += ['slug.' . $locale  => 'Slug '. Locale::getDisplayName($locale) . trans('message.admin.required')];
            $attr += ['description.' . $locale  => 'Description '. Locale::getDisplayName($locale) . trans('message.admin.required')];
            $attr += ['meta_title.' . $locale  => 'Meta title '. Locale::getDisplayName($locale) . trans('message.admin.required')];
            $attr += ['meta_description.' . $locale  => 'Meta description '. Locale::getDisplayName($locale) . trans('message.admin.required')];
            $attr += ['meta_key.' . $locale  => 'Meta key '. Locale::getDisplayName($locale) . trans('message.admin.required')];
        }
        $attr += ['image' =>'Image' . trans('message.admin.required')];
        $attr += ['sort' =>'Sort' . trans('message.admin.required')];
        $attr += ['feature' =>'Fearure' . trans('message.admin.required')];
        $attr += ['status' =>'Status' . trans('message.admin.required')];
        $attr += ['parent_id' =>'Parent' . trans('message.admin.required')];
        return $attr;
    }

    // public $validationAttributes  = $this->attributes();

    protected function rules() {
        $req = [];
        foreach(config('translatable.locales') as $locale){
            $req += ['title.' .$locale => 'required'];
            $req += ['slug.' .$locale => 'nullable'];
            $req += ['description.' .$locale => 'nullable'];
            $req += ['meta_title.' .$locale => 'nullable'];
            $req += ['meta_description.' .$locale => 'nullable'];
            $req += ['meta_key.' .$locale => 'nullable'];
        }
        $req += ['image' =>'nullable|' . ImageValidate()];
        $req += ['status' =>'nullable'];
        $req += ['sort' =>'nullable'];
        $req += ['feature' =>'nullable'];
        $req += ['parent_id' =>'nullable'];

        return $req;
    }
    
    public function updated($field){
        $this->validateOnly($field);
    }

    // update validate data  -------------------------------------------------------------------------------------------
    public function getSanitized(){
        $data = $this->validate();
        foreach(config('translatable.locales') as $locale){
            $data[$locale]['title'] = $data['title'][$locale];
            $data[$locale]['slug'] = $data['slug'][$locale] ?? null;
            $data[$locale]['description'] = @$data['description'][$locale] ?? null;
            $data[$locale]['meta_title'] = @$data['meta_title'][$locale] ?? null;
            $data[$locale]['meta_description'] = @$data['meta_description'][$locale]?? null;
            $data[$locale]['meta_key'] = @$data['meta_key'][$locale] ?? null;
        }
        unset($data['title']);  unset($data['slug']); unset($data['description']);
        unset($data['meta_title']); unset($data['meta_description']); unset($data['meta_key']);

        $data['status'] = isset($data['status']) ? true : false;
        $data['feature'] = isset($data['feature']) ? true : false;
        $data['level'] = updateLevel(@$data['parent_id']);
        $data['created_by']  = @auth()->user()->id;

        if($data['image'] != null){
            $data['image'] = upload_file( $data['image'] , ('categories'));
            $this->imageExist = $data['image'];
            $this->image = "";
        }
     
        if($data['parent_id'] == "")$data['parent_id'] = Null;
        return $data;
    }


       // create category ------------------------------------------------------------------------------------------------------
    public function storeCategory(){
        $data = $this->getSanitized();
        $category = Categories::create($data);
        if($category != null){
            session()->flash('success' , trans('message.admin.created_sucessfully') );
            $this->clearForm();
            $this->dispatchBrowserEvent('storeCategory');
        }
      
    }
    // create Ads  ------------------------------------------------------------------------------------------------------


    // Actions generate Slug  -----------------------------------------------------------------------------------------
    public function generateSlug($locale){
        $this->slug[$locale] = slug( @$this->title[$locale]);
    }

    // clear function --------------------------------------------------------------------------------------------------
    public function clearForm(){
        $this->title = [];
        $this->slug = [];
        $this->description = [];
        $this->parent_id = Null;
        $this->level = Null;
        $this->sort = 0;
        $this->feature = Null;
        $this->status = Null;
        $this->image = "";
        $this->meta_title = [];
        $this->meta_description = [];
        $this->meta_key = []; 
        $this->imageExist = [];
    }
    // End create $ store  ---------------------------------------------------------------------------------------------





    // Edit  ------------------------------------------------------------------------------------------------------
    public function edit($id){

        $category = Categories::find($id);
        foreach(config('translatable.locales') as $locale){
            $this->title[$locale] = $category->translate($locale)->title;
            $this->slug[$locale] = $category->translate($locale)->slug;
            $this->description[$locale] = $category->translate($locale)->description;
            $this->meta_title[$locale] = $category->translate($locale)->meta_title;
            $this->meta_key[$locale] = $category->translate($locale)->meta_key;
            $this->meta_description[$locale] = $category->translate($locale)->meta_description;
        }
        $this->parent_id = $category->parent_id;
        $this->level = @$category->level;
        $this->sort = @$category->sort;
        $this->feature = @$category->feature;
        $this->status = @$category->status;
        $this->imageExist = @$category->image;
    }

    public function updateCategory($id){
        $data = $this->getSanitized();
        $category = Categories::find($id);
        $category->update($data);
        session()->flash('success' , trans('message.admin.updated_sucessfully') );
    }
    // End Edit  --------------------------------------------------------------------------------------------------

    
}

