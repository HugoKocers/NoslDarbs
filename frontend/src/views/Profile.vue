<template>
  <v-container class="py-12">
    <h1 class="text-h4 mb-6">User Profile</h1>
    <v-row>
      <v-col cols="12" md="4">
        <v-card>
          <v-card-title>Profile Info</v-card-title>
          <v-card-text>
            <p><strong>Username:</strong> Player123</p>
            <p><strong>Level:</strong> 25</p>
            <p><strong>Win Rate:</strong> 68%</p>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="8">
        <v-card>
          <v-card-title>Statistics</v-card-title>
          <v-card-text>
            <p>Total Battles: 156</p>
            <p>Cards Collected: 342</p>
            <p>Decks Created: 12</p>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'Profile'
}
</script>
