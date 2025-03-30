<template>
  <q-page>
    <div class="section_banner">
      <div class="section_banner_background">

        <AppHeaderCompact :showLandingLinksProp=true />

        <div class="text_hero_wrapper self-center">
          <div class="text_hero q-px-md">
            <div class="h1_bigger3 font_Sunday text-primary text-center"
              :style="$q.screen.width <= 440 ? { fontSize: '48px' } : {}">У-дачный контент</div>
            <div class="text-primary text-center" :class="$q.screen.gt.sm ? 'h4' : 'h6'">Особенный развивающий
              контент для особенных детей. Получи билеты на
              «у-Дачный
              фестиваль -2025 года»,
              выполнив все задания.
            </div>
          </div>
        </div>

        <div class="sign_button_wrapper">
          <div class="sign_button sign_button_pillar">
            <div>
              <q-btn @click="showAuthDialog = true" flat no-caps color="white" label=""
                :size="$q.screen.gt.sm || $q.screen.lt.sm ? 'lg' : 'md'" class="q-pa-none"
                style="margin-bottom: -38%;border-radius: 40px">
                <div style="border: solid 2px #806241; background-color: #A27D54; border-radius: 40px;">
                  <div style="border: solid 2px #A27D54; border-radius: 40px;">
                    <div style="border: solid 4px #806241; border-style: dashed; border-radius: 40px;"
                      class="text-white q-px-xl q-py-sm">
                      Присоединиться
                    </div>
                  </div>
                </div>
              </q-btn>
            </div>
          </div>
        </div>

      </div>
      <div style="height: 254px; width: 100%; margin-top: -100px; z-index: 100; position: relative;" :style="[
        $q.screen.gt.sm ?
          { marginTop: '-100px', backgroundImage: `url(${img_sectionBanner_grass})` }
          : { marginTop: '-200px', backgroundImage: `url(${img_sectionBanner_grass})` }
      ]" class="flex items-center justify-center" :class="$q.screen.gt.sm ? 'h5 q-pa-md' : 'q-pa-sm'">
        <div class="bg-uc_fon row" style="border-radius: 54px; min-width: 50%;"
          :class="$q.screen.gt.sm ? 'q-px-xl q-py-lg' : 'q-px-lg q-py-md'">
          <div class="col flex flex-center q-pr-md">
            Давайте вместе сделаем лето незабываемым и полезным для наших детей!
          </div>
          <div class="col flex flex-center" style="max-width: 54px;">
            <q-img src="src/assets/landing/openmoji_scroll.svg" style="height: 54px; width: 54px;"></q-img>
          </div>
        </div>
      </div>
    </div>
    <div class="section_advantages" id="landing_section_advantages">
      <div class="section_advantages_background">

        <div class="row" style="height: 100%;" :class="$q.screen.gt.sm ? '' : 'flex-center'">
          <div class="col-12 col-md-7 flex flex-center" style="max-width: 90%;">
            <div :style="[
              $q.screen.gt.sm ?
                { marginBottom: '70%', marginRight: '20%' }
                : { marginBottom: '80%' }
            ]">
              <AppearBlock class="textblock_general textblock_notmirrored flex flex-center q-py-md"
                style="min-width: 300px;">
                <div class="textblock_textwrapper text-primary q-pl-none q-pt-md">
                  <div class="font_Sunday h3">Антон Кутимский</div>
                  <div class="" :class="$q.screen.lt.sm ? '' : 'h6'">Привет! Я главный «У-Дачник, продюсер и ведущий
                    проекта «Летом — Учимся и развиваемся
                    вместе
                    с нами!» Наша
                    команда разработала и создала особый контент для особенных детей.</div>
                </div>
              </AppearBlock>
            </div>
          </div>
          <div class="col-12 col-md-5" style="max-width: 90%;">
            <LandingAccordeon v-if="$q.screen.gt.sm" style="margin-top: 23%; max-width: 550px;" />
          </div>
        </div>

      </div>
      <div class="q-mt-xl" v-if="$q.screen.lt.md">
        <LandingAccordeon />
      </div>
    </div>
    <div class="section_speaker" style="position: relative; z-index: 3;" id="landing_section_speaker">
      <div class="section_speaker_desktopORtablets section_speaker_background" v-if="$q.screen.width > 440">
        <div>

          <div class="textblockany_wrapper flex justify-end" id="textblock1_wrapper">
            <AppearBlock class="textblock_general textblock_notmirrored flex flex-center q-pa-md"
              style="margin-right: 10%;">
              <div class="textblock_textwrapper text-primary q-pl-none q-pt-md">
                <div class="font_Sunday h3">Алена Грядкина</div>
                <div class="h6">Вместе, мы не только посадим урожай на грядках, но и усовершенствуем навыки счета и
                  память. Научимся вязать узлы и ухаживать за растениями</div>
              </div>
            </AppearBlock>
          </div>

          <div class="textblockany_wrapper flex justify-start" id="textblock2_wrapper">
            <AppearBlock class="textblock_general textblock_mirrored flex flex-center q-pa-md" style="margin-left: 5%;">
              <div class="textblock_textwrapper text-primary q-pl-md q-pt-md">
                <div class="font_Sunday h3">Егор Тепличный</div>
                <div class="h6">Теплица на нашей даче — это не только идеальное место для выращивания урожая, но и
                  летний театр по развитию речи</div>
              </div>
            </AppearBlock>
          </div>

          <div class="flex justify-center" id="textblock3_wrapper">
            <AppearBlock class="textblock_general textblock_notmirrored flex flex-center q-pa-md"
              style="margin-right: 25%;">
              <div class="textblock_textwrapper text-primary q-pl-none q-pt-md">
                <div class="font_Sunday h3">Павел Пчелкин</div>
                <div class="h6">Все лето как пчелы, мы будет не только производить мед, но и научимся координации,
                  ловкости и умению владеть своим телом</div>
              </div>
            </AppearBlock>
          </div>

          <div class="flex justify-end" id="textblock4_wrapper">
            <AppearBlock class="textblock_general textblock_mirrored flex flex-center q-pa-md"
              style="margin-right: 25%;">
              <div class="textblock_textwrapper text-primary q-pl-md q-pt-md">
                <div class="font_Sunday h3">Маша Садовая</div>
                <div class="h6">Лето — это время творчества и отдыха. Я научу вас делать стильные штучки из подручных
                  дачных предметов</div>
              </div>
            </AppearBlock>
          </div>

        </div>
      </div>
      <div class="section_speaker_mobile" v-if="$q.screen.width <= 440">
        <q-carousel style="height: 737px;" v-model="slide" animated arrows infinite class="bg-uc_fon"
          control-type="unelevated" control-color="white" control-text-color="primary" transition-prev="slide-right"
          transition-next="slide-left" swipeable>
          <q-carousel-slide :name="1" img-src="src/assets/landing/mobile/section_speaker_1.webp"
            style="background-size: contain; background-repeat: no-repeat;">
            <AppearBlock class="textblock_general textblock_notmirrored flex flex-center q-pa-md">
              <div class="textblock_textwrapper text-primary q-pl-none q-pt-md">
                <div class="font_Sunday h3">Алена Грядкина</div>
                <div class="h6">Вместе, мы не только посадим урожай на грядках, но и усовершенствуем навыки счета и
                  память. Научимся вязать узлы и ухаживать за растениями</div>
              </div>
            </AppearBlock>
          </q-carousel-slide>
          <q-carousel-slide :name="2" img-src="src/assets/landing/mobile/section_speaker_2.webp"
            style="background-size: contain; background-repeat: no-repeat;">
            <AppearBlock class="textblock_general textblock_mirrored flex flex-center q-pa-md">
              <div class="textblock_textwrapper text-primary q-pl-md q-pt-md">
                <div class="font_Sunday h3">Егор Тепличный</div>
                <div class="h6">Теплица на нашей даче — это не только идеальное место для выращивания урожая, но и
                  летний театр по развитию речи</div>
              </div>
            </AppearBlock>
          </q-carousel-slide>
          <q-carousel-slide :name="3" img-src="src/assets/landing/mobile/section_speaker_3.webp"
            style="background-size: contain; background-repeat: no-repeat;">
            <AppearBlock class="textblock_general textblock_notmirrored flex flex-center q-pa-md">
              <div class="textblock_textwrapper text-primary q-pl-none q-pt-md">
                <div class="font_Sunday h3">Павел Пчелкин</div>
                <div class="h6">Все лето как пчелы, мы будет не только производить мед, но и научимся координации,
                  ловкости и умению владеть своим телом</div>
              </div>
            </AppearBlock>
          </q-carousel-slide>
          <q-carousel-slide :name="4" img-src="src/assets/landing/mobile/section_speaker_4.webp"
            style="background-size: contain; background-repeat: no-repeat;">
            <AppearBlock class="textblock_general textblock_mirrored flex flex-center q-pa-md">
              <div class="textblock_textwrapper text-primary q-pl-md q-pt-md">
                <div class="font_Sunday h3">Маша Садовая</div>
                <div class="h6">Лето — это время творчества и отдыха. Я научу вас делать стильные штучки из подручных
                  дачных предметов</div>
              </div>
            </AppearBlock>
          </q-carousel-slide>
        </q-carousel>
      </div>
    </div>
    <div class="section_events" style="position: relative; z-index: 2; overflow: hidden;" id="landing_section_events">
      <div class="section_events_background">
        <div class="eventsTicket_invite_wrapper">
          <div class="eventsTicket_invite_string"></div>
          <div class="flex flex-center">
            <div class="eventsTicket_invite_paperBody flex flex-center"
              :class="$q.screen.gt.md ? 'q-px-xl q-py-xl' : 'q-px-sm q-py-lg'">
              <div class="eventsTicket_invite_paperBody_text q-py-md">
                <div class="eventsTicket_bigText h4 font_Sunday text-center q-mb-md q-pb-md">Приглашаем на Фестиваль
                  «У-дачник»!
                </div>
                <div class="eventsTicket_blockWBackgroundAndPic bg-uc_light_green q-px-md q-mb-md"
                  style="border-radius: 20px;" :class="$q.screen.lt.sm ? 'q-py-sm' : 'q-py-sm'">
                  <div class="flex flex-center"> <q-img non-selectable src="src/assets/landing/blocks/solar_cup.svg"
                      spinner-color="white"
                      :style="$q.screen.gt.sm ? { height: '70px', width: '70px' } : { height: '44px', width: '44px' }" />
                  </div>
                  <div class="text-center text-white" style="font-weight: 400;" :class="$q.screen.gt.sm ? 'h5' : ''">
                    Подведем итоги,
                    наградим лучших и отлично
                    проведем время! В программе:
                    мастер-классы, интенсивы и
                    многое другое.</div>
                </div>
                <div class="eventsTicket_bottomTexts">
                  <div class="eventsTicket_bottomTexts_withGrid row q-mb-md">
                    <div class="col-12 col-xs-6">
                      <q-item>
                        <q-item-section side top>
                          <q-icon name="calendar_month" color="primary" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label class="h6">27 сентября 2025 года</q-item-label>
                        </q-item-section>
                      </q-item>
                    </div>
                    <div class="col-12 col-xs-6">
                      <q-item>
                        <q-item-section side top>
                          <q-icon name="not_listed_location" color="primary" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label class="h6"> Актовый зал Дворца детского и юношеского творчества</q-item-label>
                          <q-item-label caption class="text-black">г. Иркутск, улица
                            Желябова, 5</q-item-label>
                        </q-item-section>
                      </q-item>
                    </div>
                  </div>
                  <div class="eventsTicket_bottomTexts_lastText text-center h6">
                    Вход по билетам "У-дачника". Участвуйте и получите свой шанс!
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <div class="section_registrations" style="padding-top: 50px;">
      <div class="section_registrations_background row">
        <div class="registr_text_and_button col-12 col-md-8 q-pa-md flex flex-center" style="margin-top: -100px;">
          <div class="">
            <div class="text-primary h1 font_Sunday q-pb-xl">Сделай лето у-дачным!</div>
            <div>
              <q-btn @click="showAuthDialog = true" flat no-caps color="white"
                :size="$q.screen.gt.sm || $q.screen.lt.sm ? 'xl' : 'md'" class="q-pa-none" style="border-radius: 22px">
                <div style="border: solid 2px #F8CB96; background-color: #F8CB96; border-radius: 22px;">
                  <div style="border: solid 4px #A27D54; border-style: dashed; border-radius: 22px; color:#A27D54"
                    class="q-px-xl q-py-sm">
                    Присоединиться
                  </div>
                </div>
              </q-btn>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4"></div>
      </div>
    </div>
    <div class="section_partners" id="landing_section_partners">
      <div class="section_partners_background">
        <div style="height: 254px; width: 100%; margin-top: -36px;"
          :style="{ backgroundImage: `url(${img_sectionBanner_grass})` }" :class="$q.screen.lt.sm ? '' : 'q-pa-lg'">
          <q-carousel v-model="slide2" padding infinite transition-prev="slide-right" transition-next="slide-left"
            swipeable animated :control-type="$q.screen.lt.sm ? 'flat' : 'unelevated'" control-color="white"
            control-text-color="primary" :arrows="$q.screen.gt.xs" :navigation="$q.screen.lt.sm" :autoplay=true
            style="height: 100%; background-color: transparent;">
            <q-carousel-slide :name="1" class="column no-wrap">
              <div class="row fit justify-center items-center q-gutter-xs q-col-gutter no-wrap">
                <q-btn no-caps color="green" icon="mail" label="info@example" />
                <q-btn no-caps color="green" icon="mail" label="info@example" />
              </div>
            </q-carousel-slide>
            <q-carousel-slide :name="2" class="column no-wrap">
              <div class="row fit justify-center items-center q-gutter-xs q-col-gutter no-wrap">
                <q-btn no-caps color="green" icon="mail" label="info@example" />
                <q-btn no-caps color="green" icon="mail" label="info@example" />
              </div>
            </q-carousel-slide>
            <q-carousel-slide :name="3" class="column no-wrap">
              <div class="row fit justify-center items-center q-gutter-xs q-col-gutter no-wrap">
                <q-btn no-caps color="green" icon="mail" label="info@example" />
                <q-btn no-caps color="green" icon="mail" label="info@example" />
              </div>
            </q-carousel-slide>
            <q-carousel-slide :name="4" class="column no-wrap">
              <div class="row fit justify-center items-center q-gutter-xs q-col-gutter no-wrap">
                <q-btn no-caps color="green" icon="mail" label="info@example" />
                <q-btn no-caps color="green" icon="mail" label="info@example" />
              </div>
            </q-carousel-slide>
          </q-carousel>
        </div>
      </div>
    </div>
    <div class="footer_wrapper">
      <AppFooter />
    </div>
  </q-page>
  <AppAuthDialog v-model="showAuthDialog" :isShowLogin=false />
