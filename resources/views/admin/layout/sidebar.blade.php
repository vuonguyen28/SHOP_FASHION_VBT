<aside class="main-sidebar elevation-4 sidebar-color" >
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('asset/img/logo/logo_shopbvt.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3 bg-logo_img" style="opacity: .8; ">
        <span class="brand-text font-weight-light text_name-logo">SHOP THOI TRANG </span>
    </a>
    <div class="sidebar os-host os-theme-light os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition os-host-scrollbar-vertical-hidden">
        <div class="os-resize-observer-host observed"><div class="os-resize-observer" style="left: 0px; right: auto;"></div></div><div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer"></div></div><div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 890px;"></div><div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="">
                <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                       
                    </div>
    
    
                    <!-- Sidebar Menu -->
                    <nav class="mt-2" >
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fa-solid fa-house-fire"></i>
                                    <p>
                                        Trang chủ
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fa-solid fa-box-open"></i>
                                    <p>
                                        Sản Phẩm
                                        <i class=" fas fa-angle-left right"></i>
                                        <span class="badge badge-info right">2</span>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('product.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Quản lý sản phẩm</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa-solid fa-layer-group"></i>
                                    <p>
                                        Danh mục
                                        <i class="fas fa-angle-left right"></i>
                                        <span class="badge badge-info right">6</span>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('category.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Danh mục sản phẩm</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('supplier.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nhà Cung Cấp</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('Color.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Màu sắc</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('size.index') }}"class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kích thước</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa-solid fa-user-group"></i>
                                    <p>
                                        Người dùng
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('customers.show') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Khách Hàng</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-tree"></i>
                                    <p>
                                        Đơn Hàng
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('order.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Đơn Hàng</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('voucher.index') }}" >
                                    <i class="nav-icon fa-solid fa-gift"></i>
                                    <p>
                                        Voucher
                                    </p>
                                </a>
    
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('statistic.index') }}" class="nav-link">
                                    <i class="nav-icon fa-solid fa-chart-simple"></i>
                                    <p>Báo cáo thống kê</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"  method="post">
                                    <i class="nav-icon fas fa-table"></i>
                                    <p>
                                        Đăng Xuất
                                    </p>
                                </a>
                            </li>
    
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
            </div>
        </div><div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar os-scrollbar-vertical os-scrollbar-unusable os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="height: 100%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar-corner"></div>
    </div>
    <!-- /.sidebar -->
</aside>
