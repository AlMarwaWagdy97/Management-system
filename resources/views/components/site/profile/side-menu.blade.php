<div class="col-md-4 mb-4">
    <div class="profile-sidebar ">
        <div class="sidebar-menu card p-5 d-flex flex-column align-items-center gap-4 ">

            <a href="{{ route('site.profile.index') }}" class="sidebar-item {{ Route::is('site.profile.index') ? 'active' : '' }}" id="personal-info-tab">
                {{-- <i class="fas fa-user-circle"></i> --}}
                <h4 >حسابك الشخصي</h4>
            </a>

            {{-- <a href="{{ route('site.profile.statistics') }}" class="sidebar-item  {{ Route::is('site.profile.statistics') ? 'active' : '' }}" id="statistics-tab">
                <i class="fas fa-chart-pie"></i>
                <span>إحصائيات</span>
            </a> --}}

            <a href="{{ route('site.profile.orders') }}" class="sidebar-item  {{ Route::is('site.profile.orders') ? 'active' : '' }}" id="orders-tab">
                {{-- <i class="fas fa-clipboard-list"></i> --}}
                <h4>سجل الطلبات</h4>
            </a>

            {{-- <a href="{{ route('site.profile.gifts') }}" class="sidebar-item  {{ Route::is('site.profile.gifts') ? 'active' : '' }}" id="gifts-tab">
                <i class="fas fa-gift"></i>
                <h4>الإهداء الخيري</h4>
            </a> --}}

            {{-- <a href="{{ route('site.profile.cards.index') }}" class="sidebar-item  {{ Route::is('site.profile.cards.index') ? 'active' : '' }}" id="payment-cards-tab">
                <i class="fas fa-credit-card"></i>
                <h4>بطاقات الدفع</h4>
            </a> --}}


            <a href="#" class="sidebar-item" id="delete-account-tab"  data-bs-toggle="modal" data-bs-target="#closeAccountModal">
                {{-- <i class="fas fa-trash-alt"></i> --}}
                <h4>حذف الحساب</h4>
            </a>
            <div class="modal fade" id="closeAccountModal" tabindex="-1" aria-labelledby="closeAccountModal" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="closeAccountModal">@lang('Delete Account')</h5>
                    </div>
                    <div class="modal-body">
                        @lang('Are you Sure You Want To Close Your Account ?')
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('site.profile.close') }}" method="POST">
                            @csrf
                            <button type="button" class="btn btn-primary py-2" data-bs-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn-danger">@lang('Yes') </button>
                        </form>
                    
                    </div>
                </div>
                </div>
            </div>

            <!-- Exit Button -->
            <div class="text-center my-4">
                <a href="{{ route('site.logout') }}" class="btn exit-btn">
                    <i class="fas fa-sign-out-alt ml-2"></i>
                    @lang('logout')
                </a>
            </div>
            
        </div>
    </div>
</div>

<style>
    /* profile-sidebar.css */

.profile-sidebar {
  background-color: #f8f9fa;
  border-radius: 0.5rem;
  padding: 1rem;
}

.profile-sidebar .sidebar-menu {
  list-style: none;
  padding: 0;
  margin: 0;
}

.profile-sidebar .sidebar-item {
  display: flex;
  align-items: center;
  width: 100%;
  padding: 0.75rem 0.75rem;
  border-radius: 0.5rem;
  color: #495057;
  text-decoration: none;
  transition: background-color 0.2s, color 0.2s;
}

.profile-sidebar .sidebar-item i {
  font-size: 1.25rem;
  margin-right: 0.75rem;
  color: #6c757d;
}

.profile-sidebar .sidebar-item:hover {
  background-color: #e9ecef;
  color: #212529;
}

.profile-sidebar .sidebar-item.active {
  background-color: #4FC7AB;
  color: #fff;
}

.profile-sidebar .sidebar-item.active i {
  color: #fff;
}

.profile-sidebar .exit-btn {
  background-color: #dc3545;
  border: none;
  color: #fff;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  transition: background-color 0.2s;
}

.profile-sidebar .exit-btn:hover {
  background-color: #c82333;
  color: #fff;
}

#closeAccountModal .modal-content {
  border-radius: 0.5rem;
}

#closeAccountModal .modal-header,
#closeAccountModal .modal-footer {
  border: none;
}

#closeAccountModal .btn-danger {
  background-color: #dc3545;
  border: none;
}

#closeAccountModal .btn-primary {
  background-color: #6c757d;
  border: none;
}

</style>