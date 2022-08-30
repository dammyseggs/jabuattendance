 <template>
    <admin-layout title="Upload Students">
        <template #page-title-box>
            <div class="page-title-box">
                <h4>Upload New Students</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Admin</Link></li>
                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboard</Link></li>
                    <li class="breadcrumb-item active">Upload Students</li>
                </ol>
            </div>
        </template>

        <div class="row">
            <div class="col-12">
                <div class="card myshadow">
                    <div class="card-body">
                      <form @submit.prevent="submit" enctype="multipart/form-data">
                        <h4 class="card-title">New Student</h4>
                        <p class="card-title-desc">Register Student.</p>
                        <p><jet-validation-errors class="mb-3" /></p>
                        <p class="d-flex justify-content-center text-success fw-bold" v-if="$page.props.success">
                            <span>{{ $page.props.success }}</span>
                        </p>

                        <div class="mb-3 row">
                                <jet-label for="csession" class="col-md-2 col-form-label form-label" value="Student Record" />
                                <div class="col-md-7">
                                    <jet-input class="form-control" id="csession" type="file" v-model="form.stdrecord"  placeholder="Upload Student Record" />
                                </div>
                                <div class="col-md-3">
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
        props:['thedept'],
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
                    stdrecord: '',
                })
            }
        },
        methods: {
            async submit() {
                this.form.post(this.route('admin.students.upload'), {
                    onFinish: () => this.form.reset(),
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>