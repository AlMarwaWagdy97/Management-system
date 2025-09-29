<?php

namespace App\Http\Controllers\Data;

use App\Models\Projects;
use App\Models\CharityProject;
use App\Models\CategoryProjects;
use App\Models\Data\DataProjects;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CharityProjectTranslation;
use App\Models\Data\ProjectCategoty;
use Stichoza\GoogleTranslate\GoogleTranslate;

class OldCategoryController extends Controller
{
    public function category()
    {
        DB::beginTransaction();
        try {

            $categories = ProjectCategoty::get();
            foreach ($categories as $category) {
                $data = [
                    "ar" => [
                        'title' => $category->name,
                        'slug' => $category->alias,
                        'description' => $category->description,
                    ],
                    "en" => [
                        'title' => GoogleTranslate::trans($category->name, "en"),
                        'slug' => GoogleTranslate::trans($category->alias, "en"),
                        'description' => GoogleTranslate::trans($category->description, "en"),
                    ],
                    "parent_id" => $category->parent_id,
                    "level" => $category->level,
                    "sort" => $category->arrangement,
                    "feature" => $category->featured,
                    "status" => $category->status,
                    "image" => "attachments/charity_category/" . $category->image,
                    "project_types" => $category->kafara == "app" ? "app" : "normal project",
                ];
                CategoryProjects::create($data);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return "All category is updated";
    }


    public function projects()
    {
        DB::beginTransaction();
        try {
            $projects = DataProjects::get();

            foreach ($projects as $project) {
                $data = [
                    "ar" => [
                        'title' => $project->name,
                        'slug' => $project->alias,
                        'description' => $project->description,
                    ],
                    "en" => [
                        'title' =>  $project->name != null ? GoogleTranslate::trans($project->name ?? "Project", "en") : "",
                        'slug' => @$project->alias,
                        // 'description' => $project->description != null ? GoogleTranslate::trans($project->description ?? "Project", "en") : "",
                        'description' => @$project->description,
                    ],
                    "category_id" => ($project->category_id),
                    "number" => $project->project_number,
                    "beneficiary" => $project->beneficiary,
                    "sort" => $project->arrangement,
                    "image" => $project->image,
                    "secondary_image" => $project->secondary_image,
                    "donation_type" => $project->donation_type,
                    "target_price" => $project->target_price,
                    "target_unit" => $project->target_unit,
                    "unit_price" => $project->unit_price,
                    "fake_target" => $project->fake_target,
                    "collected_target" => $project->collected_target,
                    "start_date" => date('Y/m/d H:i:s', $project->start_date),
                    "end_date" => date('Y/m/d H:i:s', $project->end_date),
                    "cover_image" => "attachments/Charity_Project/" . $project->cover_image,
                    "background_image" =>  "attachments/Charity_Project/" . @$project->secondary_image,
                    "images" => "attachments/Charity_Project/" . $project->images,
                    "project_types" => "normal project",
                    "location_type" => $project->kafara,
                    "status" => $project->status,
                    "featuer" => $project->featured,
                    "finished" => $project->finished ?? 0,
                    "background_color" => $project->background_color,

                ];
                $newProject = CharityProject::create($data);
                echo $newProject->id;
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return "All Project is updated";
    }


    public function projectImages()
    {
        DB::beginTransaction();
        try {
            $projects = DataProjects::get();
            foreach ($projects as $project) {
                $newProject = CharityProject::find($project->project_id);
                if ($newProject == null) {
                    continue;
                }
                $newProject->background_image = "attachments/Charity_Project/" . @$project->secondary_image;
                $newProject->save();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return "All Project is updated";
    }


    public function projectTypes()
    {
        try {
            $projects = DataProjects::get();
            foreach ($projects as $project) {
                if ($project->status == 2) {
                    continue;
                }
                $transProject = CharityProjectTranslation::with('project')->where('title', 'LIKE',  "%{$project->name}%")->get()->first();
                $newProject = CharityProject::find($transProject->project_id);

                if ($newProject == null) {
                    continue;
                }
                $oldDonation = json_decode($project->donation_type, true);
                // if(in_array($oldDonation['type'], ["share", "unit"]) ){
                //     $data = [];
                //     if(is_string( @$oldDonation['value'] )) continue;
                //     foreach(@$oldDonation['value'] ?? []  as $val){
                //         $data[] = [
                //             'name' => $val['name'],
                //             'value' => $val['value'],
                //         ];
                //     }
                //     $newdonation = [
                //         "type" => $oldDonation['type'],
                //         "data" => $data
                //     ];
                //     $newProject->donation_type = json_encode($newdonation);
                // }
                // if($oldDonation['type'] == "fixed") {

                //     $newdonation = [
                //         "type" => $oldDonation['type'],
                //         "data" => $oldDonation['value']
                //     ];
                //     $newProject->donation_type = json_encode($newdonation);
                // }
                $newProject->background_image = "attachments/Charity_Project/" . @$project->secondary_image;
                $newProject->save();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return "All Project is updated";
    }



    public function categoryProjectsImages()
    {
        DB::beginTransaction();
        try {
            $categories = CategoryProjects::get();
            foreach ($categories as $category) {
                $category->background_image = $category->image;
                $category->save();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return "All categories is updated";
    }

    public function projectCategoriesPivot()
    {
        DB::beginTransaction();
        try {
            $projects = CharityProject::get();
            foreach ($projects as $project) {
                $project->categories()->sync([$project->category_id]);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return "All categories is updated";
    }
}
