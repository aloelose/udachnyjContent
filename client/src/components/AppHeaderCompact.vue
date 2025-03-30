<template>
    <div :class="!showLandingLinksProp ? '' : ''">
        <div class="fake_header_wrapper flex justify-center q-py-md q-mb-md" style="width: 100%; max-height: 10vh;">
            <div class="fake_header row flex items-center" style="width: 100%; height: 80px;"
                :class="$q.screen.gt.sm ? 'justify-between q-px-xl' : 'justify-between q-px-md'">
                <div
                    :style="$q.screen.gt.xs ? 'min-width: 150px; max-width: 150px;' : 'min-width: 110px; max-width: 110px;'">
                    <AppLink_NewTabIfExt :to="{ name: 'LandingPage' }"><q-img src="src/assets/logo.svg"
                            style="height: 100%; width: 100%;" :to="{ name: 'LandingPage' }" />
                    </AppLink_NewTabIfExt>
                </div>
                <div class="row" style="min-width: 150px;max-width: 550px;"
                    v-if="$q.screen.gt.md && showLandingLinks == true">
                    <AppLink_NewTabIfExt :to="{ name: 'LandingPage', hash: '#landing_section_advantages' }"
                        class="text-primary text-center q-mx-md h6">Преимущества
                    </AppLink_NewTabIfExt>
                    <AppLink_NewTabIfExt :to="{ name: 'LandingPage', hash: '#landing_section_events' }"
                        class="text-primary text-center q-mx-md h6">Мероприятие
                    </AppLink_NewTabIfExt>
                    <AppLink_NewTabIfExt :to="{ name: 'LandingPage', hash: '#landing_section_speaker' }"
                        class="text-primary text-center q-mx-md h6">Спикеры
                    </AppLink_NewTabIfExt>
                    <AppLink_NewTabIfExt :to="{ name: 'LandingPage', hash: '#landing_section_partners' }"
                        class="text-primary text-center q-mx-md h6">Партнеры
                    </AppLink_NewTabIfExt>
                </div>
                <div class="header_buttons">

                    <div v-if="showLandingLinks == true" class="q-gutter-sm row justify-center">
                        <q-btn v-if="!isUserLoggedIn" no-caps flat color="green" size="lg" text-color="primary"
                            style="background-color: #EFDFBB;border: solid 2px #315720;" @click="showAuthDialog = true">
                            Войти
                        </q-btn>
                        <q-btn v-if="isUserLoggedIn" no-caps flat color="green" size="lg" text-color="primary"
                            style="background-color: #EFDFBB;border: solid 2px #315720;" :to="{ name: 'LKPage' }">
                            Кабинет
                        </q-btn>
                        <q-btn v-if="$q.screen.lt.lg" flat no-caps color="green" icon="menu"
                            @click="showMobileDialog = true" size="lg" />
                    </div>
                    <div v-if="showLandingLinks == false">
                        <q-btn v-if="!isUserLoggedIn" no-caps flat color="green" size="lg" text-color="primary"
                            style="background-color: #EFDFBB;border: solid 2px #315720;" @click="showAuthDialog = true">
                            Войти
                        </q-btn>
                        <q-btn v-if="isUserLoggedIn" no-caps flat color="green" size="lg" text-color="primary"
                            style="background-color: #EFDFBB;border: solid 2px #315720;"
                            @click="showConfirmLogout = true" icon="img:src/assets/images/icons/logout.svg">
                            Выйти
                        </q-btn>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <DialogMenuMobile v-model="showMobileDialog" :isUserLoggedInProp="isUserLoggedIn"></DialogMenuMobile>
    <AppAuthDialog v-model="showAuthDialog" />
    <q-dialog v-model="showConfirmLogout">
        <q-card class="q-pb-lg bg-uc_fon" style="border-radius: 22px;">
            <q-card-section class="row items-center q-pb-none">
                <q-space />
                <q-btn icon="close" flat round dense v-close-popup color="uc_green" size="lg" />
            </q-card-section>
            <q-card-section class="row items-center q-pa-lg">
                <span class="q-ml-sm h4 text-center text-uc_green">Вы уверены что хотите выйти из
                    аккаунта?</span>
            </q-card-section>

            <q-card-actions align="center" class="q-gutter-y-md">
                <q-btn flat no-caps color="uc_green" size="lg" class="q-px-lg" style="border-radius:  22px"
                    v-close-popup>
                    Да, выйти из аккаунта
                </q-btn>
                <q-btn flat no-caps color="uc_green" size="lg" class="q-px-lg" style="border-radius:  22px"
                    v-close-popup>
                    Нет, вернуться назад
                </q-btn>
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from 'vue'
import DialogMenuMobile from 'src/components/landing/DialogMenuMobile.vue'
import AppAuthDialog from 'src/components/AppAuthDialog.vue';
import AppLink_NewTabIfExt from 'src/components/AppLink_NewTabIfExt.vue';

const showMobileDialog = ref(false); // диалоговое мобилки - там ссылки-якори и кнопка войти, которая открывает AppAuthDialog
const showAuthDialog = ref(false); // показ диалог-окна AppAuthDialog
const showConfirmLogout = ref(false);
const isUserLoggedIn = ref(false); // для хендлинга что юзер залогинен - показывать ли кнопки. Логика ауфа должна быть в AppAuthDialog, чтобы открывать из любой точки приложения

const props = defineProps({
    showLandingLinksProp: {
        type: Boolean,
        default: true
    }
});

const showLandingLinks = props.showLandingLinksProp; // проп для изменения показанных кнопок между лендингом\профилем (скрываются ссылки-якори)
</script>