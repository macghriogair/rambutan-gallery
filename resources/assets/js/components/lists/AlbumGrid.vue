<template>
  <v-layout row wrap>
    <v-flex xs12>
      <v-container fluid grid-list-lg>
        <v-layout row wrap>
          <album-grid-item
            v-for="album in albums"
            :key="album.id"
            :album="album"
          ></album-grid-item>
        </v-layout>
      </v-container>
    </v-flex>
  </v-layout>
</template>
<script>
  import AlbumGridItem from './AlbumGridItem'

  export default {
    components: {
      AlbumGridItem
    },
    props: {
      albums: {
        type: Array,
        default: () => new Array()
      }
    }
  }
</script>
