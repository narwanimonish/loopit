<template>
  <div class="row">
    <div class="col">
      <section class="vh-100">
        <div class="container py-5 h-100">
          <div class="row d-flex align-items-center justify-content-center">
            <div class="alert alert-success" role="alert" v-if="successMsg">
              {{ successMsg }}
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
              <form @submit.prevent="register" ref="registerForm">
                <div class="form-outline mb-4">
                  <label class="form-label" for="name">Name</label>
                  <input
                    type="text"
                    id="name"
                    :class="[
                      'form-control form-control-lg',
                      errors.name ? 'is-invalid' : '',
                    ]"
                    v-model="name"
                  />
                  <div class="invalid-feedback" v-if="errors.name">
                    {{ errors.name }}
                  </div>
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="email">Email address</label>
                  <input
                    type="email"
                    id="email"
                    :class="[
                      'form-control form-control-lg',
                      errors.email ? 'is-invalid' : '',
                    ]"
                    v-model="email"
                  />
                  <div class="invalid-feedback" v-if="errors.email">
                    {{ errors.email }}
                  </div>
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="password">Password</label>
                  <input
                    type="password"
                    id="password"
                    :class="[
                      'form-control form-control-lg',
                      errors.password ? 'is-invalid' : '',
                    ]"
                    v-model="password"
                  />
                  <div class="invalid-feedback" v-if="errors.password">
                    {{ errors.password }}
                  </div>
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="password_confirm">
                    Confirm Password
                  </label>
                  <input
                    type="password"
                    id="password_confirm"
                    :class="[
                      'form-control form-control-lg',
                      errors.cpassword ? 'is-invalid' : '',
                    ]"
                    v-model="cpassword"
                  />
                  <div class="invalid-feedback" v-if="errors.cpassword">
                    {{ errors.cpassword }}
                  </div>
                </div>

                <button
                  type="submit"
                  class="btn btn-primary btn-lg btn-block m-4"
                >
                  Sign up
                </button>
                <button
                  type="button"
                  class="btn btn-primary btn-lg btn-block m-4"
                  @click="resetForm"
                >
                  Reset
                </button>

                <div class="d-flex justify-content-around align-items-center">
                  <router-link :to="{ name: 'Login' }">
                    Already User? Login here.
                  </router-link>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import { register } from './../api-urls';
export default {
  data() {
    return {
      name: null,
      email: null,
      password: null,
      cpassword: null,
      errors: this.defaultError(),
      successMsg: null,
    };
  },
  methods: {
    defaultError() {
      return {
        name: null,
        email: null,
        password: null,
        cpassword: null,
      };
    },
    async register() {
      this.errors = this.defaultError();
      try {
        const response = await this.axios.post(register, {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.cpassword,
        });
        if (response.status == 201) {
          this.success(response.data);
        }
      } catch (error) {
        if (error.response.status == 422) {
          const errors = error.response.data.errors;
          this.errors.name = errors.name ? errors.name[0] : null;
          this.errors.email = errors.email ? errors.email[0] : null;
          this.errors.password = errors.password ? errors.password[0] : null;
          this.errors.cpassword = errors.cpassword ? errors.cpassword[0] : null;
        }
      }
    },
    success(data) {
      this.successMsg = data.message;
      this.email = this.name = this.password = this.cpassword = null;
    },
    resetForm() {
      this.$refs.registerForm.reset();
    },
  },
};
</script>
