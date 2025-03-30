<template>
  <q-page>
    <div class="lk">
      <div class="lk__container">
        <div class="lk__tabs tabs">
          <div class="container">
            <div class="tabs__container">
              <router-link :to="{ name: 'LandingPage' }" class="lk__tab">На главную</router-link>
              <button v-for="tab in tabs" :key="tab.id" @click="changeTab(tab)" class="lk__tab btn"
                :class="{ active: activeTab === tab.id }">{{ tab.name }}</button>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="lk__content">
            <component :is="selectComponent(activeTab)" />
          </div>
        </div>
      </div>
    </div>
  </q-page>
</template>

<script>
import LkCourseTab from 'src/components/lk/LkCourseTab.vue';
import LkProfileTab from 'src/components/lk/LkProfileTab.vue';
export default {
  data() {
    return {
      tabs: [
        {
          id: 0,
          path: '/lk/profile',
          name: 'Профиль',
        },
        {
          id: 1,
          path: '/lk/course',
          name: 'Курс',
        },
      ],
      activeTab: 1,
    }
  },
  methods: {
    changeTab(tab) {
      this.activeTab = tab.id;
    },
    selectComponent(id) {
      switch (id) {
        case 0: return LkProfileTab;
        case 1: return LkCourseTab;
      }
    }
  },

}
</script>

<style lang="scss">
@import 'src/css/lk/lk.scss'
</style>
