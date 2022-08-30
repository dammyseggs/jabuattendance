<template>
    <staff-layout title="Upload Student">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Upload Student</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Lecturer</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Upload Student</li>
                </ol>
            </div>
        </template>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                      <form @submit.prevent="submit">
                        <h4 class="card-title">New Student</h4>
                        <p class="card-title-desc">Register Student.</p>
                        <p><jet-validation-errors class="mb-3" /></p>
                        <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
                            <span>{{ $page.props.success }}</span>
                        </p>
                         

                        <div class="mb-3 row">
                                <jet-label for="csession" class="col-md-2 col-form-label form-label" value="Student Record" />
                                <div class="col-md-6">
                                    <jet-input class="form-control" id="csession" type="file" v-model="form.stdrecord"  placeholder="Current Session" />
                                </div>
                                <div class="col-md-4">
                                    <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                        <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>

                                        Upload Student
                                    </jet-button>
                                </div>
                        </div>

                            


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
import axios from 'axios'
    export default {
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
                    stdrecord: '',
                }),

            }
        },
        methods: {
            submit() {
                this.form.post(this.route('staff.uploadallstudent'), {
                    onFinish: () => this.form.reset(),
                })
            },
        }
    }
</script>

<style lang="scss" scoped>

</style>