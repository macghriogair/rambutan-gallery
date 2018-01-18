<template>
  <v-container fluid>
    <v-layout row>
      <v-spacer></v-spacer>
      <add-album-dialog></add-album-dialog>
    </v-layout>

    <album-grid :albums="albums"></album-grid>
  </v-container>
</template>
<script>
  import AddAlbumDialog from '@components/dialogs/AddAlbumDialog'
  import AlbumGrid from '@components/lists/AlbumGrid'

  export default {
    components: {
      AddAlbumDialog,
      AlbumGrid
    },
    computed: {
      albums() {
        return this.$store.state.albums.data
      }
    }
  }
</script>
