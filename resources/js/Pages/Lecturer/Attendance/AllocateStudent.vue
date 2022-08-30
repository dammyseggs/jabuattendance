<template>
    <staff-layout title="Allocate Student">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Student Allocation</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Lecturer</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Student Allocation</li>
                </ol>
            </div>
        </template>      


              
        <div class="sessionoff" v-if="!csession">
                Whoops! Current Academic Session not Active
        </div>
        

        <div class="row" v-if="lectuexist">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                            <h4 class="card-title">Select Lecture Class</h4>
                            <div class="mb-3 row">
                                <jet-label for="department" class="col-md-2 col-form-label form-label" value="Select Lecture Class" />
                                <div class="col-md-10">    
                                    <select class="form-control" id="department" @change="processSelect($event)" v-model="form.thelectu">
                                        <option :value="thelectu.id" v-for="(thelectu, id) in lectu" :key="id">{{ thelectu.name }}</option>
                                    </select>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <br />
        
        <div class="row" v-if="lectuexist">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <h4 class="card-title">Select Student</h4>
                            <p><jet-validation-errors class="mb-3" /></p>
                            <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
                                <span>{{ $page.props.success }}</span>
                            </p>

                            <div class="mb-3 row">
                                <jet-label for="stdlevel" class="col-md-2 col-form-label form-label" value="Student's Level" />
                                <div class="col-md-10">
                                    <select id="stdlevel" class="form-control" v-model="form.stdlevel">
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
                                    <select class='form-control' id="department" v-model='form.department'>
                                        <option value='0' >Select Department</option>
                                        <option v-for='data in form.departments' :value='data.id' :key='data.id'>{{ data.name }}</option>
                                    </select>

                                </div>
                            </div>

                            <div v-if="csession">
                                <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    Load Student
                                </jet-button>
                            </div>

                            <div v-else>
                                 <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="true">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    Load Student
                                </jet-button>
                            </div>
                        </form>   
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>

        <br />

        <div class="row" v-if="stdexist">  
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <form @submit.prevent="allocateStd">
                            <h4 class="card-title">Available Student(s)</h4>
                            <p class="card-title-desc">Available Student(s)</p>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Matric No</th>
                                        <th>Surname</th>
                                        <th>Othername</th>
                                        <th>level</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student, index) in availableStd" :key="index">
                                        <td><input type="checkbox" :value="student.id" :id="student.id" v-model="form.captureStudent"></td>
                                        <td>{{student.matric_no}}</td>
                                        <td>{{student.name}}</td>
                                        <td>{{student.othername}}</td>
                                        <td>{{student.stdlevel}}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div>
                                <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    Allocate Student
                                </jet-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row" v-else>  
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <div class="nocourse bg-danger p-2 text-center fw-bolder">No Student available yet</div>
                    </div>
                </div>
            </div>
        </div>

        <br />
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
        props:['csession', 'stdexist', 'availableStd', 'lectuexist', 'lectu',],
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
        data() {
            return {
                form: this.$inertia.form({
                    thelectu: '',
                    stdcollege: '',
                    stdlevel: '',
                    college: '',
                    department: '',
                    captureStudent: [],
                }),

                classname: '',


            }
        },
        methods: {
            async submit() {
                this.form.post(this.route('staff.allocatestudent.searchStd'), {
                    onFinish: () => this.form.reset(),
                })
            },

            async allocateStd() {
                this.form.post(this.route('staff.allocatestudent.allocateStd'), {
                    onFinish: () => this.form.reset(),
                })
            },

            processSelect(event){
                this.form.post(this.route('staff.allocatestudent.get'), {
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
    .nocourse{
        text-align: center;
        font-weight: 900;
        color: #ffffff;
    }

    .sessionoff{
        background-color: #ff0000;
        text-align: center;
        font-weight: 600;
        margin-bottom: 10px;
        border-radius: 15px;
    }
</style>