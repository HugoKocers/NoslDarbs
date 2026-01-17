<template>
  <v-app>
    <v-app-bar color="primary" dark>
      <v-app-bar-title>NoslDarbs - CardQuest</v-app-bar-title>
      <v-spacer></v-spacer>
      <v-btn text to="/">Home</v-btn>
      <v-btn text to="/cards">Cards</v-btn>
      <v-btn text to="/play">Play</v-btn>
      <v-btn text to="/profile">Profile</v-btn>
    </v-app-bar>

    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: 'App',
}
</script>

<style scoped>
</style>
