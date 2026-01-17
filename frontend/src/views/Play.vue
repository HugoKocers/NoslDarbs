<template>
  <v-container class="py-12">
    <h1 class="text-h4 mb-6">Battle Arena</h1>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-title>Select Opponent</v-card-title>
          <v-card-text>
            <p>Choose from available players to start a battle.</p>
          </v-card-text>
          <v-card-actions>
            <v-btn color="primary">Find Opponent</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'Play'
}
</script>
