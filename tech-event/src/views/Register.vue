<template>
  <div class="register d-flex flex-column">
    <div class="background bg-primary"></div>
    <b-row class="my-auto" no-gutters>
      <b-col class="mx-auto" col xl="4">
        <b-card class="text-center">
          <img class="logo" src="/logo.png" alt="Logo">
          <b-card-title class="text-primary mb-4">Tech Event</b-card-title>

          <b-form class="text-left px-4" @submit.prevent="register">
            <b-alert variant="danger" :show="warning.length > 0" dismissible>{{ warning }}</b-alert>

            <b-form-group label="Email">
              <b-form-input v-model="email" type="email" required></b-form-input>
            </b-form-group>
            <b-form-group label="Password">
              <b-form-input v-model="password" type="password" required></b-form-input>
            </b-form-group>
            <b-form-group label="Konfirmasi Password">
              <b-form-input v-model="passwordConfirmation" type="password" required></b-form-input>
            </b-form-group>
            <b-form-checkbox class="mb-3" v-model="admin">Daftar sebagai admin</b-form-checkbox>
            <b-button v-if="!this.loading" class="mb-2" type="submit" variant="primary" block>DAFTAR</b-button>
            <b-button v-else class="mb-2" type="submit" variant="primary" block>
              <b-spinner small></b-spinner>
            </b-button>
            <div class="d-flex">
              <span class="my-auto ml-auto mr-1">Sudah pernah daftar ?</span>
              <b-button class="login-btn text-primary mr-auto ml-1" to="/login">Login disini</b-button>
            </div>
          </b-form>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  data: () => ({
    email: '',
    password: '',
    passwordConfirmation: '',
    loading: false,
    admin: false,
    warning: '',
  }),

  name: 'Register',

  methods: {
    validatePassword() {
      return this.password === this.passwordConfirmation
    },

    register: function () {
      if (!this.validatePassword()) {
        this.warning = 'Password yang dimasukkan tidak sesuai'
      }

      this.error = ''
      this.loading = true

      const formData = new FormData

      formData.append('email', this.email)
      formData.append('password', this.password)
      formData.append('role_id', this.admin ? 1 : 2)

      this.$http.post('register', formData).then(({data}) => {
        if (data.success) {
          localStorage.setItem('id', data.data.id)
          localStorage.setItem('email', data.data.email)
          localStorage.setItem('role_id', data.data.role_id)
          localStorage.setItem('api_token', data.data.api_token)

          this.$router.push('/')
        } else {
          this.warning = data.message
          this.loading = false
        }
      }).catch(err => {
        console.log(err)
        this.loading = false
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.register {
  height: 100vh;
}

.background {
  position: absolute;
  width: 100vw;
  height: 50vh;
}

.logo {
  width: 50px;
  height: 50px;
}

.login-btn {
  background-color: #ffffff;
  border: none;

  &:hover {
    background-color: rgba(0, 0, 0, 0.1);
  }

  &:active {
    background-color: rgba(0, 0, 0, 0.1) !important;
    border: none;
  }
}
</style>