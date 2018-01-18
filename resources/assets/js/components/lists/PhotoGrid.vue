<template>
  <v-layout row wrap>
    <v-flex xs12>
      <v-container fluid grid-list-lg >
        <v-layout row wrap>
          <photo-grid-item
            v-for="photo in photos"
            :key="photo.id"
            :photo="photo"
          ></photo-grid-item>
          <v-flex xs12 text-xs-center v-if="photos.length < 1">
            <span>No photos yet.</span>
          </v-flex>
        </v-layout>
      </v-container>
    </v-flex>
  </v-layout>
</template>
<script>
  import PhotoGridItem from './PhotoGridItem'

  export default {
    components: {
      PhotoGridItem
    },
    props: {
      photos: {
        type: Array,
        default: () => new Array()
      }
    }
  }
</script>
