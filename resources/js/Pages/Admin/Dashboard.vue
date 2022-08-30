<template>
    <admin-layout title="Admin Dashboard">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Dashboard</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Admin</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </template>

        <div class="sessionoff" v-if="!currentses">
             Whoops! Current Academic Session not Active
        </div>

        <div class="text-center text-success bg1" v-if="$page.props.success">
            <span>{{ $page.props.success }}</span>
        </div>

        <div class="welcome d-flex justify-content-between">
            <div>Welcome {{$page.props.user.name}} {{$page.props.user.othername}} ({{$page.props.user.title}})</div>
            <div>Admin</div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="float-end bx bx-book"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">No of Staffs </h6>
                            <h2 class="mb-4 text-white">{{ staffs }}</h2>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="float-end bx bxs-user-detail"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">Departments</h6>
                            <h2 class="mb-4 text-white">{{ departments }}</h2>                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="float-end bx bx-time"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">Current Section</h6>                           
                            <h2 class="mb-4 text-white" v-if="!currentses">OFF</h2>
                            <h2 class="mb-4 text-white" v-else>{{ currentses.name }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/Admin/AdminLayout'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    //import AppLayout from '@/Layouts/AppLayout'
    export default {
        props:['currentses', 'staffs', 'departments'],
        components: {
            AdminLayout,
            Head,
            Link,
        },
    }
</script>

<style lang="scss" scoped>
  .sessionoff{
    background-color: #ff0000;
    text-align: center;
    font-weight: 600;
    margin-bottom: 10px;
    border-radius: 15px;
  }
 .welcome{
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    border-radius: 10px;
    margin-bottom: 20px;
    padding: 10px 20px;
    font-size: 1em;
    font-weight: 800;
  }
</style>