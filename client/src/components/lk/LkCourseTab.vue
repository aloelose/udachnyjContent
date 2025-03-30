<template>
  <section class="lk-course">
    <div class="lk-course__left">
      <div ref="dropdown" class="lk-course__dropdown dropdown" v-click-outside="closeDropdown">
        <button @click="toggleDropdown" class="dropdown__btn btn">Правила</button>
        <div class="dropdown__content" :class="{ open: open }">
          Изучив весь материал курса, вы получите билет на фестиваль «У-Дачник».
          Все модули открываются постепенно — в каждом месяце по 4 видеоурока с текстовыми методическими материалами.
          Если у вас возникнут вопросы или вы захотите поделиться успехами, используйте кнопку «Обратная связь».
        </div>
      </div>
      <img :style="{ top: `${dropdownHeight}px` }" ref="img" class="lk-course__img"
        src="/src/assets/images/lk/course-pic.webp" alt="">
    </div>
    <div class="lk-course__right">
      <div class="lk-course__items">
        <LkCourseSpoiler v-for="course in courses" :key="course.id" :item="course" @lessonCompleted="markLessonAsCompleted"/>
      </div>
    </div>
  </section>
</template>
<script>
import vClickOutside from 'click-outside-vue3'
import LkCourseSpoiler from 'src/components/lk/LkCourseSpoiler.vue';
import { api } from 'src/boot/axios';

const CACHE_DURATION = 60 * 60 * 1000;

export default {
  components: {
    LkCourseSpoiler,
  },
  directives: {
    clickOutside: vClickOutside.directive
  },
  data() {
    return {
      courses: [],
      open: false,
      dropdownHeight: 0,
    };
  },
  methods: {
    async fetchCourses() {
      const cachedData = localStorage.getItem('cachedCourses');
      const cachedTime = localStorage.getItem('cachedCoursesTime');
      if (cachedData && cachedTime && Date.now() - cachedTime < CACHE_DURATION) {
        this.courses = JSON.parse(cachedData);
        return;
      }
      try {
        const token = localStorage.getItem('authToken');
        const response = await api.get('/courses', {
          headers: { Authorization: `Bearer ${token}` }
        });
        this.courses = response.data.map(course => ({
          id: course.id,
          name: `У - Дачный контент ${course.title}`,
          children: []
        }));
        localStorage.setItem('cachedCourses', JSON.stringify(this.courses));
        localStorage.setItem('cachedCoursesTime', Date.now());
      } catch (error) {
        console.error('Ошибка загрузки курсов:', error);
      }
    },
    async fetchLessons() {
      const cachedData = localStorage.getItem('cachedLessons');
      const cachedTime = localStorage.getItem('cachedLessonsTime');
      if (cachedData && cachedTime && Date.now() - cachedTime < CACHE_DURATION) {
        this.courses = JSON.parse(cachedData);
        return;
      }
      try {
        const token = localStorage.getItem('authToken');
        const allLessonsResponse = await api.get('/lessons/all', {
          headers: { Authorization: `Bearer ${token}` }
        });
        const availableLessonsResponse = await api.get('/lessons/available', {
          headers: { Authorization: `Bearer ${token}` }
        });
        const allLessons = allLessonsResponse.data.all_lessons;
        const availableLessons = new Set(availableLessonsResponse.data.available_lessons.map(l => l.id));
        this.courses.forEach(course => {
          course.children = allLessons
            .filter(lesson => lesson.course_id === course.id)
            .map(lesson => ({
              id: lesson.id,
              video_link: availableLessons.has(lesson.id) 
                ? lesson.link 
                : '/src/assets/images/lk/wait.webp',
              poster: '/src/assets/images/lk/poster.webp',
              available: availableLessons.has(lesson.id),
              available_at: new Date(lesson.available_at)
            }));
        });
        localStorage.setItem('cachedLessons', JSON.stringify(this.courses));
        localStorage.setItem('cachedLessonsTime', Date.now());
      } catch (error) {
        console.error('Ошибка загрузки уроков:', error);
      }
    },
    async markLessonAsCompleted(lessonId) {
      try {
        const token = localStorage.getItem('authToken');
        const response = await api.post(`/lessons/${lessonId}/complete`, {}, {
          headers: { Authorization: `Bearer ${token}` }
        });
        const data = response.data;
        if (data.code === 403) {
          console.log(`Урок ${lessonId} пока недоступен`);
          return;
        }
        if (data.status === "lesson_completed") {
          console.log(`Урок ${lessonId} успешно отмечен как пройденный`);
        }
      } catch (error) {
        console.error(`Ошибка при отметке урока ${lessonId} как пройденного:`, error);
      }
    },
    forceUpdateData() {
      localStorage.removeItem('cachedCourses');
      localStorage.removeItem('cachedCoursesTime');
      localStorage.removeItem('cachedLessons');
      localStorage.removeItem('cachedLessonsTime');
      this.fetchCourses();
      this.fetchLessons();
    },
    toggleDropdown() {
      this.open = !this.open;
    },
    closeDropdown() {
      this.open = false;
    },
    dropdownHeightHundle() {
      if (this.$refs.img && this.$refs.dropdown) {
        this.dropdownHeight = this.$refs.dropdown.clientHeight + 56;
      }
    }
  },
  mounted() {
    this.fetchCourses();
    this.fetchLessons();
    this.dropdownHeightHundle();
    window.addEventListener('resize', this.dropdownHeightHundle);
  }
}
</script>

<style lang="scss">
@import '/src/css/lk/lk-course.scss';
</style>
