<template>
  <div id="app">
    <b-navbar v-show="!hideNavbar" variant="primary" type="dark" sticky>
      <img class="logo mr-2" src="/logo.png" alt="Logo">

      <b-navbar-brand to="/">Tech Event</b-navbar-brand>

      <b-nav-form>
        <b-form-input type="text" placeholder="Cari event"></b-form-input>
      </b-nav-form>

      <b-navbar-nav class="ml-auto">
        <template v-if="user == null">
          <b-nav-item class="mx-1" to="/login">LOGIN</b-nav-item>
          <b-nav-item class="mx-1" to="/register">DAFTAR</b-nav-item>
        </template>
        <template v-else>
          <b-button class="profile-btn d-flex" @click="showProfile = !showProfile">
            <b-icon-person-circle class="m-auto" font-scale="2"></b-icon-person-circle>
          </b-button>
          <div v-if="showProfile" class="profile shadow-sm p-3">
            <div class="row mb-3">
              <div class="col-3">
                <b-icon-person-fill font-scale="2"></b-icon-person-fill>
              </div>
              <div class="col-9">
                {{ user.email }}
              </div>
            </div>
            <div class="d-flex">
              <b-button variant="danger" class="ml-auto" @click="logout">LOGOUT</b-button>
            </div>
          </div>
        </template>
      </b-navbar-nav>
    </b-navbar>

    <router-view/>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showProfile: false,
      user: null
    }
  },

  computed: {
    hideNavbar() {
      return this.$route.meta.hideNavbar
    },
  },

  watch: {
    $route() {
      if (localStorage.getItem('email') !== null) {
        this.user = this.getUser
      }

      this.showProfile = false
    }
  },

  created() {
    this.$http.get('event')
  },

  methods: {
    logout() {
      localStorage.clear()

      this.user = null

      if (this.$route.name !== 'Dashboard') {
        this.$router.push('/')
      }
    }
  }
}
</script>

<style lang="scss">
.navbar {
  font-weight: 500;
  position: relative;

  .logo {
    width: 50px;
    height: 50px;
  }

  .nav-link {
    color: #ffffff !important;
    border-radius: 5px;

    &:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
  }

  .profile-btn {
    width: 40px;
    height: 40px;
    padding: 0 !important;
    border-radius: 50% !important;
    background-color: transparent !important;
    border: none !important;

    &:hover {
      background-color: rgba(255, 255, 255, 0.1) !important;
    }
  }

  .profile {
    position: absolute;
    background-color: #ffffff;
    right: 5px;
    bottom: -120px;
  }
}

.btn, .nav-link {
  font-size: 0.9rem !important;
  font-weight: 600 !important;
  transition: 500ms !important;
  letter-spacing: 0.5px;
}

input, textarea {
  border-radius: 3px !important;
}

input {
  padding-top: 20px !important;
  padding-bottom: 20px !important;
}

.modal-backdrop {
  background-color: rgba(0, 0, 0, 0.5) !important;
}

.modal {

}
</style>
