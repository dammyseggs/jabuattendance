<template>
    <staff-layout title="New Course">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Lecturer Management</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Lecturer</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">New Lecturer</li>
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
                        <h4 class="card-title">Lecturer List</h4>
                        <p class="card-title-desc">List of Lecturer in the Department</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Staffid</th>
                                    <th>Title</th>
                                    <th>Surname</th>
                                    <th>Othername</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(thelecturer, index) in thelecturers" :key="index">
                                    <td>{{thelecturer.staffid}}</td>
                                     <td>{{thelecturer.title}}</td>
                                    <td>{{thelecturer.name}}</td>
                                    <td>{{thelecturer.othername}}</td>
                                    <td>{{thelecturer.email}}</td>
                                    <td>
                                        <Link :href="route('staff.lecturer.show', thelecturer.id)" class="btn btn-sm btn-primary edit-btn">Edit</Link>
                                        <Link :href="route('staff.lecturer.delete', thelecturer.id)" class="btn btn-sm btn-danger">Delete</Link>
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
                            <h4 class="card-title">Add New Lecturer</h4>
                            <p class="card-title-desc">Lecturer Registration</p>
                            <p><jet-validation-errors class="mb-3" /></p> 
                            
                            <div class="mb-3 row">
                                <jet-label for="staffid" class="col-md-2 col-form-label form-label" value="Staff ID" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="staffid" type="text" v-model="form.staffid" required placeholder="Enter Staff ID" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <jet-label for="title" class="col-md-2 col-form-label form-label" value="Title" />
                                <div class="col-md-10">
                                    <select id="title" class="form-control" v-model="form.title">
                                        <option value="Eng">Eng</option>
                                        <option value="Dr">Dr</option>
                                        <option value="Mr">Mr</option>                                          
                                        <option value="Mrs">Mrs</option>                                        
                                        <option value="Miss">Miss</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Prof">Prof</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <jet-label for="name" class="col-md-2 col-form-label form-label" value="Surname" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="name" type="text" v-model="form.name" placeholder="Enter Surname" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="othername" class="col-md-2 col-form-label form-label" value="Othername" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="othername" type="text" v-model="form.othername" placeholder="Enter Othername" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="department" class="col-md-2 col-form-label form-label" value="Department" />
                                <div class="col-md-10">    
                                    <select class='form-control' v-model='form.department'>
                                        <option :value='$page.props.user.department.id' >{{ $page.props.user.department.name }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="email" class="col-md-2 col-form-label form-label" value="Email" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="email" type="email" v-model="form.email" placeholder="Enter email" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="password" class="col-md-2 col-form-label form-label" value="Password" />
                                <div class="col-md-10">
                                    <jet-input id="password" type="password" v-model="form.password" required autocomplete="new-password" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="password_confirmation" class="col-md-2 col-form-label form-label" value="Confirm Password" />
                                <div class="col-md-10">
                                    <jet-input id="password_confirmation" type="password" v-model="form.password_confirmation" required autocomplete="new-password" />
                                </div>
                            </div>
                            
                            <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                Register Leturer
                            </jet-button>

                        </form> 
                    </div>
                </div>
            </div>
        </div> 
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
        props:['thelecturers',],
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
                    staffid: '',
                    title: '',
                    name: '',
                    othername: '',
                    department: 0,
                    email: '',
                    password: '',
                    password_confirmation: '',
                }),

            }
        },
        methods: {
            submit() {
                this.form.post(this.route('staff.register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            },
        },  

        
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