</template>

<script setup>
import img_sectionBanner_grass from 'src/assets/landing/blocks/section_banner_grass.webp'
// import img_sectionBanner_grass2 from 'src/assets/landing/blocks/Vector_grass2.svg'
// import img_sectionBanner_grassWithSunflowers from 'src/assets/landing/blocks/Vector_grassWithSunflowers.svg'
import { ref } from 'vue'
import AppHeaderCompact from 'src/components/AppHeaderCompact.vue'
import AppFooter from 'src/components/AppFooter.vue'
import AppearBlock from 'src/components/landing/AppearBlock.vue'
import LandingAccordeon from 'src/components/landing/LandingAccordeon.vue'
import AppAuthDialog from 'src/components/AppAuthDialog.vue';
const showAuthDialog = ref(false); // показ диалог-окна AppAuthDialog

const slide = ref(1)
const slide2 = ref(1)

// const showAuthDialog = ref(false);
</script>

<style lang="scss">
// :style="{
//         backgroundImage: `url(${img_sectionBanner}), linear-gradient(rgba(208, 231, 241, 1), rgba(255, 255, 255, 0))`,
//         backgroundRepeat: 'no-repeat',
//         backgroundBlendMode: 'normal',
//         backgroundOrigin: 'padding-box',
//       }" на потом себе сохранил, если когда будет хост полетят импорты

