<template>
    <staff-layout title="New Course">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Course Management</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Lecturer</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">New Course</li>
                </ol>
            </div>
        </template>

        <div class="d-flex justify-content-end">
            <div class="dept">Department of {{ $page.props.user.department.name }}</div>
        </div>
        

        <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
            <span>{{ $page.props.success }}</span>
        </p>

        <!-- <div class="row" v-if="courexist">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Your Courses</h4>
                        <p class="card-title-desc">Courses allocated to you</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                    <th>Course level</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(thecourse, index) in yourcourses" :key="index">
                                    <td>{{thecourse.coursecode}}</td>
                                     <td>{{thecourse.coursename}}</td>
                                    <td>{{thecourse.courselevel}}</td>
                                    <td>{{thecourse.description}}</td>
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
                        <h4 class="card-title">Your Courses</h4>
                        <p class="card-title-desc">Courses allocated to you</p>
                        <div class="nocourse bg-danger p-2">No Course Allocated yet</div>
                    </div>
                </div>
            </div>
        </div>
-->
        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Available Courses</h4>
                        <p class="card-title-desc">Available Courses in the Department</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                    <th>Course level</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(deptcourse, index) in deptcourses" :key="index">
                                    <td>{{deptcourse.coursecode}}</td>
                                     <td>{{deptcourse.coursename}}</td>
                                    <td>{{deptcourse.courselevel}}</td>
                                    <td>{{deptcourse.description}}</td>
                                    <td>
                                        <Link :href="route('staff.course.show', deptcourse.id)" class="btn btn-sm btn-primary edit-btn">Edit</Link>
                                        <button @click="showModal(deptcourse.id)" class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br/>
        <br/>


        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <h4 class="card-title">New Course</h4>
                            <p class="card-title-desc">Course Registration</p>
                            <p><jet-validation-errors class="mb-3" /></p> 
                            
                            <div class="mb-3 row">
                                <jet-label for="coursename" class="col-md-2 col-form-label form-label" value="Course Name" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="coursename" type="text" v-model="form.coursename" required placeholder="Enter Course Name" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="coursecode" class="col-md-2 col-form-label form-label" value="Course Code" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="coursecode" type="text" v-model="form.coursecode" placeholder="Enter Course Code" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="courselevel" class="col-md-2 col-form-label form-label" value="Course Level" />
                                <div class="col-md-10">
                                    <select id="courselevel" class="form-control" v-model="form.courselevel">
                                        <option value="100">100</option>                                          
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="400">400</option>
                                        <option value="500">500</option>
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="mb-3 row">
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
                            </div> -->
                            <div class="mb-3 row">
                                <jet-label for="department" class="col-md-2 col-form-label form-label" value="Department" />
                                <div class="col-md-10">    
                                    <select class='form-control' v-model='form.department'>
                                        <option :value='$page.props.user.department.id' >{{ $page.props.user.department.name }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="description" class="col-md-2 col-form-label form-label" value="Description" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="description" type="text" v-model="form.description" placeholder="Description" />
                                </div>
                            </div>
                            
                            <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                Register Course
                            </jet-button>

                        </form>   
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <br/>
        <Modal v-show="isModalDeleteVisible" @close="closeModal" @yes="submitDeleteModal" >
            <template v-slot:body>
                <h6>Are you sure you want to delete to departmental course? </h6>
            </template>
        </Modal>

    </staff-layout>
</template>

<script>
import StaffLayout from '@/Layouts/Staff/StaffLayout'
import Modal from '@/Layouts/Components/Modal'
import { defineComponent } from 'vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
    export default {
        props:['deptcourses',],
        components: {
            Head,
            StaffLayout,
            Modal,
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
                    coursename: '',
                    coursecode: '',
                    courselevel: '',
                    college: 0,
                    department: 0,
                    description: '',
                    colleges: [],
                    departments: [],
                }),
                deletedid: 0,
                isModalDeleteVisible:false,

            }
        },
        methods: {
            showModal(id) {
                this.deletedid = id;
                this.isModalDeleteVisible = true;
            },
            closeModal() {
                this.isModalDeleteVisible = false;
            },
            submitDeleteModal() {
                this.form.delete(this.route('staff.course.delete', this.deletedid), {
                    onFinish: () => this.form.reset(),
                }),
                this.closeModal();      
                
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
            },

            async submit() {
                this.form.post(this.route('staff.newcourse.store'), {
                    onFinish: () => this.form.reset(),
                })
            },
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
    
    .edit-btn{
        margin-right: 5px;
    }
</style>