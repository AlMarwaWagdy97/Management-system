<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CharityProject;
use App\Models\SettingsValues;
use Hamcrest\Arrays\IsArray;

class SettingsController extends Controller
{
    public function index()
    {
        $items = Settings::active()->orderBy('sort', 'ASC')->get();
        return view('admin.dashboard.cms.settings.index', compact('items'));
    }

    public function form($key)
    {
        $settingMain = Settings::query()->where('key', $key)->get()->first();

        if ($settingMain == null) {
            return abort(404);
        }

        $settings = $settingMain->values;

        switch ($key) {
            case 'general':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.general', compact('settings', 'settingMain'));

            case 'contact_information':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.contact_information', compact('settings', 'settingMain'));

            case 'color':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.colors', compact('settings', 'settingMain'));

            case 'external_connection':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.external_connection', compact('settings', 'settingMain'));

            case 'gift':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.gifts', compact('settings', 'settingMain'));

            case 'product':
                $settings = $settings->pluck('value', 'key');
                $projects = CharityProject::with('trans')->active()->get();
                return view('admin.dashboard.cms.settings.partials.products', compact('settings', 'settingMain', 'projects'));

            case 'custom_campaign':
                $settings = $settings->pluck('value', 'key');
                $projects = CharityProject::with('trans')->active()->get();
                return view('admin.dashboard.cms.settings.partials.custom-campaign', compact('settings', 'settingMain', 'projects'));

            case 'notifications':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.notifications', compact('settings', 'settingMain'));

            case 'meta':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.meta', compact('settings', 'settingMain'));

            case 'volunteering':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.volunteering', compact('settings', 'settingMain'));

            case 'badal':
                $settings = $settings->pluck('value', 'key');
                $projects = CharityProject::with('trans')->active()->get();
                return view('admin.dashboard.cms.settings.partials.badal', compact('settings', 'settingMain', 'projects'));

            case 'badalnotfication':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.badalnotification', compact('settings', 'settingMain'));
            case 'pixel':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.pixel', compact('settings', 'settingMain'));
            default:
                return view('admin.dashboard.cms.settings.form', compact('settings', 'settingMain'));
        }
    }

    public function form_update(Request $request, $id)
    {
        @$settings = Settings::findOrfail($id)->values;
        foreach ($request->except(['_token']) as $key => $item) {
            $settings = $settings->where('key', $key)->first();
            if ($request->hasFile($key)) {
                $filename = $this->upload_file($request->file($key), ('settings'), $key);
                $settings->where('key', $key)->update(['value' => $filename]);
            } else {
                $settings->where('key', $key)->update(['value' => $item]);
            }
        }
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }

