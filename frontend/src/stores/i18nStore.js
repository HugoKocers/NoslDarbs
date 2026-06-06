import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useI18nStore = defineStore('i18n', () => {
  const language = ref(localStorage.getItem('language') || 'EN')

  const translations = {
    EN: {
      // Navigation
      home: 'Home',
      cards: 'Cards',
      leaderboard: 'Leaderboard',
      play: 'Play',
      profile: 'Profile',
      admin: 'Admin',
      login: 'Login',
      signup: 'Sign Up',
      myProfile: 'My Profile',
      logout: 'Logout',
      
      // Footer
      cardquest: 'CardQuest',
      dominateArena: 'Master the cards, dominate the arena',
      quickLinks: 'Quick Links',
      gameInfo: 'Game Info',
      community: 'Community',
      rules: 'Rules',
      strategyGuide: 'Strategy Guide',
      faq: 'FAQ',
      discord: 'Discord',
      twitter: 'Twitter',
      github: 'GitHub',
      copyright: '© 2026 CardQuest. Made by Hugo.',
      
      // Home page
      infiniteFlipGame: 'INFINITE FLIP GAME',
      flipCards: 'Flip cards, discover new ones, and build your collection. Simple, fun, endlessly replayable.',
      viewCollection: 'VIEW COLLECTION',
      playGame: 'PLAY GAME',
      cardsCount: '30+',
      cardsLabel: 'CARDS',
      raritiesCount: '6',
      raritiesLabel: 'RARITIES',
      flipsCount: '∞',
      flipsLabel: 'FLIPS',
      featuredCards: 'FEATURED CARDS',
      discoverCards: "Discover what's waiting",
      howItWorks: 'HOW IT WORKS',
      simpleAndFun: 'Simple and Fun',
      startFlipping: 'START FLIPPING!',
      flipDiscoverEnjoy: 'Flip cards, discover new ones, and enjoy the simplicity',
      playNow: 'PLAY NOW',
      simpleInfinite: 'SIMPLE & INFINITE',
      gameAbout: 'CardQuest is a game about discovery. Flip cards, earn randomized points, and gradually uncover your complete card collection. With infinitely looping gameplay, there\'s always another card to flip and points to earn.',
      gameplay: 'GAMEPLAY',
      rngCardFlip: 'RNG Card Flip',
      cardsCountLabel: 'Unique Cards',
      elementsLabel: 'Elemental Types',
      flipDiscover: 'FLIP & DISCOVER',
      flipDiscoverDesc: 'Flip cards to earn random points and discover new cards',
      infiniteGameplay: 'INFINITE GAMEPLAY',
      infiniteGameplayDesc: 'Endlessly replayable card flipping with no limits',
      buildCollection: 'BUILD COLLECTION',
      buildCollectionDesc: 'Unlock cards through gameplay and track your discoveries',
      trackProgressTitle: 'TRACK PROGRESS',
      trackProgressDesc: 'Monitor your scores, games played, and collection status',
      
      // Login page
      signInToCardQuest: 'Sign In to CardQuest',
      email: 'Email',
      password: 'Password',
      signIn: 'Sign In',
      noAccount: "Don't have an account?",
      createOne: 'Create one here',
      
      // Signup page
      createAccount: 'Create Account',
      username: 'Username',
      confirmPassword: 'Confirm Password',
      signUp: 'Sign Up',
      alreadyHaveAccount: 'Already have an account?',
      
      // Play page
      playerProfile: 'PLAYER PROFILE',
      trackProgress: 'Track your progress and collection',
      gamesPlayed: 'GAMES PLAYED',
      highScore: 'HIGH SCORE',
      totalPoints: 'TOTAL POINTS',
      yourCollection: 'YOUR COLLECTION',
      cardsDiscovered: 'CARDS DISCOVERED',
      collectMore: 'Collect more by playing!',
      averageScore: 'AVERAGE SCORE',
      perGame: 'Per game average',
      
      // Cards page
      allCards: 'ALL CARDS',
      browseCollection: 'Browse your card collection',
      common: 'Common',
      uncommon: 'Uncommon',
      rare: 'Rare',
      epic: 'Epic',
      legendary: 'Legendary',
      locked: 'LOCKED',
      unlocked: 'UNLOCKED'
    },
    LV: {
      // Navigation
      home: 'Sākums',
      cards: 'Kārtis',
      leaderboard: 'Līderu saraksts',
      play: 'Spēlēt',
      profile: 'Profils',
      admin: 'Admins',
      login: 'Ieiet',
      signup: 'Reģistrēties',
      myProfile: 'Mans Profils',
      logout: 'Iziet',
      
      // Footer
      cardquest: 'CardQuest',
      dominateArena: 'Apvaldi kārtis, dominē arēnā',
      quickLinks: 'Ātrās Saites',
      gameInfo: 'Spēles Informācija',
      community: 'Kopiena',
      rules: 'Noteikumi',
      strategyGuide: 'Stratēģijas Ceļvedis',
      faq: 'Bieži Uzdotie Jautājumi',
      discord: 'Discord',
      twitter: 'Twitter',
      github: 'GitHub',
      copyright: '© 2026 CardQuest. Izveidoja Hugo.',
      
      // Home page
      infiniteFlipGame: 'BEZGALĪGĀ KĀRŠU PĀRLĒCIENS',
      flipCards: 'Pārlēc kārtis, atklāj jaunas un veidoji savu kolekciju. Vienkārši, jauci un bezgalīgi atkārtojami.',
      viewCollection: 'SKATĪT KOLEKCIJU',
      playGame: 'SPĒLĒT SPĒLI',
      cardsCount: '30+',
      cardsLabel: 'KĀRTIS',
      raritiesCount: '6',
      raritiesLabel: 'RETUMI',
      flipsCount: '∞',
      flipsLabel: 'PĀRLĒCIENI',
      featuredCards: 'IZCELTAS KĀRTIS',
      discoverCards: 'Atklāj ko gaida',
      howItWorks: 'KĀ TAS DARBOJAS',
      simpleAndFun: 'Vienkārši un Jauks',
      startFlipping: 'SĀKT PĀRLĒKT!',
      flipDiscoverEnjoy: 'Pārlēc kārtis, atklāj jaunas un baudī vienkāršību',
      playNow: 'SPĒLĒT TAGAD',
      simpleInfinite: 'VIENKĀRŠI & BEZGALĪGI',
      gameAbout: 'CardQuest ir spēle par atklāšanu. Pārlēc kārtis, nopelni randomizētus punktus un pakāpeniski atklāj savu pilno kāršu kolekciju. Ar bezgalīgi atkārtojamu spēlējumu vienmēr ir vēl viena kārts, ko pārlēkt un punktus, ko nopelnīt.',
      gameplay: 'SPĒLES MEHĀNIKA',
      rngCardFlip: 'RNG Kāršu Pārlēciens',
      cardsCountLabel: 'Unikālas Kārtis',
      elementsLabel: 'Elementāri Tipi',
      flipDiscover: 'PĀRLĒC & ATKLĀJ',
      flipDiscoverDesc: 'Pārlēc kārtis, lai nopelnītu nejaušus punktus un atklāj jaunas kārtis',
      infiniteGameplay: 'BEZGALĪGA SPĒLE',
      infiniteGameplayDesc: 'Bezgalīgi atkārtojams kāršu pārlēciens bez ierobežojumiem',
      buildCollection: 'VEIDOJ KOLEKCIJU',
      buildCollectionDesc: 'Atbloķē kārtis, spēlējot, un seko savu atklājumu progresam',
      trackProgressTitle: 'SEKO PROGRESAM',
      trackProgressDesc: 'Monitorē savus rezultātus, spēlēto spēļu skaitu un kolekcijas statusu',
      
      // Login page
      signInToCardQuest: 'Ieiet CardQuest',
      email: 'E-pasts',
      password: 'Parole',
      signIn: 'Ieiet',
      noAccount: 'Vai jums nav konta?',
      createOne: 'Izveidojiet vienu šeit',
      
      // Signup page
      createAccount: 'Izveidot Kontu',
      username: 'Lietotājvārds',
      confirmPassword: 'Apstipriniet Paroli',
      signUp: 'Reģistrēties',
      alreadyHaveAccount: 'Vai jums jau ir konts?',
      
      // Play page
      playerProfile: 'SPĒLĒTĀJA PROFILS',
      trackProgress: 'Sekojiet savai progresai un kolekcijas izmaiņām',
      gamesPlayed: 'SPĒLES SPĒLĒTAS',
      highScore: 'AUGSTĀKAIS REZULTĀTS',
      totalPoints: 'KOPĒJIE PUNKTI',
      yourCollection: 'JŪSU KOLEKCIJA',
      cardsDiscovered: 'KĀRTIS ATKLĀTAS',
      collectMore: 'Iemanto vairāk, spēlējot!',
      averageScore: 'VIDĒJAIS REZULTĀTS',
      perGame: 'Vidējs spēles rezultāts',
      
      // Cards page
      allCards: 'VISAS KĀRTIS',
      browseCollection: 'Pārlūkojiet savu kāršu kolekciju',
      common: 'Parastā',
      uncommon: 'Neparasta',
      rare: 'Reti',
      epic: 'Episkā',
      legendary: 'Leģendāra',
      locked: 'BLOĶĒTA',
      unlocked: 'ATBLOKĒTA'
    }
  }

  const t = computed(() => translations[language.value])

  const setLanguage = (lang) => {
    language.value = lang
    localStorage.setItem('language', lang)
  }

  return {
    language,
    t,
    setLanguage,
    translations
  }
})
