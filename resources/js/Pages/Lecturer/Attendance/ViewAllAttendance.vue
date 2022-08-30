<template>
    <staff-layout title="View Attendance">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>All Departmental Class Attendance</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Lecturer</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('staff.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">View Class Attendance</li>
                </ol>
            </div>
        </template>

        <div class="text-center text-success bg1" v-if="$page.props.success">
            <span>{{ $page.props.success }}</span>
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Select Lecture Class</h4>
                        <form @submit.prevent="loadClass">
                            <div class="mb-3 row">
                                <jet-label for="course" class="col-md-3 col-form-label form-label" value="Select Departmental Course" />
                                <div class="col-md-9">    
                                    <select class="form-control" id="course" v-model="form.course">
                                        <option :value="dcourse.id" v-for="(dcourse, id) in courses" :key="id">{{ dcourse.coursename }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <jet-label for="acadsession" class="col-md-3 col-form-label form-label" value="Select Academic Session" />
                                <div class="col-md-9">    
                                    <select class="form-control" id="acadsession" v-model="form.acadsession">
                                        <option :value="asession.id" v-for="(asession, id) in allsessions" :key="id">{{ asession.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <jet-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                Load Class(s)
                            </jet-button>

                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
<!--         
        <div class="row" v-if="lectuexist">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Select Lecture Class</h4>
                        <form @submit.prevent="loadClass">
                            <div class="mb-3 row">
                                <jet-label for="department" class="col-md-2 col-form-label form-label" value="Select Lecture Class" />
                                <div class="col-md-10">    
                                    <select class="form-control" id="department" @change="processSelect($event)" v-model="form.theclass">
                                        <option :value="thelectu.id" v-for="(thelectu, id) in lectus" :key="id">{{ thelectu.name }},  Session: {{ thelectu.acadsession.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <br><br><br>
       
        <div class="row" v-if="attendexist">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Available Student(s) in the lecture class</h4>
                        <p class="card-title-desc">Available Student(s) in the lecture class</p>

                        <div class="attendtable">
                            <div class="d-flex flex-row justify-content-between thead p-2">
                                <div v-for="(attdate, index) in attdates" :key="index" class="">
                                    <div>{{ attdate }}</div> 
                                </div>
                            </div>

                            <div>
                                <div v-for="(allattend, index) in allattends" :key="index">
                                   <div class="d-flex flex-row justify-content-between p-1">
                                        <div class="tbody bbordered">{{ allattend[0].student.matric_no }}</div>
                                        <div v-for="(attend, index) in allattend" :key="index" class="tbody bbordered">
                                            <img :src="'/storage/images/' + getImage(attend.attend)" alt="">
                                        </div>
                                        <div class="tbody bbordered">{{ showPercentage(index)}}</div>
                                   </div>

                                </div>
                            </div>
                        </div>
                                            
                    </div>
                </div>

                <div class="card myshadow text-center">
                    <div class="card-body">
                        <button class="btn" @click="exportAttendance">Export as PDF</button>
                    </div>
                </div>

                <br><br><br>
            </div> 
        </div>

        <div class="row" v-else>
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Attendance Student</h4>
                        <p class="card-title-desc">Attendance Student</p>
                        <div class="nocourse bg-danger p-2 text-center fw-bolder">Attendance is not available for this class</div>
                    </div>
                </div>
            </div>
        </div> -->


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
import axios from 'axios';

    export default {
        props:['courses', 'allsessions', 'lectuexist', 'attendexist', 'allattends', 'attdates', 'percentages'],
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
                    course: 0,
                    acadsession: 0,
                }),
                count: 0,
            }
        },
        methods: {
            loadClass(){
                alert(this.form.course)
            //    this.form.post(this.route('staff.attendance.export'), {
            //         onFinish: () => this.form.reset(),
            //     })
            },
            processSelect(event){
                alert('To be completed');
                //alert(event.target.value);
                // this.form.post(this.route('staff.viewattendance.table'), {
                //     onFinish: () => this.form.reset(),
                // })
            },
            exportAttendance(){
               this.form.post(this.route('staff.attendance.export'), {
                    onFinish: () => this.form.reset(),
                })
            },
            lectureDate(dateString){
                const date = new Date(dateString);
                return Intl.DateTimeFormat('default', {dateStyle:'long'}).format(date)
             
            },
            showPercentage(key){
                if(this.percentages.hasOwnProperty(key)){
                   return this.percentages[key]
                }
                else{
                    return '0%'
                }
            },
            getImage(attend){
                if(attend){
                    return 'check.png'
                }else{
                    return 'uncheck.png'
                }
            }
        },
       
    }
</script>

<style lang="scss" scoped>
    .bbordered{
        border-bottom: 1px solid rgb(230, 230, 230);
    }

    .thead{
        background-color: #23303d;
        color: #ffffff;
        font-weight: 700;
    }

    .tbody{
        width: calc(100% / 6);
        padding: 5px 0px; 
        display: inline-block;
    }
</style>