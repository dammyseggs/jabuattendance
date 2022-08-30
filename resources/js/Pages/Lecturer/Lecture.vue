<template>
    <staff-layout title="New Class">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Lecture Class Management</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Lecturer</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Lecture Class</li>
                </ol>
            </div>
        </template>

        <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
            <span>{{ $page.props.success }}</span>
        </p>

        <div class="sessionoff" v-if="!currentexists">
             Whoops! Current Academic Session not Active
        </div>

        <div class="d-flex justify-content-end" v-if="currentexists">
            <div class="dept">Current Session : {{ currentses.name }}</div>
        </div>


        <div class="row" v-if="courexist">
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
                        <div class="nocourse bg-danger p-2">You cannot create class because no course allocated yet</div>
                    </div>
                </div>
            </div>
        </div>

        <br/>
        <br/>
 
        <div class="row" v-if="lectexist">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Class Created</h4>
                        <p class="card-title-desc">Lecture Class</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Lecture Name </th>
                                    <th>Course</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(tlect, index) in yourlectures" :key="index">
                                    <td>{{tlect.name}}</td>
                                    <td>{{ tlect.course.coursecode }} {{ tlect.course.coursename }} ({{ tlect.course.courselevel }}L)</td>
                                    <td><Link :href="route('staff.newlecture.show', tlect.id)" class="btn btn-sm btn-primary edit-btn">Edit</Link></td>
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
                        <h4 class="card-title">Your Lecture Class</h4>
                        <p class="card-title-desc">Lecture Class</p>
                        <div class="nocourse bg-danger p-2">No Lecture Class Created Yet for this Academic Session</div>
                    </div>
                </div>
            </div>
        </div>
                
        <br/>
        <br/>

        <div class="row" v-if="courexist">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <h4 class="card-title">New Lecture Class</h4>
                            <p class="card-title-desc">Lecture Class Registration</p>
                            <p><jet-validation-errors class="mb-3" /></p>
                            
                            <div class="mb-3 row">
                                <jet-label for="name" class="col-md-2 col-form-label form-label" value="Lecture Name" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="name" type="text" v-model="form.name" required placeholder="Enter Lecture Name" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <jet-label for="course" class="col-md-2 col-form-label form-label" value="Course" />
                                <div class="col-md-10">    
                                    <select class="form-control" id="course" name="" v-model="form.course">
                                        <option :value="thecourse.id" v-for="(thecourse, id) in yourcourses" :key="id">{{ thecourse.coursename }} {{ thecourse.coursecode }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <jet-label for="addinfo" class="col-md-2 col-form-label form-label" value="Additional Infomation" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="addinfo" type="text" v-model="form.addinfo" placeholder="Additional Infomation" />
                                </div>
                            </div>

                            <div v-if="currentexists">
                                <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    Register Lecture Class
                                </jet-button>
                            </div>
                            <div v-else>
                                 <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="true">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    Register Lecture Class
                                </jet-button>
                            </div>
                            
                           

                        </form>   
                    </div>
                </div>
            </div>
            
        </div>
        <br/>
        <br/> 
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
        props:['yourcourses', 'courexist', 'yourlectures', 'lectexist', 'currentexists', 'currentses'],
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
                    name: '',
                    course: '',
                    addinfo: '',
                })
            }
        },
        methods: {
            async submit() {
                this.form.post(this.route('staff.newlecture.store'), {
                    onFinish: () => this.form.reset(),
                })
            },
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

    .csession{
        width: 250px;
        background-color: #f6f2f2;
        color: #ff0000;
        text-align: center;
        font-weight: 600;
        margin-bottom: 10px;
        border-radius: 15px;
    }
</style>