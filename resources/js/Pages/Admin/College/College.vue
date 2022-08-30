<template>
    <admin-layout title="New Student">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>New College</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Admin</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">College</li>
                </ol>
            </div>
        </template>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="submitCollege">
                            <h4 class="card-title">New College</h4>
                            <p class="card-title-desc">College Registration</p>
                            <p><jet-validation-errors class="mb-3" /></p>
                            <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
                                <span>{{ $page.props.success }}</span>
                            </p>

                            <div class="mb-3 row">
                                <jet-label for="name" class="col-md-2 col-form-label form-label" value="College Name" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="name" type="text" v-model="form.name" required placeholder="Enter College Name" />
                                </div>
                            </div>
                            
                            <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                Register College
                            </jet-button>

                        </form>   
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>

        <br />
        <br />
        <br />
        <br />


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>College Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(thecollege, index) in thecoll" :key="index">
                                    <td>{{thecollege.name}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="mr-4"><Link type="button" class="btn btn-sm btn-primary" :href="route('admin.college.edit', thecollege.id)" >Edit</Link></div>
                                            <div>
                                                <form @submit.prevent ="deleteCollege(thecollege.id)">
                                                    <button type="button" class="btn btn-sm btn-danger">Remove</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>  
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>

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
        props:['thecoll'],
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
                    name: '',
                    department_name: '',
                    collegeid: '',
                })
            }
        },
        methods: {
            async submitCollege() {
                this.form.post(this.route('admin.storecollege'), {
                    onFinish: () => this.form.reset(),
                })
            },

            deleteDepartment(id){
                this.$inertia.delete(route('admin.college.destroy', id))
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>