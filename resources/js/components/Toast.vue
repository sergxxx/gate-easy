<template>
	<div v-if="show" class="d-flex justify-content-center align-items-center w-100 position-fixed" style="top: 5px;">
		<div class="toast show bg-warning">
			<div class="toast-body" style="padding: 7px 0; text-align: center;">
        {{ message }}
			</div>
		</div>
	</div>
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      required: true,
    },
    message: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>
.toast {
  transition: opacity 0.5s ease;
}
</style>
