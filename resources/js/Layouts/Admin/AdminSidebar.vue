<template>
    <nav class="h-100 mainside">
        <div class="my-sidebar-menu">
            <div class="menu-title">Admin</div>
            <ul>
                <li><Link :href="route('admin.dashboard')" class="t-menu">Dashboard</Link></li>
                
                <!-- <li><Link :href="route('admin.roles.index')" class="t-menu">Role</Link></li> -->

                <li @click="processClick('Staff')">
                    <a href="#" class="t-menu"> Staffs <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenStaff">
                        <li><Link :href="route('admin.staffs.index')" class="t-menu">New Staff</Link></li>
                    </ul>
                </li>

                <li @click="processClick('Student')">
                    <a href="#" class="t-menu"> Students <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenStudent">
                        <li><Link :href="route('admin.students.index')" class="t-menu">New Student</Link></li>
                        <li><Link :href="route('admin.students.create')" class="t-menu">Upload Student</Link></li>
                        <li><Link :href="route('admin.students.updatelevel')" class="t-menu">Update Students</Link></li>
                    </ul>
                </li>
                
                <li @click="processClick('asess')">
                    <a href="#" class="t-menu"> Academic Session <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenAcadSession">
                        <li><Link :href="route('admin.acadsession.index')" class="t-menu">Academic Session</Link></li>
                    </ul>
                </li>

                <li @click="processClick('College')">
                    <a href="#" class="t-menu"> College <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenCollege">
                        <li><Link :href="route('admin.college.index')" class="t-menu">College</Link></li>
                    </ul>
                </li>

                <li @click="processClick('Department')">
                    <a href="#" class="t-menu"> Department <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenDepartment">
                        <li><Link :href="route('admin.college.index')" class="t-menu">Department</Link></li>
                    </ul>
                </li>

                <li @click="processClick('Attendance')">
                    <a href="#" class="t-menu"> Attendance <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenAttendance">
                        <li><Link :href="route('admin.attendance.index')" class="t-menu">View Attendance</Link></li>
                    </ul>
                </li>

            </ul>

        </div>
    </nav>
</template>


<!-- <template>
    <nav class="h-100 mainside">
        <div class="">
            <div class="menu-title">Admin</div>
            <ul>
                <li><Link :href="route('admin.dashboard')" class="t-menu">Dashboard</Link></li>
                
                <li><Link :href="route('admin.roles.index')" class="t-menu">Role</Link></li>

                <li @click="processClick('Staff')">
                    <a href="#" class="t-menu"> Staffs <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenStaff">
                        <li><Link :href="route('admin.staffs.index')" class="t-menu">New Staff</Link></li>
                    </ul>
                </li>

                <li @click="processClick('Student')">
                    <a href="#" class="t-menu"> Students <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenStudent">
                        <li><Link :href="route('admin.students.index')" class="t-menu">New Student</Link></li>
                        <li><Link :href="route('admin.students.create')" class="t-menu">Upload Student</Link></li>
                        <li><Link :href="route('admin.students.updatelevel')" class="t-menu">Update Students</Link></li>
                    </ul>
                </li>
                
                <li @click="processClick('asess')">
                    <a href="#" class="t-menu"> Academic Session <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenAcadSession">
                        <li><Link :href="route('admin.acadsession.index')" class="t-menu">Academic Session</Link></li>
                    </ul>
                </li>

                <li @click="processClick('College')">
                    <a href="#" class="t-menu"> College <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenCollege">
                        <li><Link :href="route('admin.college.index')" class="t-menu">College</Link></li>
                    </ul>
                </li>

                <li @click="processClick('Department')">
                    <a href="#" class="t-menu"> Department <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenDepartment">
                        <li><Link :href="route('admin.college.index')" class="t-menu">Department</Link></li>
                    </ul>
                </li>

                <li @click="processClick('Attendance')">
                    <a href="#" class="t-menu"> Attendance <span ><i class="bx bxs-chevron-up"></i></span></a>
                    <ul v-if="isHiddenAttendance">
                        <li><Link :href="route('admin.attendance.index')" class="t-menu">View Attendance</Link></li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</template> -->

<script>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    export default {
        components: {
            Head,
            Link,
        },
        data() {
            return { 
                isHiddenStaff: false, 
                isHiddenRole: false,
                isHiddenStudent: false,
                isHiddenAcadSession: false,
                isHiddenAttendance: false,
                isHiddenCollege: false,
                isHiddenDepartment: false,
            }
        },

        methods: {  
          processClick(value) { 
              if(value == 'Staff'){
                  this.isHiddenStaff = !this.isHiddenStaff
              } 

              if(value == 'Roles'){
                  this.isHiddenRole = !this.isHiddenRole
              } 

              if(value == 'Student'){
                  this.isHiddenStudent = !this.isHiddenStudent
              }

              if(value == 'asess'){
                  this.isHiddenAcadSession = !this.isHiddenAcadSession
              }

              if(value == 'Attendance'){
                  this.isHiddenAttendance = !this.isHiddenAttendance
              }

              if(value == 'College'){
                  this.isHiddenCollege = !this.isHiddenCollege
              }

              if(value == 'Department'){
                  this.isHiddenDepartment = !this.isHiddenDepartment
              }
            //alert(value);  
          }  
        }
    }
</script>

<style lang="scss" scoped>

</style>