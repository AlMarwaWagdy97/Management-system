<div>
    <form wire:submit.prevent="login" id="login-form">
        <div class="form-group mb-2 text-center">

            <!-- Display auth error message -->
            @if ($errorMessage)
                <div class="alert alert-danger my-3 w-75" id="emptyInputAlert" role="alert">
                    {{ $errorMessage }}
                </div>
            @endif

            <label for="" class="form-label">@lang('Email')</label>
            <div class="input-group">
                <input type="text" wire:model="email" class="form-control" required />
            </div>
        </div>

        <!-- Display validation error message -->
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <label for="" class="form-label">@lang('Password')</label>
        <div class="input-group position-relative">
            <input type="password" wire:model="password" class="form-control p-2 my-1" id="manager-password" required style="padding-left: 2.5rem;" />
            <span onclick="togglePasswordManager()" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #888; z-index: 10;">
                <i id="manager-eye" class="fa fa-eye"></i>
            </span>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <br />

        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary w-100" id="btnSend">
                @lang('Login')
            </button>
        </div>
    </form>

    <!-- إضافة مكتبة Font Awesome -->
    <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
    <script>
        function togglePasswordManager() {
            var input = document.getElementById('manager-password');
            var icon = document.getElementById('manager-eye');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</div>