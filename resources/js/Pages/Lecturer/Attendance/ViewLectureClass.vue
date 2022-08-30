<template>
    <staff-layout title="View Lecture Class">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>View Lecture Class</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Lecturer</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">View Lecture Class</li>
                </ol>
            </div>
        </template>

        <div class="row" v-if="lectuexist">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Select Lecture Class</h4>
                        <form @submit.prevent="loadClass">
                            <div class="mb-3 row">
                                <jet-label for="department" class="col-md-2 col-form-label form-label" value="Select Lecture Class" />
                                <div class="col-md-10">    
                                    <select class="form-control" id="department" @change="processSelect($event)" v-model="form.theclass">
                                        <option :value="thelectu.id" v-for="(thelectu, id) in lectu" :key="id">{{ thelectu.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="mb-3 row  offset-3">
                                <div class="col-md-5">
                                <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    Load Lecture Class
                                </jet-button>
                                </div>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-else>
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Your Courses</h4>
                        <p class="card-title-desc">Courses created by you</p>
                        <div class="nocourse bg-danger p-2 text-center fw-bolder">No Course Allocated yet</div>
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
                        <form @submit.prevent="allocateStd">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student, index) in students" :key="index">
                                        <td>{{student.matric_no}}</td>
                                        <td>{{student.name}}</td>
                                        <td>{{student.othername}}</td>
                                        <td>{{student.stdlevel}}</td>
                                        <td>{{student.department.name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
          </div>
           <br />
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
                                <!-- <div class="col-4">
                                    <h5 class="mb-0 font-size-20 text-truncate">Present</h5>
                                    <p class="text-muted text-truncate">{{ form.captureStudent.length }}</p>
                                </div>
                                <div class="col-4">
                                    <h5 class="mb-0 font-size-20 text-truncate">Absent</h5>
                                    <p class="text-muted text-truncate">{{ students.length - form.captureStudent.length }}</p>
                                </div> -->
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
        props:['lectu', 'lectuexist', 'stdexist', 'students',],
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
                    theclass: '',
                }),

            }
        },
        methods: {
            processSelect(event){
                //alert(event.target.value);
                this.form.post(this.route('staff.viewlecture.loadstudent', this.form.theclass), {
                    onFinish: () => this.form.reset(),
                })
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>