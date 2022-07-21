<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
@php

@endphp
<aside class="left-sidebar" id="js-trigger-nav-team">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" id="main-scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav" id="main-sidenav">
            <ul id="sidebarnav">
                <!--Dashboard-->
                <li class="sidenav-menu-item menu-tooltip menu-with-tooltip" title="Home">
                    <a href={{ url('home') }} class="waves-effect waves-dark" aria-expanded="false"
                        target="_self">
                        <i class="ti-home"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <!--End Dashboard-->

                <!--Staff-->
                @if(auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('human_resource') || auth()->user()->roleHasPermission('human_resource'))
                <li class="sidenav-menu-item {{ $page['mainmenu_hr'] ?? '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                        <i class="fa fa-users"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.human_resource')) }}</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li class="{{ $page['submenu_employees'] ?? '' }}">
                            <a href={{ url('/employees') }} class="{{ $page['submenu_employees'] ?? '' }}">
                            {{ cleanLang(__('lang.employees')) }}
                            </a>
                        </li>

                        <li class="">
                            <a href={{ url('#') }}>
                            {{ cleanLang(__('lang.manage_leaves')) }}
                            </a>
                        </li>

                        <li class="">
                            <a href={{ url('#') }}>
                            {{ cleanLang(__('lang.manage_claims')) }}
                            </a>
                        </li>

                        <li class="">
                            <a href={{ url('#') }}>
                            {{ cleanLang(__('lang.manage_mcs')) }}
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
               
                <!--leads-->
                <li class="sidenav-menu-item {{ $page['mainmenu_leads'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.leads')) }}">
                    <a class="waves-effect waves-dark" href="{{ url('/leads') }}" aria-expanded="false" target="_self">
                        <i class="sl-icon-call-in"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.leads')) }}
                        </span>
                    </a>
                </li>
                <!--leads-->

                <!--projects-->
                <li class="sidenav-menu-item {{ $page['mainmenu_projects'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.projects')) }}">
                    <a class="waves-effect waves-dark" href="{{ url('/projects') }}" aria-expanded="false" target="_self">
                        <i class="ti-folder"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.projects')) }}
                        </span>
                    </a>
                </li>
                <!--projects-->

                <!--Inventory-->
                <!--Staff-->
                
                @if(auth()->user()->hasRole('superadmin') || auth()->user()->roleHasPermission('inventory_manage'))
                <li class="sidenav-menu-item {{ $page['mainmenu_inventory'] ?? '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="{{ url('/inventory') }}" aria-expanded="false">
                    <i class="sl-icon-social-dropbox"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.inventory')) }}</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li class="{{ $page['submenu_inventory'] ?? '' }}">
                            <a href={{ url('/inventory') }} class="{{ $page['submenu_inventory'] ?? '' }}">
                            {{ cleanLang(__('lang.inventory')) }}
                            </a>
                        </li>

                        <li class="{{ $page['submenu_faulty_eqp'] ?? '' }}">
                            <a href={{ url('/faulty_equipments') }} class="{{ $page['submenu_faulty_eqp'] ?? '' }}">
                            {{ cleanLang(__('lang.faulty_equipments')) }}
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
               
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>