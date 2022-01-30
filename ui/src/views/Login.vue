<template>
  <div class="row">
    <div class="col">
      <section class="vh-100">
        <div class="container py-5 h-100">
          <div class="row d-flex align-items-center justify-content-center">
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
              <form class="" @submit.prevent="login">
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

                <div class="d-flex justify-content-around align-items-center">
                  <button
                    type="submit"
                    class="btn btn-primary btn-lg btn-block"
                  >
                    Sign in
                  </button>
                  <router-link :to="{ name: 'Register' }">
                    New User? Register here..
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
import { login } from './../api-urls';
export default {
  data() {
    return {
      email: null,
      password: null,
      errors: this.defaultError(),
    };
  },
  created() {},
  methods: {
    defaultError() {
      return {
        email: null,
        password: null,
      };
    },
    async login() {
      this.errors = this.defaultError();
      try {
        const response = await this.axios.post(login, {
          email: this.email,
          password: this.password,
        });
        if (response.status == 200) {
          this.success(response.data);
        }
      } catch (error) {
        console.log(error);
        if (error.response?.status == 422) {
          const errors = error.response.data.errors;
          this.errors.email = errors.email ? errors.email[0] : null;
          this.errors.password = errors.password ? errors.password[0] : null;
        }
      }
    },
    success(data) {
      window.localStorage.setItem('token', data.data.token);
      this.$router.push({ name: 'CarsList' });
    },
  },
};
</script>
