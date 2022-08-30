<template>
    <staff-layout title="Staff Dashboard">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Dashboard <span v-if="getHOD">(HOD)</span></h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Staff</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
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
            <div>Department: {{ $page.props.user.department.name }}</div>
        </div>

       

        <div class="row" v-if="getHOD">
             <div class="col-xl-4 col-sm-6">
                <div class="card mini-stat bg-info">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="float-end bx bx-book"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">No of Courses</h6>
                            <h2 class="mb-4 text-white">{{ deptcoursecount }}</h2>
                            <Link :href="route('staff.newcourse')" class="ms-2 mystart">Courses in your Department</Link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card mini-stat bg-info">
                    <div class="card-body mini-stat-img"> 
                        <div class="mini-stat-icon">
                            <i class="float-end bx bxs-user-circle"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">No of Lecturer</h6>
                            <h2 class="mb-4 text-white">{{ stafcount }}</h2>
                            <Link :href="route('staff.newlecturer')" class="ms-2 mystart">Lecturers in your Department</Link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card mini-stat bg-info">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="float-end bx bxs-user-detail"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">No of Classes</h6>
                            <h2 class="mb-4 text-white" v-if="!currentses">OFF</h2>                            
                            <h2 class="mb-4 text-white" v-else>{{ lecturecount }}</h2>
                            <Link :href="route('staff.hod.viewclass')" class="ms-2 mystart">View Classes for your Department</Link>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="hr">
        </div>

        <div class="row">
            <div class="col-xl-4 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="float-end bx bx-book"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">No of Allocated Courses </h6>
                            <h2 class="mb-4 text-white" v-if="!currentses">OFF</h2>                            
                            <h2 class="mb-4 text-white" v-else>{{ yourcourses }}</h2>

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
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">No of Classes Created</h6>
                            <h2 class="mb-4 text-white" v-if="!currentses">OFF</h2>
                            <h2 class="mb-4 text-white" v-else>{{ yourclasses }}</h2>                            
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

        <br>
    </staff-layout>
</template>

<script>
    import StaffLayout from '@/Layouts/Staff/StaffLayout'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    //import AppLayout from '@/Layouts/AppLayout'
    export default {
        props:['currentses', 'yourcourses', 'yourclasses', 'deptcoursecount', 'stafcount', 'lecturecount'],
        components: {
            Head,
            Link,
            StaffLayout,
        },
        computed: {
            getHOD() {
                const roleNames = new Array();
                for (let i = 0; i < this.$page.props.user.roles.length; i++) {
                    roleNames[i] = this.$page.props.user.roles[i].name;
                }

                if (roleNames.includes('hod')) {
                   return true;
                }

                return  false;
            },
        },
    }
</script>

<style lang="scss" scoped>
  .bg1{
      background-color: #e2ede2;
      font-weight: 700;
      padding: 7px;
  }

  .mystart{
      color: #ffffff;
      text-decoration: none;
  }

  .mystart:hover{
      color: #bcc0bc;
  }

  .hr{
    margin-top: 10px;
  }
  
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