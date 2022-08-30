<template>
    <staff-layout>
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Course Allocation</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Lecturer</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Course Allocation</li>
                </ol>
            </div>
        </template>

        <div class="d-flex justify-content-end">
            <div class="dept">Department of {{ $page.props.user.department.name }}</div>
        </div>

        <!-- <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
            <span>{{ $page.props.success }}</span>
        </p> -->

        <div class="row">

            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Allocate Course for Lecturer</h4>
                        <p class="card-title-desc">Select Lecturer</p>
                        <div class="text-center text-success bg1 fw-bold" v-if="$page.props.success">
                            <span>{{ $page.props.success }}</span>
                        </div>

                        <div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Name</th>
                                        <th>Course(s)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(staff, index) in allstaff" :key="index">
                                        <td>{{ staff.title }}</td>
                                        <td>{{ staff.name }} {{ staff.othername }}</td>
                                        <td>
                                            <span class="callocate" v-for="(allcourse, index) in staff.courses" :key="index">
                                               {{ allcourse.coursecode }}
                                            </span>
                                        </td>
                                        <td>
                                            <!-- <Link :href="route('staff.course.allocate.reset', staff.id)" class="btn btn-sm btn-primary edit-btn">Reset</Link> -->
                                            <form @submit.prevent="resetAllocation(staff.id)">
                                                <button class="btn btn-sm btn-primary edit-btn">Reset</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- <div class="mb-3 row">
                            <jet-label for="lecturer" class="col-md-2 col-form-label form-label" value="Select Lecturer" />
                            <div class="col-md-10">    
                                <select class="form-control" id="lecturer" @change="onChange($event)" v-model="form.lecturer" >
                                <option value="0">Select Lecturer</option>
                                    <option :value="staff.id" v-for="(staff, id) in allstaff" :key="id">{{ staff.title }}  {{ staff.othername }} {{ staff.name }} </option>
                                </select>
                            </div>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <h4 class="card-title">Allocate Course for Lecturer </h4>
                            <p class="card-title-desc">Allocate Course(s)</p>
                            <jet-validation-errors class="mb-3" />

                            <div class="mb-3 row">
                                <jet-label for="lecturer" class="col-md-2 col-form-label form-label" value="Select Lecturer" />
                                <div class="col-md-10">    
                                    <select class="form-control" id="lecturer" v-model="form.lecturer" >
                                        <!-- <option value="0">Select Lecturer</option> -->
                                        <option :value="staff.id" v-for="(staff, id) in allstaff" :key="id">{{ staff.title }}  {{ staff.othername }} {{ staff.name }} </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="courses" class="col-md-2 col-form-label form-label" value="Select Course(s)" />
                                <div class="col-md-10">    
                                    <select class="form-control" id="courses" v-model="form.courses" multiple>
                                        <option :value="allcourse.id" v-for="(allcourse, id) in allcourses" :key="id">{{ allcourse.coursecode }}  {{ allcourse.coursename }}  Level:{{ allcourse.courselevel }} </option>
                                    </select>
                                    <div class="cselected" v-if="form.courses.length">{{ form.courses.length }} Courses Selected</div>
                                </div>
                            </div>

                            <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    Allocate Course
                            </jet-button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <br> <br>

        <Modal  v-show="isModalResetVisible" @close="closeModal" @yes="submitReset" >
            <template v-slot:body>
                <h6>Are you sure you want to reset the course allocation? </h6>
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
        props:['allstaff', 'allcourses'],
        components: {
            Head,
            StaffLayout,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Modal,
            Link,
        },
        data() {
            return {
                form: this.$inertia.form({
                    lecturer: '',
                    courses: [],
                }),
                staffids: 0,
                isModalResetVisible: false,
                isShow:false,
            }
        },
        methods: {
            onChange(event) {
                // console.log(event.target.value);
                if(event.target.value == 0){
                    this.isShow = false;
                    this.form.courses.length = 0;
                }else{
                    this.isShow = true;
                }
                
            },
            submit() {
                this.form.post(this.route('staff.course.allocate.store'), {
                    onFinish: () => this.form.reset(),
                })
            },
            showModal() {
                this.isModalResetVisible = true;
            },
            closeModal() {
                this.isModalResetVisible = false;
            },
            resetAllocation(id) {
                this.staffids = id;
                this.showModal();
            },
            submitReset() {
                this.form.get(this.route('staff.course.allocate.reset', this.staffids), {
                    onFinish: () => this.form.reset(),
                })
                this.closeModal();
            }
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

    .cselected{
        font-weight: 700;
        color: #c72424;
        margin: 10px 0 0 5px;
    }

    .callocate{
        display: inline-block;
        font-weight: 600;
        margin: 0 10px 0 0;
    }

    .callocate:hover{
        font-weight: 800;
        color: #c72424;
        text-decoration: underline;
    }

</style>