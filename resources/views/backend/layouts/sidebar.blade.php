<div id="left-sidebar" class="sidebar">
    <div class="">
        <div class="user-account">
            <img src="https://www.google.com/imgres?q=picture&imgurl=https%3A%2F%2Fstatic.vecteezy.com%2Fsystem%2Fresources%2Fthumbnails%2F036%2F324%2F708%2Fsmall%2Fai-generated-picture-of-a-tiger-walking-in-the-forest-photo.jpg&imgrefurl=https%3A%2F%2Fwww.vecteezy.com%2Ffree-photos%2Fpicture&docid=wska7sM6RxRdCM&tbnid=crGgp78bfBsQFM&vet=12ahUKEwiDl_Dh3JOPAxVvR2wGHSNYPDgQM3oECBYQAA..i&w=300&h=200&hcb=2&ved=2ahUKEwiDl_Dh3JOPAxVvR2wGHSNYPDgQM3oECBYQAA" class="rounded-circle user-photo" alt="User Profile Picture">
            <div class="dropdown">

                <a href="javascript:void(0);" class="dropdown-toggle user-name"
                    data-toggle="dropdown"><strong>{{ auth()->user()->name ?? '' }}
                    </strong></a>
                <ul class="dropdown-menu dropdown-menu-right account">
                    <li><a href="{{ route('profile') }}"><i class="fas fa-user"></i> My Profile</a></li>
                    <li><a href="app-inbox.html"><i class="fas fa-envelope-open"></i> Messages</a></li>
                    <li><a href="javascript:void(0);"><i class="fas fa-cog"></i> Settings</a></li>
                    <li class="divider"></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="fas fa-power-off"></i> Logout</a></li>

                </ul>
            </div>


        </div>
        <!-- Nav tabs -->


        <!-- Tab panes -->
        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane active" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">
                       <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="has-arrow"><i class="fas fa-home"></i>
                                <span>Dashboard</span></a>
                        </li>
                        <li>
                            <a href="#App" class="has-arrow"><i class="fas fa-th"></i> <span>App</span></a>
                            <ul>
                                <li><a href="app-inbox.html">Inbox</a></li>
                                <li><a href="app-chat.html">Chat</a></li>
                                <li><a href="app-calendar.html">Calendar</a></li>
                                <li><a href="app-contact.html">Contact list</a></li>
                                <li><a href="app-contact-grid.html">Contact Card <span
                                            class="badge badge-warning float-right">New</span></a></li>
                                <li><a href="app-taskboard.html">Taskboard</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#FileManager" class="has-arrow"><i class="fas fa-folder"></i> <span>File
                                    Manager</span></a>
                            <ul>
                                <li><a href="file-dashboard.html">Dashboard</a></li>
                                <li><a href="file-documents.html">Documents</a></li>
                                <li><a href="file-media.html">Media</a></li>
                                <li><a href="file-images.html">Images</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#Blog" class="has-arrow"><i class="fas fa-globe"></i> <span>Blog</span></a>
                            <ul>
                                <li><a href="blog-dashboard.html">Dashboard</a></li>
                                <li><a href="blog-post.html">New Post</a></li>
                                <li><a href="blog-list.html">Blog List</a></li>
                                <li><a href="blog-details.html">Blog Detail</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#uiElements" class="has-arrow"><i class="fas fa-gem"></i> <span>UI
                                    Elements</span></a>
                            <ul>
                                <li><a href="ui-typography.html">Typography</a></li>
                                <li><a href="ui-tabs.html">Tabs</a></li>
                                <li><a href="ui-buttons.html">Buttons</a></li>
                                <li><a href="ui-bootstrap.html">Bootstrap UI</a></li>
                                <li><a href="ui-icons.html">Icons</a></li>
                                <li><a href="ui-notifications.html">Notifications</a></li>
                                <li><a href="ui-colors.html">Colors</a></li>
                                <li><a href="ui-dialogs.html">Dialogs</a></li>
                                <li><a href="ui-list-group.html">List Group</a></li>
                                <li><a href="ui-media-object.html">Media Object</a></li>
                                <li><a href="ui-modals.html">Modals</a></li>
                                <li><a href="ui-nestable.html">Nestable</a></li>
                                <li><a href="ui-progressbars.html">Progress Bars</a></li>
                                <li><a href="ui-range-sliders.html">Range Sliders</a></li>
                                <li><a href="ui-treeview.html">Treeview</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#Widgets" class="has-arrow"><i class="fas fa-puzzle-piece"></i>
                                <span>Widgets</span></a>
                            <ul>
                                <li><a href="widgets-statistics.html">Statistics</a></li>
                                <li><a href="widgets-data.html">Data</a></li>
                                <li><a href="widgets-chart.html">Chart</a></li>
                                <li><a href="widgets-weather.html">Weather</a></li>
                                <li><a href="widgets-social.html">Social</a></li>
                                <li><a href="widgets-blog.html">Blog</a></li>
                                <li><a href="widgets-ecommerce.html">eCommerce</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#Authentication" class="has-arrow"><i class="fas fa-lock"></i>
                                <span>Authentication</span></a>
                            <ul>
                                <li><a href="page-login.html">Login</a></li>
                                <li><a href="page-register.html">Register</a></li>
                                <li><a href="page-lockscreen.html">Lockscreen</a></li>
                                <li><a href="page-forgot-password.html">Forgot Password</a></li>
                                <li><a href="page-404.html">Page 404</a></li>
                                <li><a href="page-403.html">Page 403</a></li>
                                <li><a href="page-500.html">Page 500</a></li>
                                <li><a href="page-503.html">Page 503</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#Pages" class="has-arrow"><i class="fas fa-file-alt"></i>
                                <span>Pages</span></a>
                            <ul>
                                <li><a href="page-blank.html">Blank Page</a> </li>
                                <li><a href="page-profile.html">Profile <span
                                            class="badge badge-default float-right">v1</span></a></li>
                                <li><a href="page-profile2.html">Profile <span
                                            class="badge badge-warning float-right">v2</span></a></li>
                                <li><a href="page-gallery.html">Image Gallery <span
                                            class="badge badge-default float-right">v1</span></a> </li>
                                <li><a href="page-gallery2.html">Image Gallery <span
                                            class="badge badge-warning float-right">v2</span></a> </li>
                                <li><a href="page-timeline.html">Timeline</a></li>
                                <li><a href="page-timeline-h.html">Horizontal Timeline</a></li>
                                <li><a href="page-pricing.html">Pricing</a></li>
                                <li><a href="page-invoices.html">Invoices</a></li>
                                <li><a href="page-invoices2.html">Invoices <span
                                            class="badge badge-warning float-right">v2</span></a></li>
                                <li><a href="page-search-results.html">Search Results</a></li>
                                <li><a href="page-helper-class.html">Helper Classes</a></li>
                                <li><a href="page-teams-board.html">Teams Board</a></li>
                                <li><a href="page-projects-list.html">Projects List</a></li>
                                <li><a href="page-maintenance.html">Maintenance</a></li>
                                <li><a href="page-testimonials.html">Testimonials</a></li>
                                <li><a href="page-faq.html">FAQ</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#forms" class="has-arrow"><i class="fas fa-pencil-alt"></i>
                                <span>Forms</span></a>
                            <ul>
                                <li><a href="forms-validation.html">Form Validation</a></li>
                                <li><a href="forms-advanced.html">Advanced Elements</a></li>
                                <li><a href="forms-basic.html">Basic Elements</a></li>
                                <li><a href="forms-wizard.html">Form Wizard</a></li>

                                <li><a href="forms-dragdropupload.html">Drag &amp; Drop Upload</a></li>

                                <li><a href="forms-cropping.html">Image Cropping</a></li>
                                <li><a href="forms-summernote.html">Summernote</a></li>
                                <li><a href="forms-editors.html">CKEditor</a></li>
                                <li><a href="forms-markdown.html">Markdown</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#Tables" class="has-arrow"><i class="fas fa-tag"></i> <span>Tables</span></a>
                            <ul>
                                <li><a href="table-basic.html">Tables Example<span
                                            class="badge badge-info float-right">New</span></a> </li>
                                <li><a href="table-normal.html">Normal Tables</a> </li>
                                <li><a href="table-jquery-datatable.html">Jquery Datatables</a> </li>
                                <li><a href="table-editable.html">Editable Tables</a> </li>
                                <li><a href="table-color.html">Tables Color</a> </li>
                                <li><a href="table-filter.html">Table Filter <span
                                            class="badge badge-info float-right">New</span></a> </li>
                                <li><a href="table-dragger.html">Table dragger <span
                                            class="badge badge-info float-right">New</span></a> </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#charts" class="has-arrow"><i class="fas fa-chart-bar"></i>
                                <span>Charts</span></a>
                            <ul>
                                <li><a href="chart-morris.html">Morris</a> </li>
                                <li><a href="chart-flot.html">Flot</a> </li>
                                <li><a href="chart-chartjs.html">ChartJS</a> </li>
                                <li><a href="chart-jquery-knob.html">Jquery Knob</a> </li>

                                <li><a href="chart-sparkline.html">Sparkline Chart</a></li>
                                <li><a href="chart-peity.html">Peity</a></li>
                                <li><a href="chart-c3.html">C3 Charts</a></li>
                                <li><a href="chart-gauges.html">Gauges</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#Maps" class="has-arrow"><i class="fas fa-map"></i> <span>Maps</span></a>
                            <ul>
                                <li><a href="map-google.html">Google Map</a></li>
                                <li><a href="map-yandex.html">Yandex Map</a></li>
                                <li><a href="map-jvectormap.html">jVector Map</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#menu-level-1" class="has-arrow"><i class="fas fa-tag"></i> <span>Menu Level
                                    1</span></a>
                            <ul>
                                <li>
                                    <a href="#menu-level-2" class="has-arrow">Menu Level 2</a>
                                    <ul>
                                        <li><a href="#">Link 1</a></li>
                                        <li><a href="#">Link 2</a></li>
                                        <li><a href="#">Link 3</a></li>
                                        <li><a href="#">Link 4</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="tab-pane p-l-15 p-r-15" id="Chat">
                <form>
                    <div class="input-group m-b-20">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                </form>
                <ul class="right_chat list-unstyled">
                    <!-- Chat users same as original -->
                </ul>
            </div>
            <div class="tab-pane p-l-15 p-r-15" id="setting">
                <!-- Settings same as original -->
            </div>
            <div class="tab-pane p-l-15 p-r-15" id="question">
                <form>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                </form>
                <ul class="list-unstyled question">
                    <li class="menu-heading">HOW-TO</li>
                    <li><a href="javascript:void(0);">How to Create Campaign</a></li>
                    <li><a href="javascript:void(0);">Boost Your Sales</a></li>
                    <li><a href="javascript:void(0);">Website Analytics</a></li>
                    <li class="menu-heading">ACCOUNT</li>
                    <li><a href="javascript:void(0);">Create New Account</a></li>
                    <li><a href="javascript:void(0);">Change Password?</a></li>
                    <li><a href="javascript:void(0);">Privacy &amp; Policy</a></li>
                    <li class="menu-heading">BILLING</li>
                    <li><a href="javascript:void(0);">Payment info</a></li>
                    <li><a href="javascript:void(0);">Auto-Renewal</a></li>
                    <li class="menu-button m-t-30">
                        <a href="javascript:void(0);" class="btn btn-primary"><i class="fas fa-question-circle"></i>
                            Need Help?</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
