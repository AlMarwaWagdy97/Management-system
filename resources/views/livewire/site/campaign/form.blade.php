<div>
    <div class="">
        <div class=" row justify-content-md-center">
            <div class="card col-lg-6 col-sm-12">
                <div class="text-center pt-5">
                    <h4 class="text-secondary h5"> بيانات الطلب</h4>
                </div>
                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3 mx-2" role="alert">
                    <p class="text-center">{{ session('success') }} </p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form  wire:submit.prevent="send">
                    <!-- name ----------------------------------------------------------------------------------------------->
                    <div class="form-group mt-3 p-1">
                        <label class="control-label"> اسم مقدم الطلب : </label>
                        <input type="text" class="form-control " wire:model="name" value="" placeholder="الاسم بالكامل">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- mobile --------------------------------------------------------------------------------------------->
                    <div class="form-group mt-3 p-1">
                        <label class="control-label">رقم الجوال : </label>
                        <input type="tel" data-inputmask="'mask': '9999999999'" class="form-control " wire:model="mobile" placeholder="رقم الجوال" value="" inputmode="text">
                        @error('mobile')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- email ---------------------------------------------------------------------------------------------->
                    <div class="form-group mt-3 p-1">
                        <label class="control-label">البريد الالكتروني : </label>
                        <input type="email" class="form-control " wire:model="email" placeholder=" البريد الالكتروني" value="">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- deceased_name -------------------------------------------------------------------------------------->
                    <div class="form-group mt-3 p-1">
                        <label class="control-label">اسم المتوفي : </label>
                        <input type="text" class="form-control " wire:model="deceased_name" placeholder="  اسم المتوفي" value="">
                        @error('deceased_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- relative_relation ---------------------------------------------------------------------------------->
                    <div class="form-group mt-3 p-1">
                        <label class="control-label">صله القرابة : </label>
                        <input type="text" class="form-control " wire:model="relative_relation" placeholder="  صله القرابة" value="">
                        @error('relative_relation')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Project -------------------------------------------------------------------------------------------->
                    <div class="form-group mt-3 p-1">
                        <label class="control-label"> المشروع الذي ترغب في جمع التبرع له صدقة عن المتوفي : </label>
                        <select wire:model="project_id" id="" class="form-control  ">
                            <option value=""> اختار المشروع</option>
                            <option value="28">كفالة يتيم 360 </option>
                            <option value="40">صدقتك لأغلى الناس </option>
                            <option value="108">سقيا الحرم </option>
                        </select>
                        @error('project_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- target_price --------------------------------------------------------------------------------------->
                    <div class="form-group mt-3 p-1">
                        <label class="control-label"> المبلغ المستهدف جمعه صدقة عن المتوفي : </label>
                        <input type="number" step="any" class="form-control " wire:model="target_price" placeholder=" المبلغ المتوقع " value="">
                        @error('target_price')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- deceased_image ------------------------------------------------------------------------------------->
                    <div class="form-group mt-3 p-1 ">
                        <label class="control-label" for="imageUpload"> ارفاق صورة للمتوفي - يتم اضافتها في رابط التبرع / اختياري : </label>
                        <div class="has-feedback input-group">
                            <input class="form-control" wire:model="deceased_image" value="" type="file">
                        </div>
                        @error('deceased_image')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- description ---------------------------------------------------------------------------------------->
                    <div class="form-group my-3 p-1">
                        <label class="control-label"> اكتب ( كلمة / رسالة / دعاء ) للمتوفي لاضافته في رابط التبرع / اختياري : </label>
                        <textarea wire:model="description" class="form-control " id="" cols="30" rows="10"> </textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-xs-12 text-center">
                        <button type="submit" wire:model="submit" class="btn btn-primary px-5 py-2"> ارسال الطلب
                    </div>
                    <br>
                </form>
            </div>

        </div>
    </div>

</div>
