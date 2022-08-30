<template>
    <admin-layout title="New Student">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Update Department</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Admin</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Department</li>
                </ol>
            </div>
        </template>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <h4 class="card-title">Update Department</h4>
                            <p class="card-title-desc"></p>
                            <p><jet-validation-errors class="mb-3" /></p>
                            <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
                                <span>{{ $page.props.success }}</span>
                            </p>

                            <div class="mb-3 row">
                                <jet-label for="name" class="col-md-2 col-form-label form-label" value="Department Name" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="name" type="text" v-model="form.name" required placeholder="Enter Department Name" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="college_id" class="col-md-2 col-form-label form-label" value="College" />
                                <div class="col-md-10">    
                                    <select class="form-control" id="college_id" name="" v-model="form.college_id">
                                        <option :value="thedepartment.college.id" selected disabled>{{ thedepartment.college.name }}</option>
                                        <option :value="coll.id" v-for="(coll, id) in thecoll" :key="id">{{ coll.name }}</option>
                                    </select>
                                </div>
                            </div>    
                            
                            <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                Update Department
                            </jet-button>

                        </form>   
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
        props:['thecoll', 'thedepartment'],
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
                    name: this.thedepartment.name,
                    college_id: '',
                })
            }
        },
        methods: {  
            async submit() {
                this.form.patch(this.route('admin.department.update', this.thedepartment.id), {
                    onFinish: () => this.form.reset(),
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>