<?php

namespace App\Http\Livewire\Admin\Charity\Categories;

use App\Models\Ads;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CategoryProjects;
use App\Http\Controllers\TestViewController;

class Form extends Component
{
    use WithFileUploads;

    public $title = [], $slug = [], $description = [], $meta_title = [], $meta_description = [], $meta_key = [], $image, $parent_id = null,
        $kafara, $back_home, $status, $feature, $sort, $section_bg, $background_color, $background_image;
    public $imageExist, $background_imageExist, $level;
    public $ads = [];

    public $updateMode = false, $editMode, $showMode, $categoryID;
    // numeric

    protected $listeners = ['edit', 'getAdsData'];

    // create $ store  ------------------------------------------------------------------------------------------------------

    public function mount()
    {
        if ($this->editMode == true || $this->showMode == true)  $this->edit($this->categoryID);
    }
    public function render()
    {
        // dd($this->section_bg, $this->background_color, $this->description, $this->content);
        // if($this->editMode == true || $this->showMode == true)  $this->edit($this->categoryID);

        return view('livewire.admin.categories.create');
    }

    // create validate ------------------------------------------------------------------------------------------------------
    protected function rules()
    {
        return [
            'title.*'              => 'required',
            'slug.*'               => 'nullable',
            'description'        => 'nullable',
            'meta_title.*'         => 'nullable',
            'meta_description.*'   => 'nullable',
            'meta_key.*'           => 'nullable',
            'image'                => 'nullable|' . ImageValidate(),
            'parent_id'            => 'nullable',
            'kafara'               => 'nullable',
            'back_home'            => 'nullable',
            'status'               => 'nullable',
            'feature'              => 'nullable',
            'sort'                 => 'nullable',
            'section_bg'           => 'nullable',
            'background_color'     => 'nullable',
            'background_image'     => 'nullable|' . ImageValidate(),
            'ads'                  => 'nullable',
        ];
    }
    public function updated($field)
    {
        $this->validateOnly($field);
    }

    // update validate data  -------------------------------------------------------------------------------------------
    public function getSanitized()
    {
        $data = $this->validate();
        foreach (config('translatable.locales') as $locale) {
            $data[$locale]['title'] = $data['title'][$locale];
            $data[$locale]['slug'] = $data['slug'][$locale] ?? null;
            $data[$locale]['description'] = @$data['description'][$locale] ?? null;
            $data[$locale]['meta_title'] = @$data['meta_title'][$locale] ?? null;
            $data[$locale]['meta_description'] = @$data['meta_description'][$locale] ?? null;
            $data[$locale]['meta_key'] = @$data['meta_key'][$locale] ?? null;
        }
        unset($data['title']);
        unset($data['slug']);
        unset($data['description']);
        unset($data['meta_title']);
        unset($data['meta_description']);
        unset($data['meta_key']);

        $data['status'] = isset($data['status']) ? true : false;
        $data['feature'] = isset($data['feature']) ? true : false;
        $data['back_home'] = isset($data['back_home']) ? true : false;
        $data['level'] = updateLevel(@$data['parent_id']);
        $data['created_by']  = @auth()->user()->id;

        if ($data['image'] != null) {
            $data['image'] = upload_file($data['image'], ('categories'));
            $this->imageExist = $data['image'];
            $this->image = "";
        }
        if ($data['background_image'] != null) {
            $data['background_image'] = upload_file($data['background_image'], ('categories'));
            $this->background_imageExist = $data['background_image'];
            $this->background_image = "";
        }
        if ($data['parent_id'] == "") $data['parent_id'] = Null;
        return $data;
    }


    // create category ------------------------------------------------------------------------------------------------------
    public function storeCategory()
    {
        $data = $this->getSanitized();
        $category = CategoryProjects::create($data);
        if ($category != null) {
            $this->createAds($category, $data);
            session()->flash('success', trans('message.admin.created_sucessfully'));
            $this->clearForm();
            $this->dispatchBrowserEvent('storeCategory');
        }

        // $this->createAds($category, $data);
    }
    // create Ads  ------------------------------------------------------------------------------------------------------

    public function createAds($category, $data)
    {
        if ($data['ads'] != []) {
            foreach ($data['ads']['image'] as $key => $ads) {
                if ($ads != null) {
                    $ads = upload_file($ads, ('ads'));
                }
                Ads::create([
                    'model_id' => $category->id,
                    'model'    => CategoryProjects::class,
                    'image'    => @$ads,
                    'link'     => @$data['ads']['link'][$key],
                ]);
            }
        }
    }

    // Actions generate Slug  -----------------------------------------------------------------------------------------
    public function generateSlug($locale)
    {
        $this->slug[$locale] = slug(@$this->title[$locale]);
    }

    // clear function --------------------------------------------------------------------------------------------------
    public function clearForm()
    {
        $this->title = [];
        $this->slug = [];
        $this->description = [];
        $this->parent_id = Null;
        $this->level = Null;
        $this->sort = 0;
        $this->back_home = Null;
        $this->feature = Null;
        $this->status = Null;
        $this->kafara = Null;
        $this->image = "";
        $this->background_image = Null;
        $this->background_color = "";
        $this->section_bg = "";
        $this->meta_title = [];
        $this->meta_description = [];
        $this->meta_key = [];
        $this->ads = [];
        $this->imageExist = [];
        $this->background_imageExist = [];
    }
    // End create $ store  ---------------------------------------------------------------------------------------------





    // Edit  ------------------------------------------------------------------------------------------------------
    public function edit($id)
    {

        $category = CategoryProjects::find($id);
        foreach (config('translatable.locales') as $locale) {
            $this->title[$locale] = $category->translate($locale)->title;
            $this->slug[$locale] = $category->translate($locale)->slug;
            $this->description[$locale] = $category->translate($locale)->description;
            $this->meta_title[$locale] = $category->translate($locale)->meta_title;
            $this->meta_key[$locale] = $category->translate($locale)->meta_key;
            $this->meta_description[$locale] = $category->translate($locale)->meta_description;
        }
        // $this->title = @$category->getTranslations('title');
        // $this->slug = @$category->getTranslations('slug');
        // $this->description = @$category->getTranslations('description');
        $this->parent_id = $category->parent_id;
        $this->level = @$category->level;
        $this->sort = @$category->sort;
        $this->back_home = @$category->back_home;
        $this->feature = @$category->feature;
        $this->status = @$category->status;
        $this->kafara = @$category->kafara;
        $this->imageExist = @$category->image;
        $this->background_imageExist = @$category->background_image;
        $this->background_color = @$category->background_color;
        $this->section_bg = @$category->section_bg;
        // $this->meta_title = @$category->getTranslations('meta_title');
        // $this->meta_description = @$category->getTranslations('meta_description');
        // $this->meta_key = @$category->getTranslations('meta_key');
        $this->ads = @$category->ads;


        $categories = CategoryProjects::query()->get();
        $this->ads = $category->ads;
    }

    public function updateCategory($id)
    {
        $data = $this->getSanitized();
        $category = CategoryProjects::find($id);
        $category->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
    }
    // End Edit  --------------------------------------------------------------------------------------------------


}
