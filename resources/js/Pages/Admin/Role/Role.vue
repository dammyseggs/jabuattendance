<template>
    <admin-layout title="New Staff">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Staff Role</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Admin</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Role</li>
                </ol>
            </div>
        </template>
        
        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                        <h4 class="card-title">Available Roles</h4>
                        <p class="card-title-desc">All available roles</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Role Name</th>
                                    <th>Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(role, index) in theroles" :key="index">
                                    <td>{{role.name}}</td>
                                    <td><Link :href="route('admin.staffs.edit', role.id)">Update</Link></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/Admin/AdminLayout'
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    export default {
        props:['theroles'],
        components: {
            Head,
            AdminLayout,
            Link,
        },
    }
</script>

<style lang="scss" scoped>

</style>