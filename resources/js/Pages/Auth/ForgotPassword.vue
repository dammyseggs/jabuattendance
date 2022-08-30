 <template>
  <Head title="Forgot Password" />

  <div>
    <div class="login-page my-5 pt-sm-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card overflow-hidden">
              <div class="card-body pt-0">
                <h3 class="text-center mt-5 mb-4">
                    <img :src="'/storage/images/attendance1.png'" alt="" height="30" class="auth-logo-dark">
                </h3>

                <div class="p-3">
                    <h4 class="text-muted font-size-18 mb-1 text-center">Welcome Back !</h4>
                    <div class="mb-2">
                      Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                    </div>
                    <div v-if="status" class="alert alert-success" role="alert">
                        {{ status }}
                    </div>
                    <jet-validation-errors class="mb-3" />

                    <form @submit.prevent="submit">
                      <div>
                        <jet-label for="email" value="Email" />
                        <jet-input id="email" type="email" v-model="form.email" required autofocus />
                      </div>
                      <div class="d-flex justify-content-between mt-4">
                       <div>                        
                        <Link :href="route('login')" class="forgot-pass me-3">
                              <i class='bx bxs-lock'></i>Login
                        </Link>
                       </div>

                        <jet-button :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                          <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                        
                          Email Password Reset Link
                        </jet-button>
                      </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!--  <jet-authentication-card>
    <template #logo>
      <jet-authentication-card-logo />
    </template>

    <div class="card-body">
      <div class="mb-2">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
      </div>

      <div v-if="status" class="alert alert-success" role="alert">
        {{ status }}
      </div>

      <jet-validation-errors class="mb-2" />

      <form @submit.prevent="submit">
        <div>
          <jet-label for="email" value="Email" />
          <jet-input id="email" type="email" v-model="form.email" required autofocus />
        </div>

        <div class="d-flex justify-content-end mt-4">
          <jet-button :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
            <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            
            Email Password Reset Link
          </jet-button>
        </div>
      </form>
    </div>
  </jet-authentication-card> -->
</template>

<script>
import { defineComponent } from 'vue'
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
  components: {
    Head,
    Link,
    JetAuthenticationCard,
    JetAuthenticationCardLogo,
    JetButton,
    JetInput,
    JetLabel,
    JetValidationErrors
  },

  props: {
    status: String
  },

  data() {
    return {
      form: this.$inertia.form({
        email: ''
      })
    }
  },

  methods: {
    submit() {
      this.form.post(this.route('password.email'))
    }
  }
})
</script>
<style>
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
