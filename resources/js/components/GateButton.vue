<template>
  <div class="mt-2">
    <h6>{{ title }}</h6>
    <button class="btn bg-warning fw-bold" style="padding: 10px 50px;" :disabled="isLoading" @click="handleClick">
      Открыть
    </button>
    <hr/>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true,
    },
    gateId: {
      type: Number,
      required: true,
    },
    isLoading: {
      type: Boolean,
      required: true,
    },
  },
  methods: {
    handleClick() {
      this.$emit('open-gate', this.gateId);
    },
  },
};
</script>
