<template>
  <v-container class="py-12 text-center">
    <v-row>
      <v-col cols="12">
        <h1 class="text-h3 mb-4">404 - Page Not Found</h1>
        <p class="text-h6 mb-8">Sorry, the page you're looking for doesn't exist.</p>
        <v-btn color="primary" to="/">Go Home</v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>
