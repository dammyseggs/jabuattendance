<template>
    <staff-layout>
        <template #page-title-box>
            <div class="page-title-box">
                <h4>View Student</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Lecturer</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">View Student</li>
                </ol>
            </div>
        </template>

        <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
            <span>{{ $page.props.success }}</span>
        </p>

        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Your Courses</h4>
                        <p class="card-title-desc">Courses allocated to you</p>
                        <form @submit.prevent="searchStds">
                            <div class="mb-3 row">
                                <jet-label for="level" class="col-md-2 col-form-label form-label" value="Select Level" />
                                <div class="col-md-10">    
                                    <select class="form-control" id="level" v-model="form.level">
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="400">400</option>
                                        <option value="500">500</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <jet-label for="college" class="col-md-2 col-form-label form-label" value="College" />
                                <div class="col-md-10"> 
                                    <select class='form-control' v-model='form.college' @change='getDepartments()'>
                                        <option value='0' >Select College</option>
                                        <option v-for='data in form.colleges' :value='data.id' :key='data.id'>{{ data.name }}</option>
                                    </select>  
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="department" class="col-md-2 col-form-label form-label" value="Department" />
                                <div class="col-md-10">  
                                    <select class='form-control' v-model='form.department'>
                                        <option value='0' >Select Department</option>
                                        <option v-for='data in form.departments' :value='data.id' :key='data.id'>{{ data.name }}</option>
                                    </select>  
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <jet-label for="acadsession" class="col-md-2 col-form-label form-label" value="Select Academic Session" />
                                <div class="col-md-10">    
                                    <select class="form-control" id="acadsession" v-model="form.acadsession">
                                        <option :value="acadsession.id" v-for="(acadsession, id) in acadsessions" :key="id">{{ acadsession.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                Get Students
                            </jet-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <br><br>

        

         <div class="row" v-if="students">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Students</h4>
                        <p class="card-title-desc">Available Student(s)</p>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Matric No</th>
                                        <th>Surname</th>
                                        <th>Othername</th>
                                        <th>level</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student, index) in students" :key="index">
                                        <td>{{student.matric_no}}</td>
                                        <td>{{student.name}}</td>
                                        <td>{{student.othername}}</td>
                                        <td>{{student.stdlevel}}</td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-else>
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">No Available Student(s)</h4>
                        <p class="card-title-desc">Available Student(s)</p>
                        <div class="nocourse bg-danger p-2 text-center fw-bolder">No Student Available</div>
                    </div>
                </div>
            </div>
        </div>

        <br><br>
    </staff-layout>
</template>

<script>
import StaffLayout from '@/Layouts/Staff/StaffLayout'
import { defineComponent } from 'vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
// import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
    export default {
        props:['acadsessions', 'students'],
        components: {
            Head,
            JetLabel,
            JetInput,
            JetButton,
            StaffLayout,
            JetValidationErrors,
            Link,
        },
        data() {
            return {
                form: this.$inertia.form({
                    level: '',
                    acadsession: 0,
                    college: 0,
                    department: 0,
                    colleges: [],
                    departments: [],
                })
            }
        },
        methods: {
            searchStds() {
                this.form.post(this.route('staff.searchstudent2'), {
                    onFinish: () => this.form.reset(),
                })
            },   
            getColleges: function(){
                axios.get('/get_all_college')
                    .then(function (response) {
                        this.form.colleges = response.data;
                    }.bind(this));
            },
            getDepartments: function() {
                axios({
                    method: 'get',
                    url: '/get_dept',
                    params: {
                        college_id: this.form.college
                    }
                })
                .then(res => this.processDept(res))
                .catch(error => console.log(error));
            },

            processDept: function(res){                
                this.form.departments = res.data;
            }
        },
        created: function(){
            this.getColleges()
        }
    }
</script>

<style lang="scss" scoped>

</style>