<template>
    <staff-layout>
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Update Course</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Lecturer</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Update Course</li>
                </ol>
            </div>
        </template>

        

        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <h4 class="card-title">Update Courses</h4>
                            <p class="card-title-desc">Update Courses in the Department</p>
                            <p><jet-validation-errors class="mb-3" /></p> 
                            <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
                                <span>{{ $page.props.success }}</span>
                            </p>

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

                                Update Course
                            </jet-button>



                        </form>                        
                    </div>
                </div>
            </div>
        </div>

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
        props:['thecourses',],
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
                    coursename: this.thecourses.coursename,
                    coursecode: this.thecourses.coursecode,
                    courselevel: this.thecourses.courselevel,
                    college: 0,
                    department: 0,
                    description: '',
                    colleges: [],
                    departments: [],
                }),
            }
        },
        methods: {
            async submit() {
                this.form.patch(this.route('staff.course.update', this.thecourses.id), {
                    onFinish: () => this.form.reset(),
                })
            },
        },
    }
</script>

<style lang="scss" scoped>

</style>