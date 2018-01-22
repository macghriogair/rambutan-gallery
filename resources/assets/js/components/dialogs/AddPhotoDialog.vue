<template>
  <v-layout row >
    <v-dialog v-model="dialog" persistent max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Add Photo</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12>
                <span v-if="filename" v-text="filename"></span>
              </v-flex>

              <v-flex xs12 class="mb-2">
                <img :src="imageUrl" height="200px">
              </v-flex>

              <v-flex xs12>
                <v-text-field label="Name" required v-model="form.name"></v-text-field>
                <v-text-field label="Description" v-model="form.description"></v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
          <small>*required</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" flat @click.native="onSave">Add</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>
<script>
  import Form from '@lib/form/Form'

  export default {
    props: [
      'file', 'filename', 'imageUrl', 'albumId'
    ],
    data() {
      return {
        dialog: false,
        form: new Form({
          name: null,
          description: null
        })
      }
    },

    methods: {
      show() {
        this.dialog = true
        this.form.name = this.filename
      },
      onSave() {
        let payload = this.form.data()

        if (this.file) {
          payload.file = this.file
        }
        if (this.albumId) {
          payload.albumId = this.albumId
        }

        this.$store.dispatch('albums/storePhoto', payload)
          .then(() => {
            this.dialog = false
          })
      }
    }
  }
</script>
