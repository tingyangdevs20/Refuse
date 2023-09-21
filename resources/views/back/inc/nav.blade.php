<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>Command Central</span>
                    </a>
                </li>
               
                <li>
                    <a href="{{ route('admin.setgoals') }}">
                        <i class="bx bx-check-square"></i>
                        <span>Goals</span>
                    </a>
                </li>

                  <li class="menu-title">Lead Generation</li>

                <li>
                    <a href="{{ route('admin.source.list') }}" class="waves-effect">
                        <i class="fas fa-bars"></i>
                        <span>Source List</span>
                    </a>
                </li>
                <li><a href="{{ route('admin.group.index') }}" class=" waves-effect"> <i class="fas fa-phone"></i>
                        <span>Lists</span></a>
                </li>
                <li>
                    <a href="{{ route('admin.opt.list') }}" class=" waves-effect"> <i class="fas fa-bars"></i>
                        <span>OPT-IN</span>
                    </a>
                </li>        
                 @if(auth()->user()->can('dashboard') || auth()->user()->can('administrator') || auth()->user()->can('scraping_module'))
                <li>
                    <a href="{{ route('admin.scraping.list') }}" class="waves-effect">
                        <i class="fas fa-bars"></i>
                        <span>Scraping Data</span>
                    </a>
                </li>
                @endif

                <li>  
                    <a href="{{ route('admin.campaign.index') }}" ><i class="bx bx-home-circle"></i><span>Prospect Campaigns</span></a>
                </li>
                 <li class="menu-title">Leads</li>
                 <li>
                    <a href="{{ route('admin.reply.index') }}">
                        <i class="fas fa-comments"></i>
                        <span>Conversations</span>
                    </a>
                </li>
                 <li>  
                    <a href="{{ route('admin.leadcampaign.index') }}" ><i class="bx bx-home-circle"></i><span>Lead Campaigns</span></a>
                </li>
                 <li><a href="#" class="waves-effect"> <i class="fas fa-bars"></i>
                        <span>Research</span></a></li>
                         <li>
                  
                </li>
                <li>
                   
                            <a href="{{ route('admin.user-agreement.index') }}" class="waves-effect"> <i class="fas fa-bars"></i>
                            <span>  Digital Signing</span></a>
                        
                </li>
               
                 <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-message-square-dots"></i>
                        <span>SMS</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.single-sms.index') }}">Single SMS</a></li>
{{--                        <li><a href="{{ route('admin.bulk-sms.index') }}">Bulk SMS</a></li>--}}
                        <li><a href="{{ route('admin.one-at-time.index') }}">Bulk SMS One At Time</a></li>
{{--                        <li><a href="{{ route('admin.bulksmscategory.index') }}">Bulk SMS By Category</a></li>--}}

                        <li><a href="{{ route('admin.sms.failed') }}">Failed SMS</a></li>
                        <li><a href="{{ route('admin.appointment', [encrypt(Auth::id())]) }}">Appointments</a></li>
                    </ul>
                </li>


                 <li style="display:none">
                   

                    <a href="{{ route('admin.sms.success') }}" class=" waves-effect">
                        <i class="fas fa-comment"></i>
                        <span>Received SMS</span>

                    </a>
                </li>
               
                <li style="display:none">
                    <a href="{{ route('admin.thread.show') }}" class=" waves-effect">
                        <i class="fas fa-file-invoice"></i>
                        <span>Saved Threads</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-message-square-dots"></i>
                        <span>Email</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.single-email.index') }}">Single Email</a></li>
{{--                        <li><a href="{{ route('admin.bulk-sms.index') }}">Bulk SMS</a></li>--}}
                        {{-- <li><a href="{{ route('admin.one-at-time.index') }}">Bulk SMS One At Time</a></li> --}}
{{--                        <li><a href="{{ route('admin.bulksmscategory.index') }}">Bulk SMS By Category</a></li>--}}
                        {{-- <li><a href="{{ route('admin.sms.success') }}">Received SMS</a></li>
                        <li><a href="{{ route('admin.reply.index') }}">All Conversations</a></li>
                        <li><a href="{{ route('admin.thread.show') }}">Saved Threads</a></li>
                        <li><a href="{{ route('admin.sms.failed') }}">Failed SMS</a></li> --}}
                    </ul>
                </li>
                         
                
                <li class="menu-title">Deals</li> 
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-handshake"></i>
                        <span>Deals</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#" class="waves-effect">Inspection Pending</a></li>
                        <li><a href="#" class="waves-effect">Funding Pending</a></li>
                        <li><a href="#" class="waves-effect">Title Pending</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-handshake"></i>
                        <span>Closed Deals</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#" class="waves-effect">Passive</a></li>
                        <li><a href="#" class="waves-effect">Flips</a></li>
                    </ul>
                </li>

                @if(\App\Model\Settings::first()->sms_allowed > 0 && \App\Model\AutoResponder::all()->count() > 0 || \App\Model\AutoReply::all()->count() > 0)




                @endif

                @if(\App\Model\Settings::first()->sms_allowed > 0 && \App\Model\AutoResponder::all()->count() > 0 || \App\Model\AutoReply::all()->count() > 0)           


                <li class="menu-title">Settings</li>

                @if(auth()->user()->can('dashboard') || auth()->user()->can('administrator') || auth()->user()->can('user_task_module'))
                <li>
                    <a href="{{ route('admin.task-list.index') }}" class=" waves-effect">
                    <i class="fas fa-tasks"></i>
                        <span>User Task</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->can('dashboard') || auth()->user()->can('administrator') || auth()->user()->can('zoom_module'))

                <li>
                    <a href="{{ route('admin.zoom.index') }}" class=" waves-effect">
                    <i class="fas fa-video"></i>
                        <span>Zoom</span>
                    </a>
                </li>
                @endif

                  <li>
                    <a href="{{ route('admin.account.index') }}" class=" waves-effect">
                        <i class="fas fa-file-invoice"></i>
                        <span>Administrative Settings</span>
                    </a>
                </li>

                <li>
                     <a href="javascript:void(0)" class="has-arrow waves-effect">
                        <i class="fas fa-stethoscope"></i>
                        <span>Settings</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.settings.index') }}" class=" waves-effect">System Settings</a></li>
                         <li>
                    <a href="{{ route('admin.script.index') }}" class=" waves-effect">
                    
                        Scripts
                    </a>
                </li>
                 @if(auth()->user()->can('dashboard') || auth()->user()->can('administrator') || auth()->user()->can('access_all'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                       
                        <span>Users Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(auth()->user()->can('dashboard') || auth()->user()->can('administrator') || auth()->user()->can('user_module'))
                        <li><a href="{{ route('admin.user-list.index') }}">Users</a></li>
                        @endif
                        @if(auth()->user()->can('dashboard') || auth()->user()->can('administrator') || auth()->user()->can('roles_module'))
                        <li><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                        @endif
                        @if(auth()->user()->can('dashboard') || auth()->user()->can('administrator') || auth()->user()->can('permissions_module'))
                        <li><a href="{{ route('admin.permissions.index') }}">Permission</a></li>
                        @endif

                    </ul>
                </li>

                @endif
                 <li><a href="{{ route('admin.auto-responder.index') }}" class=" waves-effect">Keyword Auto-Responder</a></li>
                        <li><a href="{{ route('admin.auto-reply.index') }}" class=" waves-effect">Auto-Reply</a></li>
                        <li><a href="{{ route('admin.phone.numbers') }}" class="waves-effect">Phone Numbers</a></li>
                        <li><a href="{{ route('admin.template.index') }}" class="waves-effect">Templates</a></li>
                        <li><a href="{{ route('admin.formtemplates') }}" class="waves-effect">Digital Sign. Templates</a></li>
                        <li><a href="{{ route('admin.market.index') }}" class=" waves-effect">Markets</a></li>
                        <li><a href="{{ route('admin.category.index') }}" class=" waves-effect">Lead Categories</a></li>
                        <li><a href="{{ route('admin.tag.index') }}" class=" waves-effect">Tags</a></li>
                        <li><a href="{{ route('admin.rvm.index') }}" class=" waves-effect">RVMS</a></li>
                        <li><a href="{{ route('admin.field.index') }}" class=" waves-effect">Custom Fields</a></li>
                        <li><a href="javascript: void(0);" class="has-arrow waves-effect"><span>DNC Management</span></a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.dnc-database.index') }}" class=" waves-effect">DNC Keywords</a></li>
                                <li><a href="{{ route('admin.blacklist.index') }}" class=" waves-effect">DNC Database</a></li>
                            </ul>
                        </li>














                <li><a href="{{ route('admin.quick-response.index') }}" class=" waves-effect">

               <span> Quick Response</span></a></li>




                <li style="display:none">
                    <a href="{{ route('admin.lead-category.index') }}" class=" waves-effect">

                        <span>Lead Categories</span>
                    </a>
                </li>
                @endif
                @if(\App\Model\AutoResponder::all()->count() > 0 || \App\Model\AutoReply::all()->count() > 0)
                <li>
                    <a href="#" class=" waves-effect">

                        <span>Billing</span>
                    </a>
                </li>

                
                <!-- 010923 sneha -->
                <li>
                    <a href="{{ route('admin.systemmessages.index') }}" class=" waves-effect">
                       
                        <span>System Messages</span>
                    </a>
                </li>
              
                @endif

                {{--
                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-user-circle"></i>
                                     <span>Client Management</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="#">All Clients</a></li>
                                 </ul>
                             </li>
                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-store"></i>
                                     <span>Store Management</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="#">Categories</a></li>
                                     <li><a href="#">Sizes</a></li>
                                     <li><a href="#">Products</a></li>
                                     <li><a href="#">Coupons</a></li>
                                     <li><a href="#">Order's Status</a></li>
                                 </ul>
                             </li>
                             <li>
                                 <a href="#" class=" waves-effect">
                                     <i class="bx bx-shopping-bag"></i>
                                     <span>Orders

                                     </span>
                                 </a>
                             </li>

                             <li>
                                 <a href="chat.html" class=" waves-effect">
                                     <i class="bx bx-chat"></i>
                                     <span class="badge badge-pill badge-success float-right">New</span>
                                     <span>Chat</span>
                                 </a>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-store"></i>
                                     <span>Ecommerce</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="ecommerce-products.html">Products</a></li>
                                     <li><a href="ecommerce-product-detail.html">Product Detail</a></li>
                                     <li><a href="ecommerce-orders.html">Orders</a></li>
                                     <li><a href="ecommerce-customers.html">Customers</a></li>
                                     <li><a href="ecommerce-cart.html">Cart</a></li>
                                     <li><a href="ecommerce-checkout.html">Checkout</a></li>
                                     <li><a href="ecommerce-shops.html">Shops</a></li>
                                     <li><a href="ecommerce-add-product.html">Add Product</a></li>
                                 </ul>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-bitcoin"></i>
                                     <span>Crypto</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="crypto-wallet.html">Wallet</a></li>
                                     <li><a href="crypto-buy-sell.html">Buy/Sell</a></li>
                                     <li><a href="crypto-exchange.html">Exchange</a></li>
                                     <li><a href="crypto-lending.html">Lending</a></li>
                                     <li><a href="crypto-orders.html">Orders</a></li>
                                     <li><a href="crypto-kyc-application.html">KYC Application</a></li>
                                     <li><a href="crypto-ico-landing.html">ICO Landing</a></li>
                                 </ul>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-envelope"></i>
                                     <span>Email</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="email-inbox.html">Inbox</a></li>
                                     <li><a href="email-read.html">Read Email</a></li>
                                 </ul>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-receipt"></i>
                                     <span>Invoices</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="invoices-list.html">Invoice List</a></li>
                                     <li><a href="invoices-detail.html">Invoice Detail</a></li>
                                 </ul>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-briefcase-alt-2"></i>
                                     <span>Projects</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="projects-grid.html">Projects Grid</a></li>
                                     <li><a href="projects-list.html">Projects List</a></li>
                                     <li><a href="projects-overview.html">Project Overview</a></li>
                                     <li><a href="projects-create.html">Create New</a></li>
                                 </ul>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-task"></i>
                                     <span>Tasks</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="tasks-list.html">Task List</a></li>
                                     <li><a href="tasks-kanban.html">Kanban Board</a></li>
                                     <li><a href="tasks-create.html">Create Task</a></li>
                                 </ul>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bxs-user-detail"></i>
                                     <span>Contact</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="contacts-grid.html">User Grid</a></li>
                                     <li><a href="contacts-list.html">User List</a></li>
                                     <li><a href="contacts-profile.html">Profile</a></li>
                                 </ul>
                             </li>

                             <li class="menu-title">Pages</li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-user-circle"></i>
                                     <span>Authentication</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="auth-login.html">Login</a></li>
                                     <li><a href="auth-register.html">Register</a></li>
                                     <li><a href="auth-recoverpw.html">Recover Password</a></li>
                                     <li><a href="auth-lock-screen.html">Lock Screen</a></li>
                                 </ul>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-file"></i>
                                     <span>Utility</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="pages-starter.html">Starter Page</a></li>
                                     <li><a href="pages-maintenance.html">Maintenance</a></li>
                                     <li><a href="pages-comingsoon.html">Coming Soon</a></li>
                                     <li><a href="pages-timeline.html">Timeline</a></li>
                                     <li><a href="pages-faqs.html">FAQs</a></li>
                                     <li><a href="pages-pricing.html">Pricing</a></li>
                                     <li><a href="pages-404.html">Error 404</a></li>
                                     <li><a href="pages-500.html">Error 500</a></li>
                                 </ul>
                             </li>

                             <li class="menu-title">Components</li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-tone"></i>
                                     <span>UI Elements</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="ui-alerts.html">Alerts</a></li>
                                     <li><a href="ui-buttons.html">Buttons</a></li>
                                     <li><a href="ui-cards.html">Cards</a></li>
                                     <li><a href="ui-carousel.html">Carousel</a></li>
                                     <li><a href="ui-dropdowns.html">Dropdowns</a></li>
                                     <li><a href="ui-grid.html">Grid</a></li>
                                     <li><a href="ui-images.html">Images</a></li>
                                     <li><a href="ui-lightbox.html">Lightbox</a></li>
                                     <li><a href="ui-modals.html">Modals</a></li>
                                     <li><a href="ui-rangeslider.html">Range Slider</a></li>
                                     <li><a href="ui-session-timeout.html">Session Timeout</a></li>
                                     <li><a href="ui-progressbars.html">Progress Bars</a></li>
                                     <li><a href="ui-sweet-alert.html">Sweet-Alert</a></li>
                                     <li><a href="ui-tabs-accordions.html">Tabs & Accordions</a></li>
                                     <li><a href="ui-typography.html">Typography</a></li>
                                     <li><a href="ui-video.html">Video</a></li>
                                     <li><a href="ui-general.html">General</a></li>
                                     <li><a href="ui-colors.html">Colors</a></li>
                                     <li><a href="ui-rating.html">Rating</a></li>
                                     <li><a href="ui-notifications.html">Notifications</a></li>
                                     <li><a href="ui-image-cropper.html">Image Cropper</a></li>
                                 </ul>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="waves-effect">
                                     <i class="bx bxs-eraser"></i>
                                     <span class="badge badge-pill badge-danger float-right">10</span>
                                     <span>Forms</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="form-elements.html">Form Elements</a></li>
                                     <li><a href="form-layouts.html">Form Layouts</a></li>
                                     <li><a href="form-validation.html">Form Validation</a></li>
                                     <li><a href="form-advanced.html">Form Advanced</a></li>
                                     <li><a href="form-editors.html">Form Editors</a></li>
                                     <li><a href="form-uploads.html">Form File Upload</a></li>
                                     <li><a href="form-xeditable.html">Form Xeditable</a></li>
                                     <li><a href="form-repeater.html">Form Repeater</a></li>
                                     <li><a href="form-wizard.html">Form Wizard</a></li>
                                     <li><a href="form-mask.html">Form Mask</a></li>
                                 </ul>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-list-ul"></i>
                                     <span>Tables</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="tables-basic.html">Basic Tables</a></li>
                                     <li><a href="tables-datatable.html">Data Tables</a></li>
                                     <li><a href="tables-responsive.html">Responsive Table</a></li>
                                     <li><a href="tables-editable.html">Editable Table</a></li>
                                 </ul>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bxs-bar-chart-alt-2"></i>
                                     <span>Charts</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="charts-apex.html">Apex Charts</a></li>
                                     <li><a href="charts-echart.html">E Charts</a></li>
                                     <li><a href="charts-chartjs.html">Chartjs Chart</a></li>
                                     <li><a href="charts-flot.html">Flot Chart</a></li>
                                     <li><a href="charts-tui.html">Toast UI Chart</a></li>
                                     <li><a href="charts-knob.html">Jquery Knob Chart</a></li>
                                     <li><a href="charts-sparkline.html">Sparkline Chart</a></li>
                                 </ul>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-aperture"></i>
                                     <span>Icons</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="icons-boxicons.html">Boxicons</a></li>
                                     <li><a href="icons-materialdesign.html">Material Design</a></li>
                                     <li><a href="icons-dripicons.html">Dripicons</a></li>
                                     <li><a href="icons-fontawesome.html">Font awesome</a></li>
                                 </ul>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-map"></i>
                                     <span>Maps</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                     <li><a href="maps-google.html">Google Maps</a></li>
                                     <li><a href="maps-vector.html">Vector Maps</a></li>
                                     <li><a href="maps-leaflet.html">Leaflet Maps</a></li>
                                 </ul>
                             </li>

                             <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
                                     <i class="bx bx-share-alt"></i>
                                     <span>Multi Level</span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="true">
                                     <li><a href="javascript: void(0);">Level 1.1</a></li>
                                     <li><a href="javascript: void(0);" class="has-arrow">Level 1.2</a>
                                         <ul class="sub-menu" aria-expanded="true">
                                             <li><a href="javascript: void(0);">Level 2.1</a></li>
                                             <li><a href="javascript: void(0);">Level 2.2</a></li>
                                         </ul>
                                     </li>
                                 </ul>
                             </li>
              --}}
            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