// Textblocks that do appear animation
// Textblocks that do appear animation
.textblockany_wrapper {
  width: 100%;
}

.textblock_general {
  width: 440px;
  height: 235px;
  max-width: 100%;
}

// .textblock_regular,
// .textblock_mirrored {}

.textblock_notmirrored {
  background-image: url(../assets/landing/blocks/Vector_textbox1.svg);
  background-repeat: no-repeat;
  background-size: 100% 100%;
}

.textblock_mirrored {
  background-image: url(../assets/landing/blocks/Vector_textbox2.svg);
  background-repeat: no-repeat;
  background-size: 100% 100%;
}

.textblock_textwrapper {
  max-width: 90%;
  max-height: 90%;
}

#textblock1_wrapper {
  position: relative;
  top: 900px;
}

#textblock1 {
  position: relative;
  left: 1300px;
}

#textblock2_wrapper {
  position: relative;
  top: 1050px;
}

#textblock2 {
  position: relative;
  left: 100px;
}

#textblock3_wrapper {
  position: relative;
  top: 1350px;
}

#textblock3 {
  position: relative;
  left: 600px;
}

#textblock4_wrapper {
  position: relative;
  top: 1700px;
}

#textblock4 {
  position: relative;
  left: 1050px;
}

// Textblocks that do appear animation
// Textblocks that do appear animation

