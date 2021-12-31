<template>
  <div class="event-list">
    <template v-if="loading" class="mb-5">
      <div class="d-flex">
        <b-spinner class="mx-auto" variant="primary"></b-spinner>
      </div>
    </template>

    <b-row>
      <b-col v-for="event in events" col xl="3" :key="event.id">
        <b-card :img-src="getImageUrl(event)" img-top>
          <h5>{{ event.name }}</h5>
          <b-card-text class="mb-1">
            <b-row>
              <b-col cols="auto" class="pr-0">
                <b-icon-map-fill class="mr-2" font-scale="1.5"></b-icon-map-fill>
              </b-col>
              <b-col class="pl-1">{{ event.address }}</b-col>
            </b-row>
          </b-card-text>
          <b-card-text>
            <b-row>
              <b-col cols="auto" class="pr-0">
                <b-icon-clock class="mr-2" font-scale="1.5"></b-icon-clock>
              </b-col>
              <b-col class="pl-1">{{ event.formatted_date }}</b-col>
            </b-row>
          </b-card-text>
          <b-card-text>{{ event.description }}</b-card-text>
          <div class="d-flex">
            <template v-if="isAdmin">
              <b-button class="manage-btn d-flex rounded-circle mr-1 ml-auto" variant="primary">
                <b-icon-search class="m-auto"></b-icon-search>
              </b-button>
              <b-button class="manage-btn d-flex text-white rounded-circle mx-1" variant="warning"
                        @click="updateEvent(event.id)">
                <b-icon-pencil class="m-auto"></b-icon-pencil>
              </b-button>
              <b-button class="manage-btn d-flex rounded-circle mx-1" variant="danger"
                        @click="showDeleteModal(event.id, event.name)">
                <b-icon-trash class="m-auto"></b-icon-trash>
              </b-button>
            </template>
            <template v-else>
              <b-button class="ml-auto" variant="primary" :to="'/event/' + event.id">LIHAT DETAIL</b-button>
            </template>
          </div>
        </b-card>
      </b-col>
    </b-row>

    <b-modal
        size="sm"
        title="Hapus Event"
        header-border-variant="white"
        header-class="pb-0"
        footer-border-variant="white"
        footer-class="pt-0"
        ok-title="YA"
        cancel-title="BATAL"
        cancel-variant="danger"
        hide-header-close
        centered
        :visible="deleteModal"
        @ok="deleteEvent"
        @cancel="hideDeleteModal">
      Apakah anda yakin ingin menghapus event {{ deleteEventNameModal }} ?
    </b-modal>
  </div>
</template>

<script>
export default {
  name: "EventList",

  data: () => ({
    events: [],
    selectedId: null,
    deleteModal: false,
    deleteEventNameModal: '',
    loading: false,
  }),

  created() {
    this.getEvents()
  },

  methods: {
    getImageUrl(event) {
      return this.$http.defaults.baseURL + 'uploads/' + event.image_url
    },

    getEvents() {
      this.loading = true
      this.events = []

      this.$http.get('event').then(({data}) => {
        this.events = data.data
      }).catch(err => {
        console.log(err)
      }).then(() => {
        this.loading = false
      })
    },

    showDeleteModal(id, name) {
      this.selectedId = id
      this.deleteEventNameModal = name
      this.deleteModal = true
    },

    hideDeleteModal() {
      this.selectedId = null
      this.deleteEventNameModal = ''
      this.deleteModal = false
    },

    deleteEvent() {
      if (this.selectedId !== null) {
        this.loading = true

        this.$http.post('event/delete/' + this.selectedId).then(() => {
          this.getEvents()
        }).catch(err => {
          console.log(err)
        }).then(() => {
          this.loading = false
          this.deleteEventNameModal = ''
          this.deleteModal = false
        })
      }
    },

    updateEvent(id) {
      this.$emit('update', id)
    }
  }
}
</script>

<style scoped>
.card-text {
  font-size: 0.9rem;
}

.manage-btn {
  width: 35px;
  height: 35px;
  padding: 0;
}
</style>