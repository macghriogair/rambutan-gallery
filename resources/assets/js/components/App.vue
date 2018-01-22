<template>
  <v-app dark>
    <v-navigation-drawer
      clipped
      fixed
      v-model="sideNav"
      app
    >
      <v-list dense>
        <v-list-tile :to="{ name: 'dashboard' }">
          <v-list-tile-action>
            <v-icon>dashboard</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>Dashboard</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile @click="">
          <v-list-tile-action>
            <v-icon>settings</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>Settings</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar app fixed clipped-left height="45">
      <v-toolbar-side-icon @click.stop="sideNav = !sideNav"></v-toolbar-side-icon>
      <v-toolbar-title>
        <router-link to="/"  tag="span" style="cursor: pointer"> Rambutan Gallery</router-link>
      </v-toolbar-title>
    </v-toolbar>
    <v-content>
      <notification ref="notification"></notification>
      <router-view></router-view>
    </v-content>
    <v-footer app fixed class="text-xs-right">
      <v-spacer></v-spacer>
      <span>&copy; 2018</span>
    </v-footer>
  </v-app>
</template>
<script>
  import Notification from '@components/_shared/Notification'

  export default {
    components: {
      Notification
    },
    data() {
      return {
        sideNav: false
      }
    },
    methods: {
      listen() {

        window.socket.on(
          'test-channel:App\\Events\\ReadPhotoChanged',
          (message) => {
            console.log('I received a Broadcast for Photo:', message)
            this.$store.commit('albums/updatePhoto', message.photo)
          })

        window.socket.on('test-channel:App\\Events\\ReadAlbumChanged',
          (message) => {
            console.log('I received a Broadcast for Album:', message)
            this.$store.commit('albums/updateAlbum', message.album)
          })
      }
    },
    mounted() {
      window.Bus.$on('ajax-error', (event) => {
        this.$refs.notification.success = false
        this.$refs.notification.text = event.text
        this.$refs.notification.show = true
      })
      window.Bus.$on('ajax-success', (event) => {
        this.$refs.notification.success = true
        this.$refs.notification.text = event.text
        this.$refs.notification.show = true
      })

      this.$store.dispatch('albums/fetch')

      this.listen()
    }
  }
</script>
