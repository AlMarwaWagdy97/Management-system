<?php

namespace App\Http\Livewire\Files;

use App\Models\FileUpload;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;

class UploadModal extends Component
{
    use WithFileUploads;

    public $class;
    public $style;
    public $linked_model;
    public $linked_model_id;
    public $msg;

    public $rules = [
        'files.*' => 'required|file|mimes:jpeg,png,pdf,doc,docx,xls,xlsx|max:5000', // Adjust mimes and max size as needed
    ];

    public $messages = [
        'files.*.required' => 'A file is required.',
        'files.*.file' => 'Invalid file type.',
        'files.*.mimes' => 'The file must be a JPEG, PNG, or PDF.',
        'files.*.max' => 'The file must be less than 2MB.',
    ];

    public $filename;
    public $description;
    public $files;
    public $show = false;
    public $show_details = false;
    public $types = ['png', 'jpg', 'jpeg', 'gif'];


    public function mount($model = null, $model_id = null)
    {
        $this->linked_model = $model;
        $this->linked_model_id = $model_id;
    }


    /**
     * uploading file
     *
     * @return void
     */
    function submit()
    {
        // to keep modal open
        $this->updatedFile();
        $this->validateOnly('files'); // Validate only the files on change

        $validator = Validator::make(['files' => $this->files], $this->rules, $this->messages);

        if ($validator->fails()) {
            $this->setErrorBag($validator->errors());
            return; // Stop execution if validation fails
        }
        try {
            foreach ($this->files as $index => $file) {
                $file->store('public/attachments/' . $this->linked_model);
                FileUpload::create([
                    "filename" => $this->filename . "_$index",
                    "path" =>  $file->hashName(),
                    "mime_type" => $file->extension(),
                    "size" => $file->getSize(),
                    "description" => $this->description,
                    "linked_model" => $this->linked_model,
                    "linked_model_id" => $this->linked_model_id,
                ]);
            }
        } catch (\Throwable $th) {
            return $this->msg = __('Error occurred, Please try again.');
        }
        unset($this->filename, $this->files, $this->description,);
        return $this->msg = __('Added Successfully');
    }

    function delete($id)
    {
        FileUpload::where(['id' => $id, "linked_model" => $this->linked_model, "linked_model_id" => $this->linked_model_id,])->delete();
        return $this->msg = __('Deleted Successfully');
    }

    function toggleModal()
    {
        $this->show_details = !$this->show_details;
    }
    public function keyUp()
    {
        $this->show_details = false;
    }


    /**
     * change status of file
     *
     * @param FileUpload $id
     * @return void
     */
    public function change_status(FileUpload $id)
    {
        $id->status = $id->update(['status' => !$id->status]);
    }
    //on file update show modal
    function updatedFile()
    {
        $this->class = "show";
        $this->style = "display: block;";
    }
    function showing()
    {
        $this->show = !$this->show;
    }
    
    public function render()
    {
        $this->uploads = ($this->show_details) ? FileUpload::where(['linked_model' => $this->linked_model, 'linked_model_id' => $this->linked_model_id])->get() : [];


        return view('livewire.files.upload-modal');
    }
}
