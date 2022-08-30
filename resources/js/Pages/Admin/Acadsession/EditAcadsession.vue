<template>
    <admin-layout>
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Update Academic Session</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Admin</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Update Academic Session</li>
                </ol>
            </div>
        </template>

        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <h4 class="card-title">Update Academic Session</h4>
                            <p class="card-title-desc">Update Academic Session</p>
                            <p><jet-validation-errors class="mb-3" /></p> 
                            
                            <div class="mb-3 row">
                                <jet-label for="name" class="col-md-2 col-form-label form-label" value="Session Name" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="name" type="text" v-model="form.name" placeholder="e.g 2020/2021" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="current" class="col-md-2 col-form-label form-label" value="Current ?" />
                                <div class="col-md-10">
                                    <select class="form-control" id="current" name="current" v-model="form.current">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            
                            <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                Update Session
                            </jet-button>

                        </form> 
                    </div>
                </div>
            </div>
        </div>

        <Modal  v-show="isModalVisible" @close="closeModal" @yes="submitModal" >
            <template v-slot:body>
                <h6>Are you sure you want to close the current session? </h6>
            </template>
        </Modal>

        


    </admin-layout>
</template>

<script>
import AdminLayout from '@/Layouts/Admin/AdminLayout'
import Modal from '@/Layouts/Components/Modal'
import { defineComponent } from 'vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
    export default {
        props:['acadsession'],
        components: {
            Head,
            AdminLayout,
            JetInput,
            JetButton,
            JetLabel,
            JetValidationErrors,
            Modal,
            Link,
        },
        data() {
            return {
                form: this.$inertia.form({
                    name: this.acadsession.name,
                    current: this.acadsession.current,
                }),
                isModalVisible: false,
            }
        },
        methods: {
            async submit() {
                this.showModal()
                // this.form.post(this.route('admin.acadsession.store'), {
                //     onFinish: () => this.form.reset(),
                // })
            },
            showModal() {
                this.isModalVisible = true;
            },
            closeModal() {
                this.isModalVisible = false;
            },
            submitModal() {
                this.form.patch(this.route('admin.acadsession.update', this.acadsession.id), {
                    onFinish: () => this.form.reset(),
                })
                this.closeModal();
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>