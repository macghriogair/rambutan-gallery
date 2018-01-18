<template>
  <v-snackbar light style="top: 75px;"
    :success="success"
    :error="!success"
    left
    top
    :timeout="timeout"
    v-model="show"
   >
    {{ text }}
  <v-btn dark flat @click.native="show = false">Close</v-btn>
  </v-snackbar>
</template>
<script>
  export default {
    data () {
      return {
        show: false,
        timeout: 2000,
        success: true,
        text: 'Hello, I\'m a snackbar'
      }
    }
  }
</script>

