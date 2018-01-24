<template>
  <v-flex xs12 sm4>
    <v-card flat tile hover height="120">
      <v-container fill-height fluid>
          <v-layout fill-height>
            <v-flex xs12 align-end flexbox>
              <span class="green--text">{{ photo.name }}</span>
              <p>
                {{ photo.description }}
              </p>
              <describe-photo-dialog :photo="photo"></describe-photo-dialog>
            </v-flex>
          </v-layout>
      </v-container>
    </v-card>
  </v-flex>
</template>
<script>
  import DescribePhotoDialog from '@components/dialogs/DescribePhotoDialog'

  export default {
    components: {
      DescribePhotoDialog
    },
    props: {
      photo: {
        type: Object,
        required: true
      }
    }
  }
</script>
