<template>
    <staff-layout title="Mark Attendance">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Mark Attendance</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Lecturer</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Mark Attendance</li>
                </ol>
            </div>
        </template>

        <div class="sessionoff" v-if="!currentses">
                Whoops! Current Academic Session not Active
        </div>

        
        <div class="row" v-if="lectuexist">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Select Lecture Class</h4>
                        <form @submit.prevent="loadClass">
                            <div class="mb-3 row">
                                <jet-label for="department" class="col-md-2 col-form-label form-label" value="Select Lecture Class" />
                                <div class="col-md-10">    
                                    <select class="form-control" id="department" @change="processSelect($event)" v-model="form.theclass" disabled v-if="!currentses">
                                        <option :value="thelectu.id" v-for="(thelectu, id) in lectu" :key="id">{{ thelectu.name }}</option>
                                    </select>

                                     <select class="form-control" id="department" @change="processSelect($event)" v-model="form.theclass" v-else>
                                        <option :value="thelectu.id" v-for="(thelectu, id) in lectu" :key="id">{{ thelectu.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <br />
        <br />
       
        <div v-if="stdexist">  
          <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <!-- <form @submit.prevent="markStdAttendance"> -->
                            <h4 class="card-title">Available Student(s) in the lecture class</h4>
                            <p class="card-title-desc">Available Student(s) in the lecture class</p>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Matric No</th>
                                        <th>Surname</th>
                                        <th>Othername</th>
                                        <th>level</th>
                                        <th>Department</th>
                                        <th>Attendance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student, index) in students" :key="index">
                                        <td>{{student.matric_no}}</td>
                                        <td>{{student.name}}</td>
                                        <td>{{student.othername}}</td>
                                        <td>{{student.stdlevel}}</td>
                                        <td>{{student.department.name}}</td>
                                        <td><input type="checkbox" :value="student.id" :id="student.id" v-model="form.captureStudent"></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div>
                                <button type="button" class="btn btn-primary" @click="markStdAttendance" data-bs-toggle="modal" data-bs-target="#exampleModal">Mark Attendance</button>
                            </div>

                            <!-- <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                Mark Attendance
                            </jet-button> -->
                        <!-- </form> -->
                    </div>
                </div>
            </div>
          </div>
            <br><br>
          <div class="row">
                <div class="col-12">
                    <div class="card myshadow">
                        <div class="card-body">
                            <h4 class="card-title mb-4">{{ lectu[0].name }}</h4>

                            <div class="row text-center mt-4">
                                <div class="col-4">
                                    <h5 class="mb-0 font-size-20 text-truncate">Total Students</h5>
                                    <p class="text-muted text-truncate">{{ students.length }}</p>
                                </div>
                                <div class="col-4">
                                    <h5 class="mb-0 font-size-20 text-truncate">Present</h5>
                                    <p class="text-muted text-truncate">{{ form.captureStudent.length }}</p>
                                </div>
                                <div class="col-4">
                                    <h5 class="mb-0 font-size-20 text-truncate">Absent</h5>
                                    <p class="text-muted text-truncate">{{ students.length - form.captureStudent.length }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
        </div>

        <div class="row" v-else>
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Available Student(s) in the lecture class</h4>
                        <p class="card-title-desc">Available Student(s) in the lecture class</p>
                        <div class="nocourse bg-danger p-2 text-center fw-bolder">No Student available for this class</div>
                    </div>
                </div>
            </div>
        </div>

        <br />
        <br />

        <Modal  v-show="isModalVisible" @close="closeModal" @yes="submitModal" >
            <template v-slot:body>
                <h6>Are you sure you want to submit marked attendance? </h6>
            </template>
        </Modal>

        <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-body">
                    Are you sure you want to submit attandance?
                </div>
                <div class="modal-footer">
                    <form @submit.prevent="markStdAttendance">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                        <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        Mark Attendance
                    </jet-button>
                    </form>
                </div>
                </div>
            </div>
        </div> -->


        <!-- <jet-confirmation-modal :show="confirmingUserDeletion" @close="confirmingUserDeletion = false">
            <template #title>
                Delete Account
            </template>

            <template #content>
                Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted.
            </template>

            <template #footer>
                <jet-secondary-button @click.native="confirmingUserDeletion = false">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="deleteTeam" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete Account
                </jet-danger-button>
            </template>
        </jet-confirmation-modal> -->



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
        props:['lectu', 'lectuexist', 'stdexist', 'students', 'currentses'],
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
                    theclass: '',
                    captureStudent: [],
                }),
                isModalVisible: false,

            }
        },
        methods: {
            processSelect(event){
                // alert(event.target.value);
                this.form.post(this.route('staff.loadattendance.loadstudent', this.form.theclass), {
                    onFinish: () => this.form.reset(),
                })
            },
            async markStdAttendance() {
                this.showModal();                
            },
            submitModal() {
                this.form.post(this.route('staff.student.markattendance'), {
                    onFinish: () => this.form.reset(),
                })
            },

            showModal() {
                this.isModalVisible = true;
            },
            showSetModal() {
                this.issetModalVisible = true;
            },
            closeModal() {
                this.isModalVisible = false;
                this.issetModalVisible = false;
            },
        },
        computed: {
            getAbsent() {
                return this.students[0]
                // return this.form.captureStudent.length
            },
        }
    }
</script>

<style lang="scss" scoped>
.m-body{
    font-weight: 700;
}
.sessionoff{
        background-color: #ff0000;
        text-align: center;
        font-weight: 600;
        margin-bottom: 10px;
        border-radius: 15px;
    }
</style>