<template>
    <staff-layout title="New Student">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>New Student</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Lecturer</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">New Student</li>
                </ol>
            </div>
        </template>

        <div class="sessionoff" v-if="!csessionexist">
                Whoops! Current Academic Session not Active
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                      <form @submit.prevent="submit">
                        <h4 class="card-title">New Student</h4>
                        <p class="card-title-desc">Register Student.</p>
                        <p><jet-validation-errors class="mb-3" /></p>
                        <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
                            <span>{{ $page.props.success }}</span>
                        </p>

                        <div class="mb-3 row">
                            <jet-label for="matric_no" class="col-md-2 col-form-label form-label" value="Matric No" />
                            <div class="col-md-10">
                                <jet-input class="form-control" id="matric_no" type="text" v-model="form.matric_no" required autofocus placeholder="Enter Matric Number" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                                <jet-label for="name" class="col-md-2 col-form-label form-label" value="Surname" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="name" type="text" v-model="form.name"  placeholder="Enter Surname" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="othername" class="col-md-2 col-form-label form-label" value="Othername" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="othername" type="text" v-model="form.othername"  placeholder="Enter Othername" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <jet-label for="stdlevel" class="col-md-2 col-form-label form-label" value="Student level" />
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
                                    <select class='form-control' v-model='form.department'>
                                        <option value='0' >Select Department</option>
                                        <option v-for='data in form.departments' :value='data.id' :key='data.id'>{{ data.name }}</option>
                                    </select>  
                                </div>
                            </div>

                            <div v-if="csessionexist">
                                <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    Register Student
                                </jet-button>
                            </div>
                            <div v-else>
                                <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="true">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    Register Student
                                </jet-button>
                            </div>

                            


                      </form>
                    </div>
                </div>
            </div>
            
        </div> 
        <br />
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
import axios from 'axios'
    export default {
        props:['thedept', 'currentsession', 'csessionexist'],
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
                    matric_no: '',
                    name: '',
                    othername: '',
                    stdlevel: '',
                    college: 0,
                    department: 0,
                    description: '',
                    colleges: [],
                    departments: [],
                    from: 'staff',                    
                }),

                selectedDepartments: []

            }
        },
        methods: {
            submit() {
                this.form.post(this.route('admin.students.store'), {
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
                // axios({
                //     method: 'get',
                //     url: '/get_dept',
                //     params: {
                //         college_id: this.form.college
                //     }
                // })
                // .then(function(response){
                //     this.selectedDepartments = response.data;
                // }).bind(this)
                // .catch(error => console.log(error));

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
    .sessionoff{
        background-color: #ff0000;
        text-align: center;
        font-weight: 600;
        margin-bottom: 10px;
        border-radius: 15px;
    }
</style>