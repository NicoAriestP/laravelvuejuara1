import Vue from 'vue'

Vue.mixin({
  computed: {
    isAdmin() {
      return localStorage.getItem('role_id') === '1'
    },

    getUser() {
      if (!localStorage.getItem('email')) {
        return null
      }

      return {
        email: localStorage.getItem('email'),
        role: localStorage.getItem('role_id')
      }
    }
  }
})