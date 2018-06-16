<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-book"></i> <span>{{ config('app.name') }}</span></a>
        </div>
        <!-- menu profile quick info -->
    @include('admin.shared.menuProfile')
        <!-- /menu profile quick info -->

        <br/>

        <div class="clearfix"></div>
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a href="javascript:void(0)"><i class="fa fa-home"></i> Home
                        </a>
                    </li>

                    @include('admin.shared.menuSidebar.superAdmin')
                    @include('admin.shared.menuSidebar.fuentesPrimarias')
                    @include('admin.shared.menuSidebar.fuentesSecundarias')
                    
                </ul>
            </div>
            

        </div>
    </div>
</div>