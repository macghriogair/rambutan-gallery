<template>
  <v-flex xs12 sm4 md3 lg2>
    <v-card flat tile hover height="120"
      :to="{name: 'album.show', params: { id: album.id }}"
    >
      <v-container fill-height fluid>
          <v-layout fill-height>
            <v-flex xs12 align-end flexbox>
              <span class="headline">{{ album.name }}</span>
              <p>{{ album.description }}</p>
              <span class="text-xs-right counter orange--text">{{ album.photo_count }}</span>
            </v-flex>
          </v-layout>
      </v-container>
    </v-card>
  </v-flex>
</template>
<script>
  export default {
    props: {
      album: {
        type: Object,
        required: true
      }
    }
  }
</script>
<style scoped>
  .counter {
    position: absolute;
    right: 0.2em;
    bottom: 0.2em;
  }
</style>
