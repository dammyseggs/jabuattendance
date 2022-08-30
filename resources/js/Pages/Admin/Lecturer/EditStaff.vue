<template>
    <admin-layout title="New Staff">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Update Staff</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Admin</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Update Staff</li>
                </ol>
            </div>
        </template>

        <div class="row" v-if="getHOD">
            <div class="col-12">
                <div class="card myshadow hodcolor">
                    <div class="card-body d-flex justify-content-around">
                        <div class="hod1 lead">
                            This staff is HOD
                        </div>
                        <div>
                            <form @submit.prevent ="removeHOD(staff.id)">
                                <button type="submit" class='btn btn-danger btn-sm ml-2'>Remove as HOD</button>
                            </form>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>

        <div class="row" v-else>
            <div class="col-12">
                <div class="card myshadow hodcolor">
                    <div class="card-body d-flex justify-content-around">
                        <div class="hod1 lead">
                            A Staff in the Department  of {{ staff.department.name }}
                        </div>
                        <div>
                            <form @submit.prevent ="setHOD(staff.id)">
                                <button type="submit" class='btn btn-primary btn-sm ml-2'>Set Staff as HOD</button>
                            </form>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <h4 class="card-title">New Staff</h4>
                            <p class="card-title-desc">Register Staff.</p>
                            <p><jet-validation-errors class="mb-3" /></p>
                            <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
                                <span>{{ $page.props.success }}</span>
                            </p>

                            <div class="mb-3 row">
                                <jet-label for="staffid" class="col-md-2 col-form-label form-label" value="Staff ID" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="staffid" type="text" v-model="form.staffid" autofocus placeholder="Enter Staff ID" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <jet-label for="title" class="col-md-2 col-form-label form-label" value="Staff Title" />
                                <div class="col-md-10">
                                    <select id="title" class="form-control" v-model="form.title">
                                        <option value="Arch.">Arch.</option>                                          
                                        <option value="Barr.">Barr.</option>
                                        <option value="Dr.">Dr.</option>
                                        <option value="Engr.">Engr.</option>
                                        <option value="Miss">Miss</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Prof">Prof</option>
                                        <option value="Pastor">Pastor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="name" class="col-md-2 col-form-label form-label" value="Surname" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="name" type="text" v-model="form.name" placeholder="Enter Surname" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="othername" class="col-md-2 col-form-label form-label" value="Othername" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="othername" type="text" v-model="form.othername" placeholder="Enter Othername" />
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

                            <div class="mb-3 row">
                                <jet-label for="email" class="col-md-2 col-form-label form-label" value="Email" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="email" type="text" v-model="form.email" placeholder="Enter Email" />
                                </div>
                            </div>    
                                                        
                            <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                Update
                            </jet-button>

                        </form>        
                    </div>
                </div>
                <br><br>
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

    export default defineComponent({
        props:['staff'],
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
                    staffid: this.staff.staffid,
                    title: this.staff.title,
                    name: this.staff.name,
                    othername: this.staff.othername,
                    college: 0,
                    department: 0,
                    email: this.staff.email,
                    remember: false,
                    colleges: [],
                    departments: [],
                    removeHOD: 'donotremove',
                    
                }),

                deptoptions: this.thedept,
            }
        },

        methods: {
            async submit() {
                this.form.patch(this.route('admin.staffs.update', this.staff.id), {
                    onFinish: () => this.form.reset(),
                })
            },
            async removeHOD(id){
                this.form.patch(this.route('admin.staffs.removeHOD', this.staff.id), {
                    onFinish: () => this.form.reset(),
                })
            },
            async setHOD(id){
                this.form.patch(this.route('admin.staffs.setHOD', this.staff.id), {
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
                // axios({
                //     method: 'get',
                //     url: '/get_dept',
                //     params: {
                //         college_id: this.form.college
                //     }
                // })
                // .then(function(response){
                //     this.selectedDepartments = response.data;
                // }).bind(this)
                // .catch(error => console.log(error));

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
        },

        computed :{
            getHOD(){
                var names = [];
                for (let i = 0; i < this.staff.roles.length; i++) {
                    names[i] = this.staff.roles[i].name;
                }

                if(names.includes("hod")){
                    return true;
                }else{
                    return false;
                }
            }
        }
    })

</script>

<style lang="scss" scoped>
    .hodcolor{
        background-color: #e2dfdf;
    }
    .hod1{
        font-weight: 800;
        font-size: 1rem;
        letter-spacing: 5px;
    }
</style>