// Blocks with complex vector img background, very sensitive to resizing
// Blocks with complex vector img background, very sensitive to resizing
// Blocks with complex vector img background, very sensitive to resizing

.section_banner_background {
  background: url(../assets/landing/section_banner.webp) no-repeat,
    linear-gradient(rgba(208, 231, 241, 1), rgba(255, 255, 255, 0));
  background-blend-mode: normal;
  background-origin: padding-box;
  height: 1135px;
  // background-size: cover;
  // background-clip: border-box;
  // background-position-x: center;
  // background-position-y: top;
  // image-rendering: pixelated;
}

.section_advantages_background {
  background: url(../assets/landing/section_advantages.webp) no-repeat;
  background-blend-mode: normal;
  background-origin: padding-box;
  height: 1152px;
}

.section_speaker_background {
  background: url(../assets/landing/section_speaker.webp) no-repeat;
  background-blend-mode: normal;
  background-origin: padding-box;
  height: 3343px;
}

.section_events {
  margin-top: -50px;
}

.section_events_background {
  background: url(../assets/landing/section_events.webp) no-repeat;
  background-blend-mode: normal;
  background-origin: padding-box;
  height: 1095px;
  background-position-x: center;
  background-position-y: top;
  background-size: cover;
}

.section_registrations_background {
  background: url(../assets/landing/section_registrations.webp) no-repeat;
  background-blend-mode: normal;
  background-origin: padding-box;
  height: 697px;
}

