<template>
  <Head title="Log in" />

  <div>
    <div class="login-page my-5 pt-sm-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card overflow-hidden shadows">
              <div class="card-body pt-0">

                <h3 class="text-center mt-5 mb-4">
                    <img :src="'/storage/images/attendance1.png'" alt="" height="30" class="auth-logo-dark">
                </h3>

                <div class="p-3">
                  <h4 class="text-muted font-size-18 mb-1 text-center">Welcome Back !</h4>
                  <p class="text-muted text-center">Sign in to continue to JABU Attendance.</p>
                  <jet-validation-errors class="mb-3" />

                  <div v-if="status" class="alert alert-success mb-3 rounded-0" role="alert">
                    {{ status }}
                  </div>
                  <form class="form-horizontal mt-4" @submit.prevent="submit">
                      <div class="mb-3">
                          <jet-label for="email" value="Email" />
                          <jet-input id="email" type="email" class="form-control" v-model="form.email" required autofocus />
                      </div>
                      <div class="mb-3">
                          <jet-label for="password" value="Password" />
                          <jet-input id="password" type="password" class="form-control" v-model="form.password" required autocomplete="current-password" />
                      </div>
                      <div class="mb-3 row mt-4">
                          <div class="col-6">
                              <div class="form-check">
                                  <jet-checkbox id="remember_me" name="remember" class="form-check-input" v-model:checked="form.remember" />
                                  <label class="custom-control-label" for="remember_me">Remember Me</label>
                              </div>
                          </div>
                          <div class="col-6 text-end">
                              <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                          </div>
                      </div>
                      <div class="form-group mb-0 row">
                          <div class="col-12 mt-4">
                            <Link v-if="canResetPassword" :href="route('password.request')" class="forgot-pass me-3">
                              <i class='bx bxs-lock'></i>Forgot your password?
                            </Link>
                          </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
              <div class="mt-5 text-center">
                <p>Don't have an account ? Please contact the Admin</p>© JOSEPH AYO BABALOLA UNIVERSITY
              </div>
                
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
  components: {
    Head,
    JetAuthenticationCard,
    JetAuthenticationCardLogo,
    JetButton,
    JetInput,
    JetCheckbox,
    JetLabel,
    JetValidationErrors,
    Link,
  },

  props: {
    canResetPassword: Boolean,
    status: String
  },

  data() {
    return {
      form: this.$inertia.form({
        email: '',
        password: '',
        remember: false
      })
    }
  },

  methods: {
    submit() {
      this.form
          .transform(data => ({
            ... data,
            remember: this.form.remember ? 'on' : ''
          }))
          .post(this.route('login'), {
            onFinish: () => this.form.reset('password'),
          })
    }
  }
})
</script>

<style>
   .shadows{
     box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
   }

   .forgot-pass{
      text-decoration: none;
      font-weight: 700;
      color: #2e2f2e;
   }

   .forgot-pass i{
     margin-right: 5px;
   }

    .forgot-pass:hover{
      color: #da3320;
      text-decoration: underline;
    }
</style>
