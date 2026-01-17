<template>
  <v-container class="py-12">
    <h1 class="text-h4 mb-6">Card Collection</h1>
    <v-row>
      <v-col cols="12" sm="6" md="4">
        <v-text-field
          v-model="search"
          label="Search cards..."
          prepend-icon="mdi-magnify"
          clearable
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="6" md="4" lg="3" v-for="i in 12" :key="i">
        <v-card>
          <v-img
            src="https://images.unsplash.com/photo-1559056199-641a0ac8b3f2?w=400&h=500&fit=crop"
            aspect-ratio="2/3"
          ></v-img>
          <v-card-title>Card {{ i }}</v-card-title>
          <v-card-text>
            <p class="text-caption">Power: 75 | Cost: 5</p>
          </v-card-text>
          <v-card-actions>
            <v-btn size="small" color="primary">Add to Deck</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'Cards',
  data() {
    return {
      search: ''
    }
  }
}
</script>
