<template>
  <div class="lk-course__item course-item" :class="{open: visible, disabled: disabled}">
    <button class="course-item__open btn" @click="spoilerOpen">
      {{ item.name }}
    </button>
    <div class="course-item__container">
      <div class="course-item__wrapper">
        <div class="course-item__content">
          <div class="course-item__grid">
            <div v-for="video in item.children" :key="video.id" class="course-item__video">
              <img class="course-item__poster" :src="video.poster" alt="">
              <button class="btn course-item__play" @click="initPhotoswipe(video); markAsCompleted(video)">
                <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="62" height="62" rx="31" fill="white"/>
                <path d="M20 30.7767V25.4367C20 18.8167 24.7 16.0967 30.44 19.4167L35.06 22.0967L39.68 24.7767C45.42 28.0967 45.42 33.5167 39.68 36.8367L35.06 39.5167L30.44 42.1967C24.7 45.4567 20 42.7567 20 36.1167V30.7767Z" fill="#829F4F"/>
                </svg>
              </button>
            </div>
          </div>
          <div class="course-item__btns">
              <a class="btn course-item__link btn--primary" target="_blank" href="/">
                <span class="btn__text">Методические материалы</span>
              </a>
              <button class="btn course-item__btn btn--stroke">Обратная связь</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PhotoSwipe from 'photoswipe';
import 'photoswipe/style.css';
import { useProgressionStore } from 'stores/progressionStore';

const ProgressionStore = useProgressionStore();
export default {
  components: {

  },
  props: {
    item: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      visible: false,
      disabled: false
    }
  },
  methods: {
    spoilerOpen() {
      this.visible = !this.visible
    },
    markAsCompleted(video) {
      this.$emit("lessonCompleted", video.id);
      ProgressionStore.refreshProgressionData();
    },

    initPhotoswipe(video) {
      let dataSource = [];
      let obj = {};
      console.log(video.video_link)
      obj.html = `<iframe width="1096" height="648" src="${video.video_link}"
                          frameBorder="0" allow="clipboard-write; autoplay" webkitAllowFullScreen mozallowfullscreen allowFullScreen>
                        </iframe>`;
      dataSource.push(obj)


      console.log(dataSource)
      const options = {
        dataSource: dataSource,
        showHideAnimationType: 'none'
      };

      options.index = 0;
      const pswp = new PhotoSwipe(options);
      pswp.init();
    }
  },

  mounted() {

  }
}
</script>
<!-- <iframe width="720" height="405" src="https://rutube.ru/play/embed/c71a722e6f74234eba54043ca507572b/" frameBorder="0" allow="clipboard-write; autoplay" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe> -->