.text_hero_wrapper {
  position: relative;
  top: 150px;
}

.text_hero {
  margin: 0 auto;
  width: 850px;
  max-width: 100%;
}

.sign_button_wrapper {
  position: relative;
  top: 400px;
}

.sign_button {
  margin-left: 700px;
  width: 850px;
  max-width: 100%;
}

.sign_button_pillar {
  background: url(../assets/landing/blocks/Pillar_for_button.svg) no-repeat;
  width: 281px;
  height: 340px;
}

// .eventsTicket_invite_wrapper {}

.eventsTicket_invite_string {
  position: relative;
  z-index: 5;
  background-image: url(../assets/landing/blocks/invite_string_desktop.svg);
  background-size: contain;
  background-repeat: no-repeat;
  background-blend-mode: normal;
  background-origin: padding-box;
  background-clip: border-box;
  background-position-x: center;
  background-position-y: bottom;
  image-rendering: pixelated;
  height: 300px;
  max-width: 100%;
  max-height: 100%;
}

.eventsTicket_invite_paperBody {
  position: relative;
  z-index: 4;
  margin-top: -40px;
  background-image: url(../assets/landing/blocks/invite_paperBody_desktop.webp);
  background-size: contain;
  background-repeat: no-repeat;
  background-blend-mode: normal;
  background-origin: padding-box;
  background-clip: border-box;
  background-position-x: center;
  background-position-y: top;
  image-rendering: pixelated;
  width: 1095px;
  height: 630px;
  max-width: 100%;
  max-height: 100%;
  transform: rotate(-11deg);
}

