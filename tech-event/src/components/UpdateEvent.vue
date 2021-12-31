<template>
  <div class="update-event">
    <b-card>
      <h5>Edit Event</h5>

      <hr>

      <b-form ref="form" @submit.prevent="updateEvent">
        <b-row>
          <b-col>
            <b-form-group label="Nama Event">
              <b-form-input v-model="name" type="text" required></b-form-input>
            </b-form-group>
            <b-form-group label="Deskripsi Event">
              <b-textarea v-model="description" required></b-textarea>
            </b-form-group>
            <b-form-group label="Tanggal Pelaksanaan">
              <b-form-input v-model="date" type="date" required></b-form-input>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group label="Alamat">
              <b-textarea v-model="address" required></b-textarea>
            </b-form-group>
            <b-form-group label="Gambar">
              <b-form-file v-model="image"></b-form-file>
            </b-form-group>
          </b-col>
        </b-row>
        <div class="d-flex">
          <b-button v-if="!this.loading" class="mx-auto" variant="primary" type="submit">EDIT</b-button>
          <b-button v-else class="mx-auto" type="submit" variant="primary" disabled>
            <b-spinner small></b-spinner>
          </b-button>
        </div>
      </b-form>
    </b-card>
  </div>
</template>

<script>
export default {
  name: "UpdateEvent",

  data: () => ({
    id: null,
    name: '',
    address: '',
    date: null,
    description: '',
    image: null,
    loading: false,
  }),

  methods: {
    getEvent(id) {
      this.loading = true

      this.$http.get('/event/' + id, {
        params: {
          user_id: localStorage.getItem('id')
        }
      }).then(({data}) => {
        this.id = data.id
        this.name = data.name
        this.address = data.address
        this.date = data.date
        this.description = data.description
      }).catch(err => {
        console.log(err)
      }).then(() => {
        this.loading = false
      })
    },

    updateEvent() {
      this.loading = true

      const formData = new FormData

      formData.append('name', this.name)
      formData.append('address', this.address)
      formData.append('date', this.date)
      formData.append('description', this.description)

      if (this.image !== null) {
        formData.append('image', this.image)
      }

      this.$http.post('event/update/' + this.id, formData).then(({data}) => {
        if (data.success) {
          this.$refs.form.reset()
          this.$emit('updated')
        }
      }).catch(err => {
        console.log(err)
      }).then(() => {
        this.loading = false
      })
    }
  }
}
</script>

<style scoped>

</style>