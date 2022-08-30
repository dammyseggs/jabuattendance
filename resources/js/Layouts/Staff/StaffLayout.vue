<template>
  <div>
    <Head :title="title" />

    <!-- Begin page -->
        <div id="layout-wrapper">

            
            <main-header></main-header>
            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <staff-side-bar></staff-side-bar>
            </div>
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-sm-6">
                                <slot name="page-title-box"></slot>                                
                            </div>
                            <div class="col-sm-6">
                                <div class="state-information d-none d-sm-block">
                                    <div class="state-graph">
                                        <div id="header-chart-1"></div>
                                        
                                    </div>
                                    <div class="state-graph">
                                        <div id="header-chart-2"></div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        
                        <slot></slot>
                        
                        
      


                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                
                
               <main-footer></main-footer>
            
                <!-- <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                © JOSEPH AYO BABALOLA UNIVERSITY
                            </div>
                        </div>
                    </div>
                </footer> -->

                
            </div>            
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

       

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
  </div>
</template>

<script>
import JetApplicationLogo from '@/Jetstream/ApplicationLogo.vue'
import JetBanner from '@/Jetstream/Banner.vue'
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
import JetDropdown from '@/Jetstream/Dropdown.vue'
import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
import JetNavLink from '@/Jetstream/NavLink.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import MainHeader from '../MainHeader'
import MainFooter from '../MainFooter'
import StaffSideBar from './StaffSideBar'

export default {
  props: {
    title: String,
  },

  components: {
    Head,
    JetApplicationLogo,
    JetBanner,
    JetApplicationMark,
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
    Link,
    MainHeader,
    MainFooter,
    StaffSideBar,
  },

  data() {
    return {
      showingNavigationDropdown: false,
    }
  },

  methods: {
    switchToTeam(team) {
      this.$inertia.put(route('current-team.update'), {
        'team_id': team.id
      }, {
        preserveState: false
      })
    },

    logout() {
      this.$inertia.post(route('logout'));
    },
  },

  computed: {
    path() {
      return window.location.pathname
    }
  }
}
</script>
