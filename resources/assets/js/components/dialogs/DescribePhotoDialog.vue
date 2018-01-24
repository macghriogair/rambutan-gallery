<template>
  <v-layout row >
    <v-dialog v-model="dialog" persistent max-width="500px">
      <v-btn class="activator-btn" fab flat small slot="activator">
        <v-icon flat>edit</v-icon>
      </v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">Describe Photo</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12>
                <v-text-field label="Description" v-model="form.description"></v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" flat @click.native="onSave">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>
<script>
  import Form from '@lib/form/Form'

  export default {

    props: [
      'photo'
    ],

    data() {
      return {
        dialog: false,
        form: new Form({
          description: null,
          id: this.photo.uuid
        })
      }
    },

    watch: {
      dialog(newValue) {
        if (true === newValue) {
          this.form.description = this.photo.description
        }
      }
    },
    methods: {
      onSave() {
        let payload = this.form.data()

        this.$store.dispatch('albums/describePhoto', payload)
          .then(() => {
            this.dialog = false
          })
      }
    }
  }
</script>
<style scoped>

  .activator-btn {
    right: 0px;
    bottom: 0px;
    position: absolute;
  }
</style>
