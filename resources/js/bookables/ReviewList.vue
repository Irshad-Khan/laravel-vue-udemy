<template>
  <div style="padding: 1.25rem">
    <h6 class="text-uppercase text-secondary font-weight-bolder pt-4">
      Review List
    </h6>
    <div v-if="loading">Loading .....</div>
    <div v-else>
      <div
        class="border-bottom d-none d-md-block"
        v-for="review in reviews"
        :key="'review' + review.id"
      >
        <div class="row pt-4">
          <div class="col-md-6">Irshad Khan</div>
          <div class="col-md-6 d-flex justify-content-end">
            <StarRating :rating="review.rating" class="fa-lg" />
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">{{ review.created_at | fromNow }}</div>
        </div>
        <div class="row pt-4 pb-4">
          <div class="col-md-12">{{ review.content }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import moment from "moment";
export default {
  props: {
    BookableId: String,
  },
  data() {
    return {
      loading: false,
      reviews: null,
    };
  },
  created() {
    this.loading = true;
    axios
      .get(`/api/bookables/${this.BookableId}/reviews`)
      .then((response) => {
        this.reviews = response.data;
        this.loading = false;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  //   filters: {
  //     fromNow(value) {
  //       return moment(value).fromNow();
  //     },
  //   },
};
</script>
