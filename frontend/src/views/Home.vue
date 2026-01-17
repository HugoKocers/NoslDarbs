<template>
  <v-container class="py-12">
    <v-row class="align-center">
      <v-col cols="12" md="6">
        <h1 class="text-h3 font-weight-bold mb-6">Master the Cards</h1>
        <p class="text-h6 mb-6">
          Dive into an epic battle of strategy and skill. Collect powerful cards, build your ultimate deck, and dominate the arena.
        </p>
        <v-btn size="large" color="primary" to="/cards">See Cards</v-btn>
        <v-btn size="large" variant="outlined" class="ms-4" to="/play">Start Playing</v-btn>
      </v-col>
      <v-col cols="12" md="6">
        <v-img
          src="https://images.unsplash.com/photo-1511512578047-dfb367046420?w=800&h=1000&fit=crop"
          alt="Card Game"
          class="rounded-lg"
        ></v-img>
      </v-col>
    </v-row>

    <v-row class="mt-16">
      <v-col cols="12">
        <h2 class="text-h4 font-weight-bold text-center mb-8">Featured Cards</h2>
      </v-col>
      <v-col cols="12" sm="6" md="4" v-for="card in featuredCards" :key="card.id">
        <v-card class="h-100">
          <v-card-title>{{ card.name }}</v-card-title>
          <v-card-text>
            <p>{{ card.description }}</p>
            <p class="text-caption text-grey">Power: {{ card.power }}</p>
          </v-card-text>
          <v-card-actions>
            <v-btn color="primary" text>View</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'Home',
  data() {
    return {
      featuredCards: [
        {
          id: 1,
          name: 'Fire Dragon',
          description: 'Unleash devastating flames upon your enemies with this legendary card.',
          power: 85
        },
        {
          id: 2,
          name: 'Ice Wizard',
          description: 'Freeze your opponent\'s deck with powerful cryogenic magic.',
          power: 78
        },
        {
          id: 3,
          name: 'Shadow Knight',
          description: 'Strike from the darkness with enhanced damage multipliers.',
          power: 82
        }
      ]
    }
  }
}
</script>
