<template>
    <admin-layout title="Admin Attendance">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Attendance</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Admin</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Attendance</li>
                </ol>
            </div>
        </template>

       <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <h4 class="card-title">View Attendance</h4>
                            <p class="card-title-desc">View All Attendance</p>
                            <p><jet-validation-errors class="mb-3" /></p>
                            <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
                                <span>{{ $page.props.success }}</span>
                            </p>

                            <div class="mb-3 row">
                                <jet-label for="acadsession" class="col-md-2 col-form-label form-label" value="Session" />
                                <div class="col-md-10"> 
                                    <select class='form-control' v-model='form.acadsession' @change='getSessions()'>
                                        <option value='0' >Select Academic Session</option>
                                        <option v-for='asession in allsession' :value='asession.id' :key='asession.id'>{{ asession.name }}</option>
                                    </select>  
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="college" class="col-md-2 col-form-label form-label" value="College" />
                                <div class="col-md-10"> 
                                    <select class='form-control' v-model='form.college' @change='getDepartments()'>
                                        <option value='0' >Select College</option>
                                        <option v-for='data in form.colleges' :value='data.id' :key='data.id'>{{ data.name }}</option>
                                    </select>  
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="department" class="col-md-2 col-form-label form-label" value="Department" />
                                <div class="col-md-10">  
                                    <select class='form-control' v-model='form.department'>
                                        <option value='0' >Select Department</option>
                                        <option v-for='data in form.departments' :value='data.id' :key='data.id'>{{ data.name }}</option>
                                    </select>  
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/Admin/AdminLayout'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    //import AppLayout from '@/Layouts/AppLayout'
    export default {
        props:['allsession'],
        components: {
            AdminLayout,
            JetLabel,
            JetButton,
            JetInput,
            Head,
            Link,
        },

        data() {
            return {
                form: this.$inertia.form({
                    acadsession: 0,
                    college: 0,
                    department: 0,
                    acadsessions: [],
                    colleges: [],
                    departments: [],
                })
            }
        },
        methods: {
            async submit() {
                this.form.post(this.route('admin.students.store'), {
                    onFinish: () => this.form.reset(),
                })
            }, 

            getColleges: function(){
                axios.get('/get_all_college')
                    .then(function (response) {
                        this.form.colleges = response.data;
                    }.bind(this));
            },
            getDepartments: function() {
                axios({
                    method: 'get',
                    url: '/get_dept',
                    params: {
                        college_id: this.form.college
                    }
                })
                .then(res => this.processDept(res))
                .catch(error => console.log(error));
            },

            processDept: function(res){                
                this.form.departments = res.data;
            }
        },

        created: function(){
            this.getColleges()
        }

       
    }
</script>

<style lang="scss" scoped>

</style>