.eventsTicket_invite_paperBody_text {
  max-width: 540px;
}

@media (max-width: 1440px) {
  .section_banner_background {
    background: url(../assets/landing/1440/section_banner.webp) no-repeat,
      linear-gradient(rgba(208, 231, 241, 1), rgba(255, 255, 255, 0));
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 915px;
  }

  .section_advantages_background {
    background: url(../assets/landing/1440/section_advantages.webp) no-repeat;
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 857px;
  }

  .section_speaker_background {
    background: url(../assets/landing/1440/section_speaker.webp) no-repeat;
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 2508px;
  }

  .section_events_background {
    background: url(../assets/landing/1440/section_events.webp) no-repeat;
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 821px;
    background-size: cover;
  }

  .section_registrations_background {
    background: url(../assets/landing/1440/section_registrations.webp) no-repeat;
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 523px;
  }

  .text_hero_wrapper {
    top: 100px;
  }

  .sign_button_wrapper {
    top: 290px;
  }

  .sign_button {
    margin: 0 auto;
  }

  #textblock1_wrapper {
    position: relative;
    top: 600px;
  }

  #textblock1 {
    position: relative;
    left: 750px;
  }

  #textblock2_wrapper {
    position: relative;
    top: 750px;
  }

  #textblock2 {
    position: relative;
    left: 50px;
  }

  #textblock3_wrapper {
    position: relative;
    top: 850px;
  }

  #textblock3 {
    position: relative;
    left: 300px;
  }

  #textblock4_wrapper {
    position: relative;
    top: 1100px;
  }

  #textblock4 {
    position: relative;
    left: 650px;
  }

  .eventsTicket_invite_string {
    height: 200px;
  }

  .eventsTicket_invite_paperBody {
    width: 800px;
    height: 460px;
    margin-top: -20px;
  }

}

@media (max-width: 744px) {
  .section_banner_background {
    background: url(../assets/landing/tablet/section_banner.webp) no-repeat,
      linear-gradient(rgba(208, 231, 241, 1), rgba(255, 255, 255, 0));
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 664px;
  }

  .section_advantages_background {
    background: url(../assets/landing/tablet/section_advantages.webp) no-repeat;
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 651px;
  }

  .section_speaker_background {
    background: url(../assets/landing/tablet/section_speaker.webp) no-repeat;
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 1534px;
  }

  .section_events_background {
    background: url(../assets/landing/tablet/section_events.webp) no-repeat;
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 762px;
    background-size: cover;
  }

  .section_registrations_background {
    background: url(../assets/landing/tablet/section_registrations.webp) no-repeat;
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 322px;
  }

  .text_hero_wrapper {
    top: 0;
  }

  .text_hero {
    width: 450px;
  }

  .sign_button_wrapper {
    top: 50px;
  }

  .sign_button_pillar {
    background: url(../assets/landing/blocks/Pillar_for_button.svg) no-repeat;
    width: 201px;
    height: 240px;
  }

  .textblock_general {
    width: 350px;
    height: 235px;
  }

  #textblock1_wrapper {
    position: relative;
    top: 300px;
  }

  #textblock1 {
    position: relative;
    left: 250px;
  }

  #textblock2_wrapper {
    position: relative;
    top: 380px;
  }

  #textblock2 {
    position: relative;
    left: 50px;
  }

  #textblock3_wrapper {
    position: relative;
    top: 500px;
  }

  #textblock3 {
    position: relative;
    left: 50px;
  }

  #textblock4_wrapper {
    position: relative;
    top: 530px;
  }

  #textblock4 {
    position: relative;
    left: 300px;
  }

  .eventsTicket_invite_string {
    background-size: cover;
    height: 150px;
  }

  .eventsTicket_invite_paperBody {
    height: 100%;
    width: 100%;
    margin-top: -20px;
  }
}

