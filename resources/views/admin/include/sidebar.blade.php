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
                    <i class='bx bx-layout'></i>
                </div>
                <div class="menu-title">SubCategory</div>
            </a>
        </li>

        <li class="@yield('brand')">
            <a href="{{ route('admin.brand.index') }}">
                <div class="parent-icon">
                    <i class='bx bx-terminal'></i>
                </div>
                <div class="menu-title">Brand</div>
            </a>
        </li>

        <li class="@yield('unit')">
            <a href="{{ route('admin.unit.index') }}">
                <div class="parent-icon">
                    <i class='bx bx-cube-alt' ></i>
                </div>
                <div class="menu-title">Unit</div>
            </a>
        </li>


        {{-- People --}}
        <li class="menu-label">People</li>
        <li class="@yield('customer')">
            <a href="{{ route('admin.customer.index') }}">
                <div class="parent-icon">
                    <i class='bx bx-cube-alt' ></i>
                </div>
                <div class="menu-title">Customers</div>
            </a>
        </li>

        <li class="@yield('bill')">
            <a href="{{ route('admin.bill.index') }}">
                <div class="parent-icon">
                    <i class='bx bx-cube-alt' ></i>
                </div>
                <div class="menu-title">Bills</div>
            </a>
        </li>

        <li class="@yield('supplier')">
            <a href="{{ route('admin.supplier.index') }}">
                <div class="parent-icon">
                    <i class='bx bx-cube-alt' ></i>
                </div>
                <div class="menu-title">Suppliers</div>
            </a>
        </li>

    </ul>
    <!--end navigation-->
</div>