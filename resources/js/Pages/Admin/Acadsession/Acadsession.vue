<template>
    <admin-layout>
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Academic Session</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Admin</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Academic Session</li>
                </ol>
            </div>
        </template>

        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                         <h4 class="card-title">Academic Session</h4>
                         <p class="card-title-desc">Academic Session</p>
                         <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
                            <span>{{ $page.props.success }}</span>
                         </p>
                          <p><jet-validation-errors class="mb-3" /></p> 
                         <table class="table">
                            <thead>
                                <tr>
                                    <th>Session Name</th>
                                    <th>Current</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                <tbody>
                                    <tr v-for="(asession, index) in acadsession" :key="index">
                                        <td>{{asession.name}}</td>
                                        <td>
                                            <div class="badgegreen" v-if="asession.current">Yes</div>
                                            <div class="badgered" v-else>No</div>
                                        </td>
                                        <td>
                                            <span  v-if="asession.current"><Link type="button" :href="route('admin.acadsession.show', asession.id)" class="btn btn-sm btn-info">Edit</Link > 
                                                <form @submit.prevent="closeCurrent(asession.id)">
                                                    <button class="btn btn-sm btn-danger">Close Current</button>
                                                </form>
                                            </span>
                                            <span v-else>
                                                <form @submit.prevent="setCurrent(asession.id)">
                                                    <button class="btn btn-sm btn-success">Set as Current</button>
                                                </form>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
         <br>
        <br>
        <!-- <button type="button" class="btn btn-sm btn-primary"  @click="showModal" >Open Modal! </button> -->

        <Modal  v-show="isModalVisible" @close="closeModal" @yes="submitModal" >
            <template v-slot:body>
                <h6>Are you sure you want to close the current session? </h6>
            </template>
        </Modal>

        <Modal  v-show="issetModalVisible" @close="closeModal" @yes="submitCurrent" >
            <template v-slot:body>
                <h6>Are you sure you want to set this session as current? </h6>
            </template>
        </Modal>

        <br>

        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                         <form @submit.prevent="submit">
                            <h4 class="card-title">Register New Academic Session</h4>
                            <p class="card-title-desc">New Academic Session</p>
                            <p><jet-validation-errors class="mb-3" /></p> 
                            
                            <div class="mb-3 row">
                                <jet-label for="name" class="col-md-2 col-form-label form-label" value="Session Name" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="name" type="text" v-model="form.name" placeholder="e.g 2020/2021" />
                                </div>
                            </div>
                            
                            <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                Create Session
                            </jet-button>

                        </form> 
                    </div>
                </div>
            </div>
        </div> 

         <br> <br>

         
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
                    name: '',
                    current: 1,
                }),

                isModalVisible: false,
                issetModalVisible: false,
                closeCurrentId:0,
            }
        },
        methods: {
            async submit() {
                this.form.post(this.route('admin.acadsession.store'), {
                    onFinish: () => this.form.reset(),
                })
            },
            async closeCurrent(id) {
                this.closeCurrentId = id;
                this.showModal();
                // this.form.post(this.route('admin.acadsession.closecurrent', id), {
                //     onFinish: () => this.form.reset(),
                // })
            },
            async setCurrent(id) {
                this.closeCurrentId = id;
                this.showSetModal();
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

            submitModal() {
                // this.closeModal();
                this.form.post(this.route('admin.acadsession.closecurrent', this.closeCurrentId), {
                    onFinish: () => this.form.reset(),
                }),
                this.closeModal();
            },

            submitCurrent() {
                this.form.post(this.route('admin.acadsession.setcurrent', this.closeCurrentId), {
                    onFinish: () => this.form.reset(),
                }),
                this.closeModal();
            }

        },
    }
</script>

<style lang="scss" scoped>

.badgered, .badgegreen{
    padding-left: 10px;
    font-weight: 700;
}
.badgered{
    background-color: #fc0808;
}

.badgegreen{
    background-color: #73de26;
}

td form{
    display: inline-block;
    margin-left: 5px;
}
</style>