@media (max-width: 640px) {
  .eventsTicket_invite_string {
    background-image: url(../assets/landing/blocks/invite_string_tablet.svg);
  }

  .eventsTicket_invite_paperBody {
    background-size: cover;
    transform: rotate(0);
  }
}

@media (max-width: 440px) {

  .section_banner_background {
    background: url(../assets/landing/mobile/section_banner.webp) no-repeat,
      linear-gradient(rgba(208, 231, 241, 1), rgba(255, 255, 255, 0));
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 860px;
  }

  .section_advantages_background {
    background: url(../assets/landing/mobile/section_advantages.webp) no-repeat;
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 596px;
  }

  .section_speaker_background {
    background: url(../assets/landing/mobile/section_speaker.webp) no-repeat;
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 737px;
  }

  .section_events {
    margin-top: 0px;
  }

  .section_events_background {
    background: url(../assets/landing/mobile/section_events.webp) no-repeat;
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 760px;
    background-position-x: center;
    background-position-y: top;
    background-size: cover;
  }

  .section_registrations_background {
    background: url(../assets/landing/mobile/section_registrations.webp) no-repeat;
    background-blend-mode: normal;
    background-origin: padding-box;
    height: 420px;
  }

  .sign_button_wrapper {
    top: 100px;
  }

  .sign_button {
    margin-top: -20px;
    margin-left: 30px;
    width: 850px;
    max-width: 100%;
  }

  .sign_button_pillar {
    background: url(../assets/landing/blocks/Pillar_for_button.svg) no-repeat;
    width: 241px;
    height: 340px;
  }

  .eventsTicket_invite_string {
    height: 200px;
    background-size: 200%;
  }

  .eventsTicket_invite_paperBody {
    background-size: 200% 100%;
  }
}

// .irregular_rectangle:hover:before,
// .irregular_rectangle:hover:after {
//   clip-path: polygon(5% 2%, 100% 5%, 100% 100%, 0% 94%);
// }

// .gradient-bg {
//   background: linear-gradient(160deg, #83a4d4 0%, #b6fbff 100%);
// }

// .sun-animation {
//   animation: rotate 20s linear infinite;
// }

// .cloud-layer {
//   z-index: 1;
//   pointer-events: none;
// }

// @keyframes rotate {
//   from {
//     transform: rotate(0deg);
//   }

//   to {
//     transform: rotate(360deg);
//   }
// }

// .landing-section {
//   height: 100vh;
//   min-height: 600px;

//   .background-layer {
//     position: absolute;
//     width: 100%;
//     height: 100%;
//     background: linear-gradient(45deg, $primary 30%, $secondary 100%);
//   }

//   .man-image {
//     z-index: 1;

//     @media (max-width: $breakpoint-md) {
//       right: 0 !important;
//       max-height: 50% !important;
//     }
//   }

//   .content-layer {
//     z-index: 2;
//     width: 90%;
//     max-width: 1200px;

//     @media (max-width: $breakpoint-md) {
//       width: 95%;
//       padding: 2rem !important;
//     }
//   }

//   // .separator-image {
//   //   z-index: 1;
//   //   transform: translateY(50%);
//   // }
// }
.div_imgTagBackground {
  display: inline-block;
  overflow: hidden;
  position: relative;
  width: 100%;
}

.img_imgTagBackground {
  pointer-events: none;
  position: absolute;
  width: 100%;
  height: 100%;
  z-index: -1;
}
</style>