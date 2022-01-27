<template>
  <div class="row">
    <div class="col-md-6 mb-3">
      <div class="card w-100">
        <div class="card-body">
          <div v-if="!loading">
            <h5 class="card-title">{{ bookable.title }}</h5>
            <hr />
            <p class="card-text">
              {{ bookable.description }}
            </p>
          </div>
          <div v-else>Loading .......</div>
        </div>
      </div>
      <ReviewList :BookableId="this.$route.params.id" />
    </div>
    <div class="col-md-6">
      <Availability :BookableId="this.$route.params.id" />
    </div>
  </div>
</template>

<script>
import Availability from "./Availability";
import ReviewList from "./ReviewList";
export default {
  components: {
    Availability,
    ReviewList,
  },
  data() {
    return {
      bookable: null,
      loading: false,
    };
  },
  created() {
    this.loading = true;
    // if we use resource classes then we use response.data.data we can remove 1 data freom resonse7
    // like response.data the we add  JsonResource::withoutWrapping(); in Boot method of AppServiceProvder
    // If we can not use in AppServiceProvider the use response.data.data
    axios.get(`/api/bookables/${this.$route.params.id}`).then((response) => {
      this.bookable = response.data;
      this.loading = false;
    });
  },
};
</script>
