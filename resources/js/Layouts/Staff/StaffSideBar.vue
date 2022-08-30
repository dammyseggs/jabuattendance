<template>
    <nav class="h-100 mainside">
        <div class="my-sidebar-menu">
            <div class="menu-title" v-if="getHOD">HOD</div>
            <div class="menu-title" v-else >Staff</div>
            <ul>
                <li><Link :href="route('staff.dashboard')" class="t-menu">Dashboard <span><i class="bx bxs-home-circle"></i></span></Link></li>
                <li @click="processClick('Courses')"  v-if="getHOD">
                    <a href="#" class="t-menu"> Courses <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenCourses">
                        <li><Link :href="route('staff.newcourse')" class="t-menu">New Course</Link></li>
                    </ul>
                </li>

                <li @click="processClick('Leturer')"  v-if="getHOD">
                    <a href="#" class="t-menu"> Leturer <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenLeturer">
                        <li><Link :href="route('staff.newlecturer')" class="t-menu">Leturer</Link></li>
                        <li><Link :href="route('staff.course.allocate')" class="t-menu">Allocate Course</Link></li>
                        <li><Link :href="route('staff.hod.viewclass')" class="t-menu">Classes in your Department</Link></li>
                    </ul>
                </li>

                <li @click="processClick('Attendance')">
                    <a href="#" class="t-menu">Lecture/Attendance <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenAttendance">
                        <li><Link :href="route('staff.newlecture')" class="t-menu">Create Lecture Class</Link></li>
                        <li><Link :href="route('staff.viewlecture')" class="t-menu">View Lecture Class</Link></li>
                        <li><Link :href="route('staff.allocatestudent')" class="t-menu">Allocate Student(s)</Link></li>
                        <li><Link :href="route('staff.loadattendance')" class="t-menu">Mark Attendance</Link></li>
                        <li><Link :href="route('staff.viewattendance')" class="t-menu">View Attendance</Link></li>
                        <li><Link v-if="getHOD" :href="route('staff.viewallattendance')" class="t-menu">All Attendance</Link></li>
                    </ul>
                </li>

                <li @click="processClick('Students')">
                    <a href="#" class="t-menu"> Students <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenStudents">
                        <li><Link :href="route('staff.searchstudent')" class="t-menu">View Student</Link></li>
                        <li v-if="getHOD"><Link :href="route('staff.newstudent')" class="t-menu">Register Student</Link></li>
                        <li v-if="getHOD"><Link :href="route('staff.uploadstudent')" class="t-menu">Upload Student</Link></li>
                        <li v-if="getHOD"><Link :href="route('staff.students.updatelevel')" class="t-menu">Update Students</Link></li>
                    </ul>
                </li>
            </ul>

        </div>
    </nav>
</template>

<script>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import $ from 'jquery'
    name: "StaffSideBar"
    export default {
        components: {
            Head,
            Link,
        },
        data() {
            return { 
                isHiddenCourses: false, 
                isHiddenAttendance: false,
                isHiddenStudents: false,
                isHiddenLeturer: false,
            }
        },

        methods: {  
          processClick(value) { 
              if(value == 'Courses'){
                  this.isHiddenCourses = !this.isHiddenCourses
              } 

              if(value == 'Attendance'){
                  this.isHiddenAttendance = !this.isHiddenAttendance
              } 

              if(value == 'Students'){
                  this.isHiddenStudents = !this.isHiddenStudents
              }
              
              if(value == 'Leturer'){
                  this.isHiddenLeturer = !this.isHiddenLeturer
              }
            //alert(value);  
          }  
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
.bb{
    border: 1px solid red;
}
</style>