<template>
  <div>
    <Success v-if="success">
      You have left a review, thank you very much
    </Success>
    <FatalError v-if="error" />
    <div class="row" v-if="!success && !error">
      <div :class="[{ 'col-md-4': twoColumn }, { 'd-none': oneColumn }]">
        <div class="card">
          <div class="card-body">
            <div v-if="loading">Loading .......</div>
            <div v-if="hasBooking">
              <p>
                Stayed at
                <router-link
                  :to="{
                    name: 'bookable',
                    params: { id: booking.bookable.id },
                  }"
                  >{{ booking.bookable.title }}</router-link
                >
              </p>
              <p>From {{ booking.from }} to {{ booking.to }}</p>
            </div>
          </div>
        </div>
      </div>
      <div :class="[{ 'col-md-8': twoColumn }, { 'col-md-12': oneColumn }]">
        <div v-if="loading">Loading .......</div>
        <div v-else>
          <div v-if="alreadyReviewed">You have already reviewd.</div>
          <div v-else>
            <div class="form-group">
              <label class="text-muted"
                >Select the star rating (1 for worst - 5 for best)</label
              >
              <star-rating class="fa-3x" v-model="review.rating"></star-rating>
            </div>
            <div class="form-group">
              <label for="content" class="text-muted"
                >Describe your experience with</label
              >
              <textarea
                name="content"
                cols="30"
                rows="10"
                class="form-control"
                v-model="review.content"
                :class="[{ 'is-invalid': this.errorFor('content') }]"
              ></textarea>
              <ValidationError :errors="errorFor('content')" />
            </div>
            <button
              class="btn btn-lg btn-primary btn-block mt-2"
              @click.prevent="submit"
              :disabled="sending"
            >
              Submit
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { is404, is422 } from "./../shared/utils/response";
import validationErros from "./../shared/mixins/ValidationErros";
export default {
  mixins: [validationErros], // Mixin is use for reuse code
  data() {
    return {
      review: {
        id: null,
        rating: 5,
        content: null,
      },
      existingReview: null,
      loading: false,
      booking: null,
      error: false,
      //   errors: null, This moved to maxins
      sending: false,
      success: false,
    };
  },
  created() {
    this.review.id = this.$route.params.id;
    this.loading = true;
    axios
      .get(`/api/reviews/${this.review.id}`)
      .then((response) => {
        this.existingReview = response.data;
      })
      .catch((err) => {
        if (is404(err)) {
          return axios
            .get(`/api/booking-by-review/${this.review.id}`)
            .then((response) => {
              this.booking = response.data;
            })
            .catch((err) => {
              //   if (!is404(err)) {
              //     this.error = true;
              //   }
              this.error = !is404(err);
            });
        }
        this.error = true;
      })
      .then(() => {
        this.loading = false;
      });
  },
  computed: {
    hasErrors() {
      return 422 === this.status && this.errors != null;
    },
    alreadyReviewed() {
      return this.hasReview || !this.hasBooking;
    },
    hasReview() {
      return this.existingReview != null;
    },
    hasBooking() {
      return this.booking != null;
    },
    oneColumn() {
      return !this.loading && this.alreadyReviewed;
    },
    twoColumn() {
      return this.loading || !this.alreadyReviewed;
    },
  },
  methods: {
    submit() {
      this.errors = null;
      this.sending = true;
      this.success = false;
      axios
        .post(`/api/reviews`, this.review)
        .then((response) => {
          this.success = 201 === response.status;
        })
        .catch((err) => {
          if (is422(err)) {
            const errors = err.response.data.errors;
            // _.size is lodash library
            if (errors["content"] && _.size(errors)) {
              this.errors = errors;
              return;
            }
          }
          this.error = true;
        })
        .then(() => (this.sending = false));
    },
    // This Moved in Mixins folder for Code Reuseability
    // errorFor(field) {
    //   return null != this.errors && this.errors[field]
    //     ? this.errors[field]
    //     : null;
    // },
  },
};
</script>
