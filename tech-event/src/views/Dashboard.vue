<template>
  <div class="dashboard p-5">
    <b-row v-if="isAdmin" class="mb-5">
      <b-col class="mx-auto" col xl="8">
        <create-event v-show="updateID === null" @created="getEvent"></create-event>
        <update-event v-show="updateID !== null" @updated="getEvent" ref="updateForm"></update-event>
      </b-col>
    </b-row>

    <event-list ref="eventList" @update="showUpdateEvent"></event-list>
  </div>
</template>

<script>
import EventList from "@/components/EventList";
import CreateEvent from "@/components/CreateEvent";
import UpdateEvent from "@/components/UpdateEvent";

export default {
  name: "Dashboard",

  data() {
    return {
      updateID: null,
    }
  },

  components: {UpdateEvent, CreateEvent, EventList},

  mounted() {
    console.log(this.showForm)
  },

  methods: {
    getEvent() {
      this.$refs.eventList.getEvents()
    },

    showUpdateEvent(id) {
      this.updateID = id
      this.$refs.updateForm.getEvent(id)
    },
  }
}
</script>

<style scoped>

</style>