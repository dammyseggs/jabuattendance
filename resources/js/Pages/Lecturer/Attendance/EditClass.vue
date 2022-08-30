<template>
    <staff-layout>
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Lecture Class Management</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Lecturer</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Update Lecture Class</li>
                </ol>
            </div>
        </template>

        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <h4 class="card-title">Update Lecture Class</h4>
                            <p class="card-title-desc">Update Lecture Class</p>
                            <p><jet-validation-errors class="mb-3" /></p>
                            <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
                                <span>{{ $page.props.success }}</span>
                            </p>

                             <div class="mb-3 row">
                                <jet-label for="name" class="col-md-2 col-form-label form-label" value="Class Name" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="name" type="text" v-model="form.name" required placeholder="Name" />
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
                                                       
                            <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                Update Lecture Class
                            </jet-button>

                        </form>   
                    </div>
                </div>
            </div>
            <!-- end col -->
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
         props:['lectureclass', 'yourcourses'],
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
                    name: this.lectureclass.name,
                    course: this.lectureclass.course_id,
                    addinfo: this.lectureclass.addinfo,
                }),
            }
        },
        methods: {
            submit() {
                this.form.patch(this.route('staff.newlecture.update', this.lectureclass.id), {
                    onFinish: () => this.form.reset(),
                })
            },
        }, 
    }
</script>

<style lang="scss" scoped>

</style>