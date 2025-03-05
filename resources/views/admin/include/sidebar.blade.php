<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Rukada</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>


    <!--navigation-->
    <ul class="metismenu" id="menu">
        {{-- Dashboard --}}
        <li class="@yield('dashboard')">
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        {{-- Inventory --}}
        <li class="menu-label">Inventory</li>
        <li class="@yield('category')">
            <a href="{{ route('admin.category.index') }}">
                <div class="parent-icon">
                    <i class='bx bx-category'></i>
                </div>
                <div class="menu-title">Category</div>
            </a>
        </li>

        <li class="@yield('subCategory')">
            <a href="{{ route('admin.subcategory.index') }}">
                <div class="parent-icon">
                    <i class='bx bx-category'></i>
                </div>
                <div class="menu-title">SubCategory</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>