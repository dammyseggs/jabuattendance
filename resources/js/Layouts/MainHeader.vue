<template>
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                    <!-- LOGO -->
                    <div class="navbar-brand-box ">
                        <Link :href="route('admin.dashboard')" v-if="getAdmin" class="logo logo-dark">
                            <img :src="'/storage/images/attendance1.png'" alt="" height="30" class="auth-logo-dark">
                        </Link>

                        <Link :href="route('staff.dashboard')" v-else class="logo logo-dark">
                            <img :src="'/storage/images/attendance1.png'" alt="" height="30" class="auth-logo-dark">
                        </Link>
                    </div>

                <button @click="processmenu" type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn" data-bs-toggle="button" autocomplete="off">
                    <i class="bx bxs-dashboard"></i>
                </button>


                <div class="d-none d-sm-block">
                    <div class="dropdown dropdown-topbar pt-3 mt-1 d-inline-block">
                        <!-- <div class="mainheading">JABU Online Attendance</div> -->
                        <div class="mainheading">JABU</div> 
                        <div class="mainheading"> 
                            <span>Online Attendance System</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex">           

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" :src="'/storage/images/avatar.png'"
                            alt="Header Avatar">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <Link class="dropdown-item" :href="route('profile.show')"><i class="mdi mdi-account-circle font-size-17 text-muted align-middle me-1"></i> Profile</Link>
                        <div class="dropdown-divider"></div>
                        <Link class="dropdown-item text-danger" :href="route('logout')" method="post">
                          <i class="mdi mdi-power font-size-17 text-muted align-middle me-1 text-danger"></i> 
                          Log out
                        </Link>
                    </div>
                </div>
            
                <div class="dropdown d-inline-block">
                    
                </div>         
            </div>
        </div>
    </header>
</template>

<script>
  import { Head, Link } from '@inertiajs/inertia-vue3'
  import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
  
    export default {
        components: {
            Head,
            Link,
            JetDropdownLink,
        },
        methods: {
            logout() {
                this.$inertia.post(route('logout'));
            },

            processmenu(){
                alert('DOne');
            },
        },

        computed: {
            getAdmin() {
                const roleNames = new Array();
                for (let i = 0; i < this.$page.props.user.roles.length; i++) {
                    roleNames[i] = this.$page.props.user.roles[i].name;
                }

                if (roleNames.includes('admin')) {
                   return true;
                }
                    
                return false;
            
            },
        },

    }
</script>

<style lang="scss" scoped>

</style>