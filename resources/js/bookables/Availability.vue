<template>
  <div>
    <h6 class="text-uppercase text-secondary font-weight-bolder">
      Check Availability
      <span v-if="noAvailability" class="text-danger">(Not Available)</span>
      <span v-if="hasAvailability" class="text-success">(Available)</span>
    </h6>
    <div class="form-row mb-3">
      <div class="form-group col-md-6">
        <label for="from">From</label>
        <input
          type="date"
          name="from"
          class="form-control form-control-sm"
          placeholder="start date"
          v-model="from"
          @keyup.enter="check()"
          :class="[{ 'is-invalid': this.errorFor('from') }]"
        />
        <ValidationError :errors="errorFor('from')" />
      </div>
      <div class="form-group col-md-6">
        <label for="to">To</label>
        <input
          type="date"
          name="to"
          class="form-control form-control-sm"
          placeholder="end date"
          v-model="to"
          @keyup.enter="check()"
          :class="[{ 'is-invalid': this.errorFor('to') }]"
        />
        <ValidationError :errors="errorFor('to')" />
      </div>
    </div>
    <button
      type="button"
      class="btn btn-secondary btn-block"
      @click="check()"
      :disabled="loading"
    >
      Check!
    </button>
  </div>
</template>

<script>
import validationErros from "./../shared/mixins/ValidationErros";
export default {
  mixins: [validationErros], // Mixin is use for reuse code
  props: {
    BookableId: String,
  },
  data() {
    return {
      from: null,
      to: null,
      loading: false,
      status: null,
      //   errors: null,
    };
  },
  methods: {
    check() {
      this.loading = true;
      this.errors = null;
      axios
        .get(
          `/api/bookables/${this.BookableId}/availability?from=${this.from}&to=${this.to}`
        )
        .then((response) => {
          this.status = response.status;
        })
        .catch((err) => {
          if (422 === err.response.status) {
            this.errors = err.response.data.errors;
          }
          this.status = err.response.status;
        })
        .then(() => (this.loading = false));
    },
    // errorFor(field) {
    //   return this.hasErrors && this.errors[field] ? this.errors[field] : null;
    // },
  },
  computed: {
    hasErrors() {
      return 422 === this.status && this.errors != null;
    },
    hasAvailability() {
      return 200 === this.status;
    },
    noAvailability() {
      return 404 === this.status;
    },
  },
};
</script>

<style scoped>
label {
  font-size: 0.7rem;
  text-transform: uppercase;
  color: gray;
  font-weight: bolder;
}
</style>
