<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>Command Central</span>
                    </a>
                </li>
               
                <li>
                    <a href="<?php echo e(route('admin.setgoals')); ?>">
                        <i class="bx bx-check-square"></i>
                        <span>Goals</span>
                    </a>
                </li>

                  <li class="menu-title">Lead Generation</li>

                  <li>
                    <a href="<?php echo e(route('admin.source.list')); ?>" class="waves-effect">
                        <i class="fas fa-bars"></i>
                        <span>Source List</span>
                    </a>
                </li>
                <li><a href="<?php echo e(route('admin.group.index')); ?>" class=" waves-effect"> <i class="fas fa-phone"></i>
                        <span>Lists</span></a></li>
                        
                 <?php if(auth()->user()->can('dashboard') || auth()->user()->can('administrator') || auth()->user()->can('scraping_module')): ?>
                <li>
                    <a href="<?php echo e(route('admin.scraping.list')); ?>" class="waves-effect">
                        <i class="fas fa-bars"></i>
                        <span>Scraping Data</span>
                    </a>
                </li>
                <?php endif; ?>

                <li>  
                    <a href="<?php echo e(route('admin.campaign.index')); ?>" ><i class="bx bx-home-circle"></i><span>Prospect Campaigns</span></a>
                </li>
                 <li class="menu-title">Leads</li>

                 <li>  
                    <a href="<?php echo e(route('admin.leadcampaign.index')); ?>" ><i class="bx bx-home-circle"></i><span>Lead Campaigns</span></a>
                </li>
                 <li><a href="#" class="waves-effect"> <i class="fas fa-bars"></i>
                        <span>Research</span></a></li>
               
                 <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-message-square-dots"></i>
                        <span>SMS</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.single-sms.index')); ?>">Single SMS</a></li>

                        <li><a href="<?php echo e(route('admin.one-at-time.index')); ?>">Bulk SMS One At Time</a></li>


                        <li><a href="<?php echo e(route('admin.sms.failed')); ?>">Failed SMS</a></li>
                        <li><a href="<?php echo e(route('admin.appointment')); ?>">Appointments</a></li>
                    </ul>
                </li>


                 <li>
                   

                    <a href="<?php echo e(route('admin.sms.success')); ?>" class=" waves-effect">
                        <i class="fas fa-comment"></i>
                        <span>Received SMS</span>

                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.reply.index')); ?>" class=" waves-effect">
                        <i class="fas fa-comments"></i>
                        <span>All Conversations</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.thread.show')); ?>" class=" waves-effect">
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
                        <li><a href="<?php echo e(route('admin.single-email.index')); ?>">Single Email</a></li>

                        

                        
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
               
               
                       
                      


                <?php if(\App\Model\Settings::first()->sms_allowed > 0 && \App\Model\AutoResponder::all()->count() > 0 || \App\Model\AutoReply::all()->count() > 0): ?>




                <?php endif; ?>

                <?php if(\App\Model\Settings::first()->sms_allowed > 0 && \App\Model\AutoResponder::all()->count() > 0 || \App\Model\AutoReply::all()->count() > 0): ?>

               
               


                <li class="menu-title">Settings</li>
                  <li>
                    <a href="<?php echo e(route('admin.account.index')); ?>" class=" waves-effect">
                        <i class="fas fa-file-invoice"></i>
                        <span>Administrative Settings</span>
                    </a>
                </li>

                <li>
                     <a href="javascript:void(0)" class="has-arrow waves-effect">
                        <i class="fas fa-stethoscope"></i>
                        <span>System Settings</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.settings.index')); ?>" class=" waves-effect">System Settings</a></li>
                         <li>
                    <a href="<?php echo e(route('admin.script.index')); ?>" class=" waves-effect">
                    
                        Scripts
                    </a>
                </li>
                 <?php if(auth()->user()->can('dashboard') || auth()->user()->can('administrator') || auth()->user()->can('access_all')): ?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                       
                        <span>Users Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <?php if(auth()->user()->can('dashboard') || auth()->user()->can('administrator') || auth()->user()->can('user_module')): ?>
                        <li><a href="<?php echo e(route('admin.user-list.index')); ?>">Users</a></li>
                        <?php endif; ?>
                        <?php if(auth()->user()->can('dashboard') || auth()->user()->can('administrator') || auth()->user()->can('roles_module')): ?>
                        <li><a href="<?php echo e(route('admin.roles.index')); ?>">Roles</a></li>
                        <?php endif; ?>
                        <?php if(auth()->user()->can('dashboard') || auth()->user()->can('administrator') || auth()->user()->can('permissions_module')): ?>
                        <li><a href="<?php echo e(route('admin.permissions.index')); ?>">Permission</a></li>
                        <?php endif; ?>

                    </ul>
                </li>

                <?php endif; ?>
                 <li><a href="<?php echo e(route('admin.auto-responder.index')); ?>" class=" waves-effect">Keyword Auto-Responder</a></li>
                        <li><a href="<?php echo e(route('admin.auto-reply.index')); ?>" class=" waves-effect">Auto-Reply</a></li>
                        <li><a href="<?php echo e(route('admin.phone.numbers')); ?>" class="waves-effect">Phone Numbers</a></li>
                        <li><a href="<?php echo e(route('admin.template.index')); ?>" class="waves-effect">Templates</a></li>
                        <li><a href="<?php echo e(route('admin.market.index')); ?>" class=" waves-effect">Markets</a></li>
                        <li><a href="<?php echo e(route('admin.category.index')); ?>" class=" waves-effect">Lead Categories</a></li>
                        <li><a href="<?php echo e(route('admin.tag.index')); ?>" class=" waves-effect">Tags</a></li>
                        <li><a href="<?php echo e(route('admin.rvm.index')); ?>" class=" waves-effect">RVMS</a></li>
                        <li><a href="<?php echo e(route('admin.field.index')); ?>" class=" waves-effect">Custom Fields</a></li>
                        <li><a href="javascript: void(0);" class="has-arrow waves-effect"><span>DNC Management</span></a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?php echo e(route('admin.dnc-database.index')); ?>" class=" waves-effect">DNC Keywords</a></li>
                                <li><a href="<?php echo e(route('admin.blacklist.index')); ?>" class=" waves-effect">DNC Database</a></li>
                            </ul>
                        </li>














                <li><a href="<?php echo e(route('admin.quick-response.index')); ?>" class=" waves-effect">

               <span> Quick Response</span></a></li>




                <li style="display:none">
                    <a href="<?php echo e(route('admin.lead-category.index')); ?>" class=" waves-effect">

                        <span>Lead Categories</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(\App\Model\AutoResponder::all()->count() > 0 || \App\Model\AutoReply::all()->count() > 0): ?>
                <li>
                    <a href="#" class=" waves-effect">

                        <span>Billing</span>
                    </a>
                </li>

                
                <!-- 010923 sneha -->
                <li>
                    <a href="<?php echo e(route('admin.systemmessages.index')); ?>" class=" waves-effect">
                       
                        <span>System Messages</span>
                    </a>
                </li>
              
                <?php endif; ?>

                
            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
<?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/inc/nav.blade.php ENDPATH**/ ?>