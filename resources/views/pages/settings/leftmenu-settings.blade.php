<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar settings-menu">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" id="settings-scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav" id="settings-sidebar-nav">
            <ul id="sidebarnav">

                <!--main-->
                <li class="sidenav-menu-item {{ $page['settingsmenu_main'] ?? '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false"
                        id="settings-menu-main">
                        <span class="hide-menu">{{ cleanLang(__('lang.main_settings')) }}
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="javascript:void(0);" data-url={{ url('settings/general') }} id="settings-menu-main-general"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.general_settings')) }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-url={{ url('settings/company') }} id="settings-menu-main-company"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.company_details')) }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-url={{ url('settings/currency') }} id="settings-menu-main-currency"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.currency')) }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-url={{ url('settings/theme') }} id="settings-menu-main-theme"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.theme')) }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-url={{ url('settings/logos') }} id="settings-menu-main-logo"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.company_logo')) }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-url={{ url('settings/cronjobs') }} id="settings-menu-main-cronjobs"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.cronjob_settings')) }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-url={{ url('settings/system/clearcache') }} id="settings-menu-main-cronjobs"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.clear_cache')) }}</a>
                        </li>
                    </ul>
                </li>

                <!--categories-->
                <li class="sidenav-menu-item">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false"
                        id="settings-menu-categories">
                        <span class="hide-menu">{{ cleanLang(__('lang.categories')) }}
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <!--project-->
                        <li>
                            <a class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url"
                                id="settings-menu-categories-project" href="javascript:void(0);"
                                data-url={{ url('categories?filter_category_type=project&source=ext') }}>{{ cleanLang(__('lang.projects')) }}
                            </a>
                        </li>
                        <!--lead-->
                        <li><a class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url"
                                id="settings-menu-categories-lead" href="javascript:void(0);"
                                data-url={{ url('categories?filter_category_type=lead&source=ext') }}>{{ cleanLang(__('lang.leads')) }}</a>
                        </li>
                        <!--inventory-->
                        <li><a class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url"
                                id="settings-menu-categories-inventory" href="javascript:void(0);"
                                data-url={{ url('categories?filter_category_type=inventory&source=ext') }}>{{ cleanLang(__('lang.inventory')) }}
                            </a></li>
                    </ul>
                </li>
                <!--projects-->
                <!-- <li class="sidenav-menu-item">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false"
                        id="settings-menu-projects">
                        <span class="hide-menu">{{ cleanLang(__('lang.projects')) }}
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="javascript:void(0);" data-url={{ url('settings/projects/general') }}
                                id="settings-menu-projects-general"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.general_settings')) }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-url={{ url('settings/projects/staff') }}
                                id="settings-menu-projects-staff-permissions"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.team_permissions')) }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-url={{ url('settings/projects/client') }}
                                id="settings-menu-client-permissions"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.client_permissions')) }}</a>
                        </li>
                        <li><a href="javascript:void(0);" data-url={{ url('settings/customfields/projects') }}
                                id="settings-menu-projects-forms"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.custom_form_fields')) }}</a>
                        </li>
                    </ul>
                </li> -->

                <!--leads-->
                <!-- <li class="sidenav-menu-item">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false"
                        id="settings-menu-leads">
                        <span class="hide-menu">{{ cleanLang(__('lang.leads')) }}
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="javascript:void(0);" data-url={{ url('settings/leads/general') }}
                                id="settings-menu-leads-settings"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.general_settings')) }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-url={{ url('settings/leads/statuses') }}
                                id="settings-menu-leads-stages"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.lead_stages')) }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-url={{ url('settings/sources') }} id="settings-menu-leads-sources"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.lead_sources')) }}</a>
                        </li>
                        <li><a href="javascript:void(0);" data-url={{ url('settings/customfields/leads') }}
                                id="settings-menu-leads-forms"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.custom_form_fields')) }}</a>
                        </li>
                    </ul>
                </li> -->

                <!--Email-->
                <!-- <li class="sidenav-menu-item">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false"
                        id="settings-menu-email">
                        <span class="hide-menu">{{ cleanLang(__('lang.email')) }}
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        
                        <li><a href="javascript:void(0);" data-url={{ url('settings/email/general') }}
                                id="settings-menu-email-settings"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.general_settings')) }}</a>
                        </li>
                        <li><a href="javascript:void(0);" data-url={{ url('settings/email/templates') }}
                                id="settings-menu-email-templates"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.email_templates')) }}</a>
                        </li>
                        <li><a href="javascript:void(0);" data-url={{ url('settings/email/smtp') }} id="settings-menu-email-smtp"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.smtp_settings')) }}</a>
                        </li>
                    </ul>
                </li> -->

                <!--roles-->
                <li class="sidenav-menu-item">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false"
                        id="settings-menu-roles">
                        <span class="hide-menu">{{ cleanLang(__('lang.user_roles')) }}
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="javascript:void(0);" data-url={{ url('settings/roles') }} id="settings-menu-roles-general"
                                class="js-ajax-ux-request js-submenu-ajax js-dynamic-settings-url">{{ cleanLang(__('lang.general_settings')) }}</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>