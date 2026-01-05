<div class="nk-sidebar" data-content="sidebarMenu">
    <div class="nk-sidebar-bar">
        <div class="nk-apps-brand">
            <a href="{{ route('dashboard') }}" class="logo-link">
                <img class="logo-light logo-img" src="{{ asset('images/pakoakuina.jpeg') }}"
                    srcset="{{ asset('images/pakoakuina.jpeg') }} 2x" alt="logo">
                <img class="logo-dark logo-img" src="{{ asset('images/pakoakuina.jpeg') }}"
                    srcset="{{ asset('images/pakoakuina.jpeg') }} 2x" alt="logo-dark">
            </a>
        </div>

        <div class="nk-sidebar-element">
            <div class="nk-sidebar-body">
                <!-- <div class="nk-sidebar-content" data-simplebar>
                    <div class="nk-sidebar-menu">
                        <ul class="nk-menu apps-menu">
                            <li class="nk-menu-item active">
                                <a href="#" class="nk-menu-link nk-menu-switch" data-target="navHospital">
                                    <span class="nk-menu-icon"><em class="icon ni ni-plus-medi"></em></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> -->
                <!-- <div class="nk-menu-trigger ms-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
            </div> -->
                <div class="nk-sidebar-profile nk-sidebar-profile-fixed">
                    <div class="nk-sidebar-footer">
                        <a href="{{ route('logout') }}" class="btn btn-icon btn-trigger" title="Sign Out">
                            <em class="icon ni ni-signout"></em>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="nk-sidebar-main is-light">
        <div class="nk-sidebar-inner" data-simplebar>
            <div class="nk-menu-content menu-active" data-content="navHospital">
                <h5 class="title">Project Management 4W</h5>
                <ul class="nk-menu">
                    <li class="nk-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">dashboard</span>
                        </a>
                    </li>
                    <!-- <li class="nk-menu-item {{ request()->routeIs('project') ? 'active' : '' }}">
                        <a href="{{ route('project') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-dashboard-fill"></em>
                            </span>
                            <span class="nk-menu-text">Project Management</span>
                        </a>
                    </li>

                     <li class="nk-menu-item {{ request()->routeIs('ganttchart') ? 'active' : '' }}">
                        <a href="{{ route('ganttchart') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">Ganttchart</span>
                        </a>
                    </li> -->
                    <li
                        class="nk-menu-item has-sub {{ request()->routeIs('project') || request()->routeIs('ganttchart') ? 'active current-page' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-dashboard-fill"></em>
                            </span>
                            <span class="nk-menu-text">Project Management</span>
                        </a>

                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('project') }}"
                                    class="nk-menu-link {{ request()->routeIs('project') ? 'active' : '' }}">
                                    <span class="nk-menu-text">Project</span>
                                </a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="{{ route('ganttchart') }}"
                                    class="nk-menu-link {{ request()->routeIs('ganttchart') ? 'active' : '' }}">
                                    <span class="nk-menu-text">Ganttchart</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- <li class="nk-menu-item {{ request()->routeIs('resource') ? 'active' : '' }}">
                        <a href="{{ route('resource') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">Resource Management</span>
                        </a>
                    </li>

                    <li class="nk-menu-item {{ request()->routeIs('heatmap') ? 'active' : '' }}">
                        <a href="{{ route('heatmap') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">Tasks Heatmap</span>
                        </a>
                    </li> -->

                    <li
                        class="nk-menu-item has-sub {{ request()->routeIs('resource') || request()->routeIs('heatmap') ? 'active current-page' : '' }}">

                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-dashboard-fill"></em>
                            </span>
                            <span class="nk-menu-text">Resource Management</span>
                        </a>

                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('resource') }}"
                                    class="nk-menu-link {{ request()->routeIs('resource') ? 'active' : '' }}">
                                    <span class="nk-menu-text">Resource Workload</span>
                                </a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="{{ route('heatmap') }}"
                                    class="nk-menu-link {{ request()->routeIs('heatmap') ? 'active' : '' }}">
                                    <span class="nk-menu-text">Tasks Heatmap</span>
                                </a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="{{ route('progress') }}"
                                    class="nk-menu-link {{ request()->routeIs('progress') ? 'active' : '' }}">
                                    <span class="nk-menu-text">Tasks Progress</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nk-menu-item has-sub {{ request()->routeIs('inholiday') || request()->routeIs('inclient') ? 'active current-page' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-dashboard-fill"></em>
                            </span>
                            <span class="nk-menu-text">List Master Data</span>
                        </a>

                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('inholiday') }}"
                                    class="nk-menu-link {{ request()->routeIs('inholiday') ? 'active' : '' }}">
                                    <span class="nk-menu-text">Input Holiday</span>
                                </a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="{{ route('inclient') }}"
                                    class="nk-menu-link {{ request()->routeIs('inclient') ? 'active' : '' }}">
                                    <span class="nk-menu-text">Input Client</span>
                                </a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="{{ route('inresponsible') }}"
                                    class="nk-menu-link {{ request()->routeIs('inresponsible') ? 'active' : '' }}">
                                    <span class="nk-menu-text">Input Resource Management</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- <li class="nk-menu-item {{ request()->routeIs('inholiday') ? 'active' : '' }}">
                        <a href="{{ route('inholiday') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">Input Holiday</span>
                        </a>
                    </li>
                    <li class="nk-menu-item {{ request()->routeIs('inclient') ? 'active' : '' }}">
                        <a href="{{ route('inclient') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">Input Client</span>
                        </a>
                    </li> -->

                    

                    <!-- <li class="nk-menu-item {{ request()->routeIs('calendar') ? 'active' : '' }}">
                        <a href="{{ route('calendar') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">Calendar</span>
                        </a>
                    </li>
                    <li class="nk-menu-item has-sub {{ request()->routeIs('calendar*') ? 'active current-page' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">Calendar</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('ganttchart') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Daily View</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link">
                                    <span class="nk-menu-text">Weekly View</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link">
                                    <span class="nk-menu-text">Monthly View</span>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
</div>