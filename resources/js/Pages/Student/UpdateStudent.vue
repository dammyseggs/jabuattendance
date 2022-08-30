<template>
    <admin-layout title="Update Student">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Update Student's Level</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Admin</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Update Student</li>
                </ol>
            </div>
        </template>

        <div class="row" v-if="studentsavailable">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <form @submit.prevent="updateStd">
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
                                    <tr v-for="(student, index) in allstudents" :key="index">
                                        <td><input type="checkbox" :value="student.id" checked :id="student.id" v-model="form.captureStudent"></td>
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

                                    Update Student(s) Level
                                </jet-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <br><br>

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
                                <jet-label for="csession" class="col-md-2 col-form-label form-label" value="Academic Session" />
                                <div class="col-md-10">    
                                    <select class="form-control" id="csession" name="" v-model="form.csession">
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
            <!-- end col -->
        </div>

        <br><br>

        
       



    </admin-layout>
</template>

<script>
import AdminLayout from '@/Layouts/Admin/AdminLayout'
import { defineComponent } from 'vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
    export default {
        props:['acadsessions', 'studentsavailable', 'allstudents'],
        components: {
            Head,
            AdminLayout,
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
                    stdlevel: '',
                    college: 0,
                    department: 0,
                    csession: '',
                    colleges: [],
                    departments: [],
                    captureStudent: [],
                    from: 'admin',
                })
            }
        },
        methods: {
            async submit() {
                this.form.post(this.route('admin.students.getStudentLevel'), {
                    onFinish: () => this.form.reset(),
                })
            },

            async updateStd() {
                this.form.patch(this.route('admin.students.updateStudent.store'), {
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

</style>