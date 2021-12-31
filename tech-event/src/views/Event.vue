<template>
  <div class="event p-5">
    <div v-if="loading" class="d-flex mb-5">
      <b-spinner class="mx-auto" variant="primary"></b-spinner>
    </div>
    <template v-else>
      <b-button variant="primary" class="mb-3" @click="$router.back()">
        <b-icon-arrow-left></b-icon-arrow-left>
        Kembali
      </b-button>
      <b-card :img-src="getImageUrl() + image" img-top>
        <h4 class="mb-3">{{ name }}</h4>
        <b-row class="mb-3">
          <b-col cols="6">
            <b-row>
              <b-col cols="auto">
                <b-icon-map-fill></b-icon-map-fill>
              </b-col>
              <b-col col>
                {{ address }}
              </b-col>
            </b-row>
          </b-col>
          <b-col cols="6">
            <b-row>
              <b-col cols="auto">
                <b-icon-clock></b-icon-clock>
              </b-col>
              <b-col col>
                {{ date }}
              </b-col>
            </b-row>
          </b-col>
        </b-row>
        <b-card-text>{{ description }}</b-card-text>
        <div v-if="getUser && !joined" class="d-flex">
          <b-button variant="primary" class="ml-auto" @click="join">JOIN</b-button>
        </div>
      </b-card>
    </template>
  </div>
</template>

<script>
export default {
  name: "Event.vue",

  data: () => ({
    name: '',
    address: '',
    date: '',
    description: '',
    image: '',
    loading: false,
    joined: false
  }),

  computed: {
    id() {
      return this.$route.params.id
    }
  },

  created() {
    this.getEvent()
  },

  methods: {
    getImageUrl() {
      return this.$http.defaults.baseURL + 'uploads/'
    },

    getEvent() {
      this.loading = true

      this.$http.get('/event/' + this.id, {
        params: {
          user_id: localStorage.getItem('id')
        }
      }).then(({data}) => {
        this.name = data.name
        this.address = data.address
        this.date = data.formatted_date
        this.description = data.description
        this.image = data.image_url;
        this.joined = data.joined
      }).catch(err => {
        console.log(err)
      }).then(() => {
        this.loading = false
      })
    },

    join() {
      this.loading = true

      this.$http.post('event/join', {
        user_id: localStorage.getItem('id'),
        event_id: this.id,
      }).then(() => {
        this.joined = true
      }).catch(err => {
        console.log(err)
      }).then(() => {
        this.loading = false
        this.joined = true
      })
    }
  }
}
</script>

<style scoped>
img {
  width: 100%;
  height: 300px;
  object-fit: cover;
}
</style>