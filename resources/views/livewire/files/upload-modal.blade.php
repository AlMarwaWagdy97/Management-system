<div wire:keydown.escape="keyUp()" class="d-inline">

    <span type="span" class="btn btn-primary waves-effect waves-light btn-sm w-100" role="button" data-bs-toggle="modal" wire:click="toggleModal()" data-bs-target="#upload{{ $linked_model_id }}">
        <i class='mx-1 bx-xs bx bx-upload'></i>
        @lang('admin.choose')
    </span>

    @if ($show_details)
        <div class="modal fade show" id="upload{{ $linked_model_id }}" tabindex="-1" role="dialog" aria-modal="true" style="display: block;">
            <div class="modal-dialog modal-xl pt-5" role="document">
                <div class="modal-content mt-5 shadow">
                    <div class="modal-header py-1">
                        <h5 class="modal-title py-0" id="modalTitleId">
                            @lang('Files')
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="toggleModal()" autofocus></button>
                    </div>

                    <div class="modal-body">
                        <div class="position-absolute top-50 start-50" wire:loading>
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        @if ($msg)
                            <div class="alert alert-info" role="alert">{{ $msg }}</div>
                        @endif

                        <div class="container-fluid">
                            <form action="">
                                <div class="row mb-3">
                                    <label for="file_name" class="col-sm-3 col-form-label">@lang('File name')</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-text'></i></span>
                                            <input type="text" class="form-control" wire:model="filename" placeholder="@lang('File name')">
                                        </div>
                                        @error('filename')
                                            <div class="text-danger border border-danger rounded-lg position-sticky p-2 zindex-sticky"><small>{{ $message }}</small></div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="discription" class="col-sm-3 col-form-label">@lang('Discription')</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-text'></i></span>
                                            <input type="text" class="form-control" wire:model="description" placeholder="@lang('Discription')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="upload">@lang('File')</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx-upload bx'></i></span>
                                            <input type="file" class="form-control" wire:model="files" multiple name="files" id="">
                                        </div>
                                        @error('files.*')
                                            <div class="text-danger border border-danger rounded-lg position-sticky p-2 zindex-sticky"><small>{{ $message }}</small></div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button wire:click="submit({{ $linked_model_id }})"  type="button" class="btn btn-success btn-sm">Save</button>
                                </div>
                            </form>
                            <div class="table-responsive-sm">
                                <h5 class="">@lang('Uploaded Files')</h5>
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>@lang('Filename')</th>
                                            <th>@lang('Type')</th>
                                            <th>@lang('Description')</th>
                                            <th>@lang('Date')</th>
                                            {{-- <th>@lang('Status')</th> --}}
                                            <th>@lang('Delete')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($uploads as $item)
                                            <tr>
                                                <td>{{ $item->filename }}</td>
                                                <td>
                                                    @if (in_array(pathinfo($item->path, PATHINFO_EXTENSION), $types))
                                                        <a href=" {{ url('storage/attachments/' . $item->linked_model . '/' . $item->path) }}" target="blank">
                                                            <img src="{{ url('storage/attachments/' . $item->linked_model . '/' . $item->path) }}" class="product-img-2">
                                                        </a>
                                                    @else
                                                        <a href=" {{ url('storage/attachments/' . $item->linked_model . '/' . $item->path) }}" target="blank"><i class="bx bx-file h1"></i></a>
                                                    @endif
                                                </td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                {{-- <td><i class="bx {{ $item->status ? 'bx-check-circle text-success' : 'bx-block  text-warning' }}" role="button" wire:click="change_status({{ $item->id }})"></i></td> --}}
                                                <td><i class="bx bx-trash text-danger" role="button" wire:click="delete({{ $item->id }})"></i></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" wire:click="toggleModal()">
                            @lang('Close')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

