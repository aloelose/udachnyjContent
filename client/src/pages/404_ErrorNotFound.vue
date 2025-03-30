<template>
  <div class="body_404 fullscreen flex justify-center items-center column">
    <div class="full-width">
      <AppHeaderCompact />
    </div>

    <div class="col text-white text-center q-pa-md flex items-end" style="margin: 0 auto;">
      <div style="max-width: 570px;">
        <div class="row q-pa-md">
          <div class="text-uc_button_text h1_bigger7 col-12 col-sm" style="font-weight: 700;">404</div>
          <div class="text-uc_button_text col-12 col-sm flex flex-center"
            :class="$q.screen.lt.sm ? 'text-center h5' : 'text-left h1'" style="margin-bottom: 0;">
            Страница
            не найдена!</div>
        </div>
        <div>
          <q-btn :to="{ name: 'LandingPage' }" flat no-caps color="white" size="lg" class="q-pa-none full-width"
            style="border-radius: 22px">
            <div style="border: solid 4px #F8CB96; background-color: #F8CB96; border-radius: 22px;" class="full-width">
              <div style="border: solid 2px #A27D54; border-style: dashed; border-radius: 22px; color:#A27D54"
                class="q-px-lg q-py-md full-width">
                Вернуться на главную
              </div>
            </div>
          </q-btn>
        </div>
      </div>

    </div>
    <div class="full-width self-end flex_footer_container" style="background-color: #CBA377;">
      <AppFooter footerTypeProp="white" />
    </div>

  </div>
</template>

<script setup>
import AppHeaderCompact from 'src/components/AppHeaderCompact.vue'
import AppFooter from 'src/components/AppFooter.vue'
</script>


<style lang="scss">
// .bottom_404_bg {
//   background: url(../assets/images/401_404/bottom_404.svg) no-repeat,
//     linear-gradient(180deg, rgba(203, 163, 119, 0) 10%, rgba(203, 163, 119, 1) 20%, rgba(203, 163, 119, 1) 100%);
// }

// .body_404 {
//   background: url(../assets/images/401_404/bg_404_1440px.webp) no-repeat,
//     linear-gradient(180deg, rgba(208, 231, 241, 1) 0%, rgba(239, 223, 187, 1) 66%, rgba(239, 223, 187, 1) 100%);
//   background-blend-mode: normal;
//   background-origin: padding-box;
// }

.flex_footer_container {
  max-height: 160px !important;
}

@media (max-width: 600px) {
  .flex_footer_container {
    max-height: 260px !important;
  }
}

// background image stuff
.body_404 {
  background: url(../assets/images/401_404/bg_404_390px.webp) no-repeat,
    linear-gradient(180deg, rgba(208, 231, 241, 1) 0%, rgba(239, 223, 187, 1) 66%, rgba(239, 223, 187, 1) 100%);
  background-clip: border-box;
  background-position-x: center;
  background-position-y: top;
  image-rendering: pixelated;
}

@media (min-width: 390.99px) {
  .body_404 {
    background: url(../assets/images/401_404/bg_404_744px.webp) no-repeat,
      linear-gradient(180deg, rgba(208, 231, 241, 1) 0%, rgba(239, 223, 187, 1) 66%, rgba(239, 223, 187, 1) 100%);
    background-clip: border-box;
    background-position-x: center;
    background-position-y: top;
    image-rendering: pixelated;
  }
}

@media (min-width: 744.99px) {
  .body_404 {
    background: url(../assets/images/401_404/bg_404_1440px.webp) no-repeat,
      linear-gradient(180deg, rgba(208, 231, 241, 1) 0%, rgba(239, 223, 187, 1) 66%, rgba(239, 223, 187, 1) 100%);
    background-clip: border-box;
    background-position-x: center;
    background-position-y: top;
    image-rendering: pixelated;
  }
}

@media (min-width: 1440.99px) {
  .body_404 {
    background: url(../assets/images/401_404/bg_404_1920px.webp) no-repeat,
      linear-gradient(180deg, rgba(208, 231, 241, 1) 0%, rgba(239, 223, 187, 1) 66%, rgba(239, 223, 187, 1) 100%);
    background-clip: border-box;
    background-position-x: center;
    background-position-y: top;
    image-rendering: pixelated;
  }
}
</style>