<template>
    <staff-layout>
        <template #page-title-box>
            <div class="page-title-box">
                <h4>View Classes Attendance</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">HOD</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Lecturer's Classes</li>
                </ol>
            </div>
        </template>

        <div class="d-flex justify-content-end">
            <div class="dept">Department of {{ $page.props.user.department.name }}</div>
        </div>

        <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
            <span>{{ $page.props.success }}</span>
        </p>


        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">View Lecture Class</h4>
                        <p class="card-title-desc">Classes Created by lecturers in your Department</p>

                        <table class="table table-sm table-bordered">
                            <thead>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Course Level</th>
                                <th>Lecturer in Charge</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                 <tr v-for="(coursecode, index) in allcourses" :key="index">
                                     <td>{{ coursecode.coursecode }}</td>
                                     <td>{{ coursecode.coursename }}</td>
                                     <td>{{ coursecode.courselevel }}</td>
                                     <td>
                                        <div class="staffallocate" v-for="(staff, index) in coursecode.users" :key="index">
                                           <span>{{ staff.title }} {{ staff.name }}</span>
                                        </div>
                                     </td>
                                     <td></td>
                                 </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>

         <br> <br>


    </staff-layout>
</template>

<script>
import StaffLayout from '@/Layouts/Staff/StaffLayout'
import { defineComponent } from 'vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
    export default {
        props:['allcourses'],
        components: {
            Head,
            StaffLayout,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
        },
    }
</script>

<style lang="scss" scoped>
    .dept{
        font-weight: 900;
        margin: 0 0 10px 5px;
    }

    .dept:hover{
        color: #c72424;
    }

    .staffallocate{
        display: inline-block;
        margin-left: 10px;
    }

    .std-course{
        display: inline-block;
        width: 30%;
        border-bottom: 1px solid #000000;
    }

    .std-class{
        display: inline-block;
        width: 70%;
        // flex-grow: 3;
        // background-color: #c72424;
    }

    .std-class div{
        border-bottom: 1px solid #000000;
    }
</style>