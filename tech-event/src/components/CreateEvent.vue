<template>
  <div class="create-event">
    <b-card>
      <h5>Buat Event</h5>

      <hr>

      <b-form ref="form" @submit.prevent="createEvent">
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
              <b-form-file v-model="image" required></b-form-file>
            </b-form-group>
          </b-col>
        </b-row>
        <div class="d-flex">
          <b-button v-if="!loading" class="mx-auto" variant="primary" type="submit">TAMBAHKAN</b-button>
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
  name: "CreateEvent",

  data: () => ({
    name: '',
    address: '',
    date: null,
    description: '',
    image: null,
    loading: false,
  }),

  methods: {
    createEvent() {
      this.loading = true

      const formData = new FormData

      formData.append('name', this.name)
      formData.append('address', this.address)
      formData.append('date', this.date)
      formData.append('description', this.description)
      formData.append('image', this.image)

      this.$http.post('event', formData).then(({data}) => {
        if (data.success) {
          this.$refs.form.reset()
          this.$emit('created')
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