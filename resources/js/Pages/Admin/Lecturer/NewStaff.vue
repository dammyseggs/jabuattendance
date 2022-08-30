<template>
    <admin-layout title="New Staff">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>New Staff</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Admin</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">New Staff</li>
                </ol>
            </div>
        </template>

        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
                            <span>{{ $page.props.success }}</span>
                        </p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Staff ID</th>
                                    <th>Title</th>
                                    <th>Name</th>
                                    <th>Othername</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(staff, index) in staffs" :key="index">
                                    <td class="staffid"><span class="barge">HOD</span>{{ staff.staffid }}</td>
                                    <td>{{ staff.title }}</td>
                                    <td>{{ staff.name }}</td>
                                    <td>{{ staff.othername }}</td>
                                    <td>{{ staff.email }}</td>
                                    <td>
                                        <Link :href="route('admin.staffs.edit', staff.id)" class="btn btn-primary btn-sm">Edit</Link>
                                        <form @submit.prevent ="deleteStaff(staff.id)">
                                            <button type="submit" class='btn btn-danger btn-sm ml-2'>Delete</button>
                                        </form> 
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
                                    <jet-input class="form-control" id="staffid" type="text" v-model="form.staffid" required autofocus placeholder="Enter Staff ID" />
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
                                    <jet-input class="form-control" id="name" type="text" v-model="form.name" required  placeholder="Enter Surname" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="othername" class="col-md-2 col-form-label form-label" value="Othername" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="othername" type="text" v-model="form.othername" required autofocus placeholder="Enter Othername" />
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
                                    <jet-input class="form-control" id="email" type="text" v-model="form.email" required  placeholder="Enter Email" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="hod" class="col-md-2 col-form-label form-label" value="Staff/HOD" />
                                <div class="col-md-10">    
                                    <select class='form-control' v-model='form.hod'>
                                        <option value='1' >Staff</option>
                                        <option value='2' >HOD</option>
                                    </select> 
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="password" class="col-md-2 col-form-label form-label" value="Password" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="password" type="password" v-model="form.password" placeholder="Password" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <jet-label for="password_confirmation" class="col-md-2 col-form-label form-label" value="Confirm Password" />
                                <div class="col-md-10">
                                    <jet-input class="form-control" id="password_confirmation" type="password" v-model="form.password_confirmation" placeholder="Confirm Password" />
                                </div>
                            </div>

                            
                            
                            <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                Register
                            </jet-button>

                        </form>        
                    </div>
                </div>
                <br><br>
            </div>
        </div>

    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/Admin/AdminLayout'
    import Datatable from '@/Layouts/Components/Datatable'
    import Pagination from '@/Layouts/Components/Pagination'
    import { defineComponent } from 'vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from "@/Jetstream/Checkbox.vue";
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'

    export default defineComponent({
        props:['staffs'],
        components: {
            Head,
            AdminLayout,
            Datatable,
            Pagination,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
        },
        data() {
            let sortOrders = {};

            let columns = [
                {width: '33%', label: 'Staff ID', name: 'staffid'},
                {width: '33%', label: 'Title', name: 'title'},
                {width: '33%', label: 'Surname', name: 'name'},
                {width: '33%', label: 'Othername', name: 'othername'},
                {width: '33%', label: 'Email', name: 'email'},
                {width: '33%', label: 'Department', name: 'department'},
            ];

            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });

            return {
                form: this.$inertia.form({
                    staffid: '',
                    title: '',
                    name: '',
                    othername: '',
                    college: 0,
                    department: 0,
                    hod: 0,
                    email: '',
                    password: '',
                    password_confirmation: '',
                    remember: false,
                    colleges: [],
                    departments: [],
                    
                }),
                deptoptions: this.thedept,

                projects: [],
                columns: columns,
                sortKey: 'staffid',
                sortOrders: sortOrders,
                tableData: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'desc'
                },
                pagination: {
                    lastPage: '',
                    currentPage: '',
                    total: '',
                    lastPageUrl: '',
                    nextPageUrl: '',
                    prevPageUrl: '',
                    from: '',
                    to: '',
                },
            }
        },

        methods: {
            async submit() {
                this.form.post(this.route('admin.staffs.store'), {
                    onFinish: () => this.form.reset(),
                })
            },
            async deleteStaff(id){
                this.$inertia.delete(route('admin.staffs.destroy', id))
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
            },


            getStaffData(url = '/getstaffdata'){
                this.tableData.draw++;
                axios.get(url, {params: this.tableData})
                    .then(response => {
                        let data = response.data;
                        if(this.tableData.draw == data.draw){
                            this.projects = data.data.data;
                            this.configPagination(data.data);
                        }
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },

            configPagination(data){
                this.pagination.lastPage = data.last_page;
                this.pagination.currentPage = data.current_page;
                this.pagination.total = data.total;
                this.pagination.lastPageUrl = data.last_page_url;
                this.pagination.nextPageUrl = data.next_page_url;
                this.pagination.prevPageUrl = data.prev_page_url;
                this.pagination.from = data.from;
                this.pagination.to   = data.to  ;
            },
        },
        created: function(){
            this.getStaffData();
            this.getColleges()
        }
    })

</script>

<style lang="scss" scoped>
    td form{
        display: inline-block;
    }

    .staffid{
        position: relative;
        padding-left: 10px;
    }
    .barge{
        display: inline-block;
        padding: 5px;
        background-color: #d97878;
        font-size: 8px;
        position: absolute;
        top: 0;
    }
</style>