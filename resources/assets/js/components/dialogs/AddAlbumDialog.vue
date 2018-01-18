<template>
  <v-layout row>
    <v-dialog v-model="dialog" persistent max-width="500px">
      <v-btn color="primary" fab accent small dark slot="activator">
        <v-icon flat>add</v-icon>
      </v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">Add Album</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
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
      onSave() {
        const payload = this.form.data()

        this.$store.dispatch('albums/store', payload)
          .then(() => {
            this.dialog = false
            this.form.errors.clear()
          })
          .catch((error) => {
            if (422 === error.response.status)
              this.form.errors.record(error.response.data.errors)
          })

      }
    }
  }
</script>
