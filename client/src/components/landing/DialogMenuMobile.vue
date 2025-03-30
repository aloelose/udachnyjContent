<script setup>
import { ref } from 'vue'
import AppLink_NewTabIfExt from 'src/components/AppLink_NewTabIfExt.vue';
import AppAuthDialog from 'src/components/AppAuthDialog.vue';
const showAuthDialog = ref(false);
defineOptions({
    name: "DialogMenuMobile",
});
import { useDialogPluginComponent } from 'quasar'

// console.log(props)
defineEmits([
    // REQUIRED; need to specify some events that your
    // component will emit through useDialogPluginComponent()
    ...useDialogPluginComponent.emits
])

const props = defineProps({
    isUserLoggedInProp: {
        type: Boolean,
        default: false
    }
});
const isUserLoggedIn = ref(props.isUserLoggedInProp);
// const isUserLoggedIn = ref(false); // для хендлинга что юзер залогинен - показывать ли кнопки. Логика ауфа должна быть в AppAuthDialog, чтобы открывать из любой точки приложения
</script>

<template>
    <q-dialog :maximized=true transition-show="slide-up" transition-hide="slide-down">
        <q-card class="bg-uc_light_green text-white">
            <q-bar style="height: 60px;">
                <div style="height: 32px; width: 88px;">
                    <q-img src="src/assets/logo_white.svg" style="height: 100%; width: 100%;" fit="contain" />
                </div>
                <q-space />
                <q-btn dense flat icon="close" v-close-popup size="lg">
                    <q-tooltip class="bg-white text-primary">Close</q-tooltip>
                </q-btn>
            </q-bar>
            <div class="flex flex-center justify-center" style="height: 90%;">
                <div class="q-gutter-lg">
                    <div class="h1 text-center q-pa-md">
                        <AppLink_NewTabIfExt :to="{ name: 'LandingPage', hash: '#landing_section_advantages' }"
                            class="h1 text-center q-pa-md text-white">Преимущества
                        </AppLink_NewTabIfExt>
                    </div>
                    <div class="h1 text-center q-pa-md">
                        <AppLink_NewTabIfExt :to="{ name: 'LandingPage', hash: '#landing_section_events' }"
                            class="h1 text-center q-pa-md text-white">Мероприятие
                        </AppLink_NewTabIfExt>
                    </div>
                    <div class="h1 text-center q-pa-md">
                        <AppLink_NewTabIfExt :to="{ name: 'LandingPage', hash: '#landing_section_speaker' }"
                            class="h1 text-center q-pa-md text-white">Спикеры
                        </AppLink_NewTabIfExt>
                    </div>
                    <div class="h1 text-center q-pa-md">
                        <AppLink_NewTabIfExt :to="{ name: 'LandingPage', hash: '#landing_section_partners' }"
                            class="h1 text-center q-pa-md text-white">Партнеры
                        </AppLink_NewTabIfExt>
                    </div>
                    <div class="flex flex-center justify-center">
                        <q-btn no-caps flat color="green" size="lg" text-color="primary"
                            style="background-color: #EFDFBB;border: solid 2px #315720;" @click="showAuthDialog = true"
                            v-if="!isUserLoggedIn">Войти</q-btn>
                        <q-btn no-caps flat color="green" size="lg" text-color="primary"
                            style="background-color: #EFDFBB;border: solid 2px #315720;" v-if="isUserLoggedIn"
                            :to="{ name: 'LKPage' }">Кабинет</q-btn>
                    </div>
                </div>

            </div>
        </q-card>
        <AppAuthDialog v-model="showAuthDialog" />
    </q-dialog>
</template>