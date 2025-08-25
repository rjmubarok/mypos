<!-- ======= Sidebar ======= -->
<style>
    .sidebar-nav .nav-link {
        display: flex;
        align-items: center;
        font-size: 18px;
        font-weight: 600;
        color: #4154f1;
        transition: 0.3;
        background: #f6f9ff;
        padding: 10px 15px;
        border-radius: 4px;
    }

    .sidebar-nav .nav-content a {
        display: flex;
        align-items: center;
        font-size: 18px;
        font-weight: 600;
        color: #012970;
        transition: 0.3;
        padding: 10px 0 10px 40px;
        transition: 0.3s;
    }

    .sidebar-nav .nav-content a i {
        font-size: 16px;
        margin-right: 8px;
        line-height: 0;
        border-radius: 50%;
    }

    .sidebar-nav .nav-content a.active {
        color: #ffffff;
        background-color: rgb(3, 37, 36);
    }
</style>


<aside id="sidebar" class="sidebar ">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item  {{ request()->routeIs('dashboard') ? 'active' : '' }} ">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="bi bi-house"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item  {{ request()->routeIs('category.index') ? 'active' : '' }} ">
            <a class="nav-link" href="{{ route('category.index') }}">
                <i class="bi bi-house"></i>
                <span>Category</span>
            </a>
        </li>
        <li class="nav-item  {{ request()->routeIs('brands.index') ? 'active' : '' }} ">
            <a class="nav-link" href="{{ route('brands.index') }}">
                <i class="bi bi-house"></i>
                <span>Brand</span>
            </a>
        </li>
        <li class="nav-item  {{ request()->routeIs('product.index') ? 'active' : '' }} ">
            <a class="nav-link" href="{{ route('product.index') }}">
                <i class="bi bi-house"></i>
                <span>Product</span>
            </a>
        </li>
        <li class="nav-item  {{ request()->routeIs('sale.index') ? 'active' : '' }} ">
            <a class="nav-link" href="{{ route('sale.index') }}">
                <i class="bi bi-house"></i>
                <span>Sale</span>
            </a>
        </li>
        <li class="nav-item  {{ request()->routeIs('supplier.index') ? 'active' : '' }} ">
            <a class="nav-link" href="{{ route('supplier.index') }}">
                <i class="bi bi-house"></i>
                <span>Supplier</span>
            </a>
        </li>


    </ul>

</aside>
