<template>
  <v-container>
    <loader v-if="loading"></loader>
    <template v-else>
      <v-layout row >
        <v-btn fab accent small dark color="primary" @click="onShowPicker">
          <v-icon>file_upload</v-icon>
        </v-btn>
      </v-layout>

      <photo-grid :photos="photos"></photo-grid>

      <add-photo-dialog ref="addPhoto"
        :file="file"
        :filename="filename"
        :image-url="imageUrl"
        :album-id="id"
      ></add-photo-dialog>
      <input ref="fileInput"
        type="file"
        name="file"
        accept="image/*"
        style="display:none"
        required
        @change="onFileChange"
      >
    </template>
  </v-container>
</template>
<script>
  import Loader from '@components/_shared/Loader'
  import PhotoGrid from '@components/lists/PhotoGrid'
  import AddPhotoDialog from '@components/dialogs/AddPhotoDialog'

  export default {
    components: {
      Loader,
      PhotoGrid,
      AddPhotoDialog
    },

    props: {
      id: {
        type: Number,
        required: true
      }
    },

    data() {
      return {
        file: null,
        filename: null,
        imageUrl: null
      }
    },

    computed: {
      loading() {
        return this.$store.state.albums.loading
      },
      photos() {
        return this.$store.state.albums.photos
      }
    },

    methods: {
      onShowPicker() {
        this.$refs.fileInput.click()
      },
      onFileChange() {
        console.log('I got the file')
        const files = event.target.files
        if (!files.length) {
          return
        }
        let filename = files[0].name
        if (filename.lastIndexOf('.') <= 0) {
          console.error('Invalid file.')
          return
        }
        this.filename = filename
        this.file = files[0]
        // read as base64 for preview
        const fileReader = new FileReader()
        fileReader.addEventListener('load', () => {
          this.imageUrl = fileReader.result
          this.$refs['addPhoto'].show()
        })
        fileReader.readAsDataURL(files[0])
      }
    },

    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.$store.dispatch('albums/fetchPhotos', {
          albumId: vm.id
        })
      })
    }
  }
</script>
