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

        <li class="@yield('qna')">
            <a href="{{ route('admin.qna.index') }}">
                <div class="parent-icon">
                    <i class='bx bx-question-mark'></i>
                </div>
                <div class="menu-title">Q&A</div>
            </a>
        </li>


        {{-- Invoice --}}
        <li class="menu-label">Invoice</li>
        <li class="@yield('invoice')">
            <a href="javascript:;" class="has-arrow" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-cart"></i>
                </div>
                <div class="menu-title">Job Card</div>
            </a>
            <ul class="mm-collapse @yield('invoice_show')">
                <li class="@yield('vehicle_report')"> <a href="{{ route('admin.vehicle-report-invoice') }}"><i class="bx bx-right-arrow-alt"></i>Generate Invoice</a>
                </li>
                <li class="@yield('vehicle_invoice')"> <a href="{{ route('admin.vehicle-report-invoice-history') }}"><i class="bx bx-right-arrow-alt"></i> Invoice History</a>
                </li>
            </ul>
        </li>

        <li class="@yield('bill-invoice')">
            <a href="javascript:;" class="has-arrow" aria-expanded="false">
                <div class="parent-icon"><i class='bx bx-devices'></i>
                </div>
                <div class="menu-title">Billing POS</div>
            </a>
            <ul class="mm-collapse @yield('bill-invoice_show')">
                <li class="@yield('billing_pos_index')"> <a href="{{ route('admin.billing-pos-invoice') }}"><i class="bx bx-right-arrow-alt"></i>Generate Bill</a>
                </li>
                <li class="@yield('billing_pos_invoice')"> <a href="{{ route('admin.billing-pos-invoice-history') }}"><i class="bx bx-right-arrow-alt"></i>Bill Invoice History</a>
                </li>
            </ul>
        </li>

        {{-- ECommerce --}}
        <li class="menu-label">ECommerce</li>
        <li class="@yield('product')">
            <a href="{{ route('admin.product.index') }}">
                <div class="parent-icon">
                    <i class='bx bx-cart' ></i>
                </div>
                <div class="menu-title">Products</div>
            </a>
        </li>

        {{-- <li class="@yield('low-product')">
            <a href="{{ route('admin.low.stock.product') }}">
                <div class="parent-icon">
                    <i class='bx bx-cart' ></i>
                </div>
                <div class="menu-title">Low Stock Products</div>
            </a>
        </li> --}}

        {{-- People --}}
        {{-- <li class="menu-label">People</li>
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

        <li class="@yield('warehouse')">
            <a href="{{ route('admin.warehouse.index') }}">
                <div class="parent-icon">
                    <i class='bx bx-cube-alt' ></i>
                </div>
                <div class="menu-title">Warehouse</div>
            </a>
        </li> --}}

    </ul>
    <!--end navigation-->
</div>