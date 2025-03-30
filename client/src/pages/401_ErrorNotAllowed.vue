<template>
  <div class="body_401 fullscreen flex justify-center items-center column">
    <div class="full-width">
      <AppHeaderCompact />
    </div>

    <div class="col text-white q-pa-md flex items-end" style="margin: 0 auto;">
      <div class="row q-gutter-y-md" style="max-width: 1090px;">
        <div class="col-12 col-md-8 q-pr-lg" style="max-width: 760px;">
          <div class="h1_bigger7 font_Sunday">401</div>
          <div>
            <div class="h1 font_Sunday">Кажется, у вас нет доступа</div>
            <div>Чтобы увидеть эту страницу, нужно войти в систему. Возможно, вы не авторизованы или ваша учётная запись
              не имеет необходимых прав.</div>
          </div>
        </div>
        <div class="col-12 col-md-4 flex items-end">
          <div class="q-gutter-y-md">
            <q-btn @click="showAuthDialog = true" flat no-caps color="white" size="lg" class="q-pa-none full-width"
              style="border-radius:  24px">
              <div style="border: solid 4px #F8CB96; background-color: #F8CB96; border-radius:  24px;"
                class="full-width">
                <div style="border: solid 2px #A27D54; border-style: dashed; border-radius:  24px; color:#A27D54"
                  class="q-px-md q-py-md full-width">
                  Авторизироваться
                </div>
              </div>
            </q-btn>
            <q-btn :to="{ name: 'LandingPage' }" flat no-caps color="white" size="lg" class="q-pa-none full-width"
              style="border-radius:  24px">
              <div class="full-width">
                <div style="border: solid 2px white; border-style: dashed; border-radius:  24px; color:white"
                  class="q-px-md q-py-md full-width">
                  Вернуться на главную
                </div>
              </div>
            </q-btn>
          </div>
        </div>
      </div>

    </div>
    <div class="full-width self-end flex_footer_container" style="background-color: #78964E;">
      <AppFooter footerTypeProp="white" />
    </div>

  </div>
  <AppAuthDialog v-model="showAuthDialog" :isShowLogin=false />
</template>

<script setup>
import { ref } from 'vue'
import AppHeaderCompact from 'src/components/AppHeaderCompact.vue'
import AppFooter from 'src/components/AppFooter.vue'
import AppAuthDialog from 'src/components/AppAuthDialog.vue';

const showAuthDialog = ref(false); // показ диалог-окна AppAuthDialog
</script>

<style lang="scss">
// background image stuff
.body_401 {
  background: url(../assets/images/401_404/bg_401_390px.webp) no-repeat,
    linear-gradient(180deg, rgba(208, 231, 241, 1) 0%, rgba(239, 223, 187, 1) 66%, rgba(239, 223, 187, 1) 100%);
  background-clip: border-box;
  background-position-x: center;
  background-position-y: top;
  image-rendering: pixelated;
}

@media (min-width: 600.99px) {
  .body_401 {
    background: url(../assets/images/401_404/bg_401_744px.webp) no-repeat,
      linear-gradient(180deg, rgba(208, 231, 241, 1) 0%, rgba(239, 223, 187, 1) 66%, rgba(239, 223, 187, 1) 100%);
    background-clip: border-box;
    background-position-x: center;
    background-position-y: top;
    image-rendering: pixelated;
  }
}

@media (min-width: 744.99px) {
  .body_401 {
    background: url(../assets/images/401_404/bg_401_1440px.webp) no-repeat,
      linear-gradient(180deg, rgba(208, 231, 241, 1) 0%, rgba(239, 223, 187, 1) 66%, rgba(239, 223, 187, 1) 100%);
    background-clip: border-box;
    background-position-x: center;
    background-position-y: top;
    image-rendering: pixelated;
  }
}

@media (min-width: 1440.99px) {
  .body_401 {
    background: url(../assets/images/401_404/bg_401_1920px.webp) no-repeat,
      linear-gradient(180deg, rgba(208, 231, 241, 1) 0%, rgba(239, 223, 187, 1) 66%, rgba(239, 223, 187, 1) 100%);
    background-clip: border-box;
    background-position-x: center;
    background-position-y: top;
    image-rendering: pixelated;
  }
}
</style>