   public function form_update_custom(Request $request, $key)
{
    // return $request->all();
    $settingMain = Settings::query()->where('key', $key)->first();

    $request->replace(array_map(function ($value) {
        return $value === 'on' ? 1 : $value;
    }, $request->all()));

    $coordinateFields = ['sender_x', 'sender_y', 'recipient_x', 'recipient_y'];
    foreach ($coordinateFields as $field) {
        if ($request->filled($field)) {
            SettingsValues::updateOrCreate(
                ['setting_id' => $settingMain->id, 'key' => $field],
                ['value'      => $request->input($field)]
            );
        }
    }

    $otherValues = $request->except(array_merge(['_token'], $coordinateFields));

    // custom request - handle color settings
    if ($request->type_setting == "color") {
        // Check if categoryColorlist exists and has valid data
        if (
            count($request->categoryColorlist ?? []) == 1 &&
            isset($request->categoryColorlist[0]) &&
            (!isset($request->categoryColorlist[0]['cat_title']) ||
                $request->categoryColorlist[0]['cat_title'] == null)
        ) {
            $request->request->remove('categoryColorlist');
        }

        $dataColor = array_merge($request->old_category ?? [], $request->categoryColorlist ?? []);
        $categories = [];

        foreach ($dataColor as $item) {
            // Check if the item is an array and has required fields
            if (is_array($item) && (isset($item['cat_title']) || isset($item['cat_number']) || isset($item['cat_item']))) {
                $categories[] = [
                    'cat_title' => $item['cat_title'] ?? '',
                    'cat_number' => $item['cat_number'] ?? '',
                    'cat_item' => $item['cat_item'] ?? ''
                ];
            }
        }

        $request->request->remove('old_category');
        $request->request->remove('type_setting');
        $request->request->add(['categoryColorlist' => $categories]);
    }

    // check status
    $request->request->add(['status' => isset($request->status) ? 1 : 0]);

    // store key in setting
    if ($settingMain == null) {
        $settingMain = Settings::create(['key' => $key]);
    }
    $settings = $settingMain->values;
    
    // store values in setting
    $values = $request->except('_token');
    if ($values) {
        foreach ($values as $key => $value) {
            
            if ($key == 'gift_category') {
                foreach ($value as $gkey => $gift) {
                    if (@$gift['newimages'] && is_array(request()->all()['gift_category'][$gkey]['newimages'])) {
                        $imagesArray = [];
                        $bool = false;
                        foreach (request()->all()['gift_category'][$gkey]['newimages'] as $keyM2 => $multiarray) {
                            if (!is_string($multiarray) && $multiarray) {
                                $imagesArray[] = $this->upload_file($multiarray, 'settings', $keyM2);
                                $bool = true;
                            }
                        }
                        if ($bool) {
                            $value[$gkey]['images'] = json_encode($imagesArray, JSON_UNESCAPED_UNICODE);
                        }
                    }
                }
            }
            else if ($key == 'new_category') {
                $validatedOld = $request->input('old_category', []);
                $validatedNew = $request->input('new_category', []);
                $merged = [];

                $count = count($validatedOld['cat_title_ar'] ?? []);
                for ($i = 0; $i < $count; $i++) {
                    if ($validatedOld['cat_title_ar'][$i]) {
                        $merged[] = [
                            'cat_title_ar' => $validatedOld['cat_title_ar'][$i] ?? '',
                            'cat_title_en' => $validatedOld['cat_title_en'][$i] ?? '',
                            'cat_number'   => $validatedOld['cat_number'][$i] ?? '',
                            'cat_item'     => $validatedOld['cat_item'][$i] ?? '',
                        ];
                    }
                }
                $newCount = count($validatedNew['cat_title_ar'] ?? []);
                for ($i = 0; $i < $newCount; $i++) {
                    if ($validatedNew['cat_title_ar'][$i]) {
                        $merged[] = [
                            'cat_title_ar' => $validatedNew['cat_title_ar'][$i] ?? '',
                            'cat_title_en' => $validatedNew['cat_title_en'][$i] ?? '',
                            'cat_number'   => $validatedNew['cat_number'][$i] ?? '',
                            'cat_item'     => $validatedNew['cat_item'][$i] ?? '',
                        ];
                    }
                }

                $key   = "cats_statistics";
                $value = $merged;
            }

            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            }

            if ($request->hasFile($key)) {
                $value = $this->upload_file($request->file($key), 'settings', $key);
            }

            $set = $settings->where('key', $key)->first();
            if ($set == null) {
                SettingsValues::create([
                    'key'        => $key,
                    'value'      => $value,
                    'setting_id' => $settingMain->id
                ]);
            } else {
                $set->value = $value;
                $set->save();
            }
        }
    }

    session()->flash('success', trans('message.admin.updated_sucessfully'));
    return redirect()->back();
}


    public function volunteerUpdate(Request $request, $key)
    {
        $settingMain = Settings::query()->where('key', $key)->get()->first();
        $request->request->add(['status' => isset($request->status) ? 1 : 0]);

        $data = $request->except('_token');
        if (isset($data['achievements'])) {
            foreach ($data['achievements'] as $ind => $achievement) {
                if (isset($achievement['image']) && file_exists($achievement['image']) && getimagesize($achievement['image'])) {
                    $data['achievements'][$ind]['image'] = $this->upload_file($achievement['image'], ('settings'), $ind);
                }
            }
            $data['achievements'] = json_encode($data['achievements']);
        }

        if ($settingMain == null) {
            $settingMain = Settings::create(['key' => $key]);
        }
        $settings = $settingMain->values;

        if ($data) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $value = json_encode($value);
                }
                if ($request->hasFile($key)) {
                    $value = $this->upload_file($request->file($key), ('settings'), $key);
                }
                $set = $settings->where('key', $key)->first();
                if ($set == null) {
                    SettingsValues::create(['key' => $key, 'value' => $value, 'setting_id' => $settingMain->id]);
                } else {
                    $set->value = $value;
                    $set->save();
                }
            }
        }
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }

    /**
     * Delete an image from settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'key' => 'required|string|in:footer_logo,commercial_license',
        ]);

        try {
            $setting = Settings::where('key', 'general')->firstOrFail();
            $settingValue = $setting->values()->where('key', $request->key)->firstOrFail();
            
            // Delete the image file if it exists
            if ($settingValue->value && file_exists(public_path($settingValue->value))) {
                unlink(public_path($settingValue->value));
            }
            
            // Update the setting value to empty
            $settingValue->update(['value' => null]);
            
            return response()->json([
                'success' => true,
                'message' => trans('admin.image_deleted_successfully')
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error deleting image: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => trans('admin.error_deleting_image')
            ], 500);
        }
    }
}