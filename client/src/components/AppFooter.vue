<template>
    <div class="footer_wrapper">



        <div class="footer_type_1" v-if="footerTypeShown == ''">


            <div class="footer row flex items-center justify-around q-my-lg q-py-md q-gutter-x-lg"
                v-if="$q.screen.gt.xs">
                <div style="max-width: 150px;">
                    <div class="q-mb-lg"><q-img fit="contain" src="src/assets/logo.svg" class="" />
                    </div>
                    <div style="opacity: 0.6;" class="text-primary">© 2025 Text text text</div>
                </div>
                <div class="polAndMadeInBlock">
                    <div class="q-mb-lg">
                        <p style="margin: 0 0 4px;" class="text-primary">Политика конфиденциальности</p>
                        <p class="text-primary">Согласие на обработку персональных данных</p>
                    </div>
                    <div class="flex">
                        <div class="flex items-center q-pr-sm">
                            <p class="text-primary" style="margin: 0 0 0px;">Сделано в</p>
                        </div>
                        <div class="full-height"><q-img fit="contain" src="src/assets/landing/titans_logo.svg"
                                style="width: 140px;" class="" />
                        </div>
                    </div>
                </div>
                <div>
                    <div class="q-mb-sm">
                        <q-btn flat no-caps color="primary" icon="mail" label="info@example" />
                    </div>
                    <div class="flex items-center justify-center q-gutter-md">
                        <q-btn flat round color="primary" icon="img:src\assets\images\icons\Telegram_ucGreen.svg"
                            padding="none" size="lg" />
                        <q-btn flat round color="primary" icon="img:src\assets\images\icons\VK_ucGreen.svg"
                            padding="none" size="lg" />
                    </div>
                </div>
            </div>
            <div class="footer_mobile items-center justify-around q-mt-lg q-py-md q-px-md" v-if="$q.screen.lt.sm">
                <div class="footer_mobile_section row q-mb-sm">
                    <div class="col">
                        <q-img fit="contain" src="src/assets/logo.svg" style="max-width: 200px;" class="" />
                    </div>
                    <div class="col">
                        <div class="q-mb-sm">
                            <q-btn flat no-caps color="primary" icon="mail" label="info@example"
                                :size="$q.screen.width <= 327 ? 'sm' : 'md'" padding="xs" />
                        </div>
                        <div class="flex items-center justify-start q-pl-sm q-gutter-md">
                            <q-btn flat round color="primary" icon="img:src\assets\images\icons\Telegram_ucGreen.svg"
                                padding="none" size="lg" />
                            <q-btn flat round color="primary" icon="img:src\assets\images\icons\VK_ucGreen.svg"
                                padding="none" size="lg" />
                        </div>
                    </div>
                </div>
                <div class="footer_mobile_section q-mb-sm">
                    <div style="max-width: 350px;">
                        <div class="q-mb-lg">
                            <p style="margin: 0 0 4px;" class="text-primary">Политика конфиденциальности</p>
                            <p class="text-primary">Согласие на обработку персональных данных</p>
                        </div>
                        <div class="row">
                            <div class="col-3 flex items-center">
                                <p class="text-primary" style="margin: 0 0 0px;">Сделано в</p>
                            </div>
                            <div class="col-7"><q-img fit="contain" src="src/assets/landing/titans_logo.svg"
                                    style="max-width: 140px;" class="" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer_mobile_section q-pt-md">
                    <div style="opacity: 0.6;" class="text-primary">© 2025 Text text text</div>
                </div>
            </div>


        </div>

        <div class="footer_type_2" v-if="footerTypeShown == 'white'">


            <div class="footer row flex items-center justify-around q-my-lg q-py-md q-gutter-x-lg"
                v-if="$q.screen.gt.xs">
                <div style="max-width: 150px;">
                    <div class="q-mb-lg"><q-img fit="contain" src="src/assets/logo.svg" class="svg_filter_white" />
                    </div>
                    <div style="opacity: 0.6;" class="text-white">© 2025 Text text text</div>
                </div>
                <div class="polAndMadeInBlock">
                    <div class="q-mb-lg">
                        <p style="margin: 0 0 4px;" class="text-white">Политика конфиденциальности</p>
                        <p class="text-white">Согласие на обработку персональных данных</p>
                    </div>
                    <div class="flex">
                        <div class="flex items-center q-pr-sm">
                            <p class="text-white" style="margin: 0 0 0px;">Сделано в</p>
                        </div>
                        <div class="full-height"><q-img fit="contain" src="src/assets/landing/titans_logo.svg"
                                style="width: 140px;" class="svg_filter_white" />
                        </div>
                    </div>
                </div>
                <div>
                    <div class="q-mb-sm">
                        <q-btn flat no-caps color="white" icon="mail" label="info@example" />
                    </div>
                    <div class="flex items-center justify-center q-gutter-md">
                        <q-btn flat round color="white" icon="img:src\assets\images\icons\Telegram_ucGreen.svg"
                            class="svg_filter_white" padding="none" size="lg" />
                        <q-btn flat round color="white" icon="img:src\assets\images\icons\VK_ucGreen.svg"
                            class="svg_filter_white" padding="none" size="lg" />
                    </div>
                </div>
            </div>
            <div class="footer_mobile items-center justify-around q-mt-lg q-py-md q-px-md" v-if="$q.screen.lt.sm">
                <div class="footer_mobile_section row q-mb-sm">
                    <div class="col">
                        <q-img fit="contain" src="src/assets/logo.svg" style="max-width: 200px;"
                            class="svg_filter_white" />
                    </div>
                    <div class="col q-pl-md">
                        <div class="q-mb-sm">
                            <q-btn flat no-caps color="white" icon="mail" label="info@example"
                                :size="$q.screen.width <= 327 ? 'sm' : 'md'" padding="xs" />
                        </div>
                        <div class="flex items-center justify-start q-pl-sm q-gutter-md">
                            <q-btn flat round color="white" icon="img:src\assets\images\icons\Telegram_ucGreen.svg"
                                class="svg_filter_white" padding="none" size="lg" />
                            <q-btn flat round color="white" icon="img:src\assets\images\icons\VK_ucGreen.svg"
                                class="svg_filter_white" padding="none" size="lg" />
                        </div>
                    </div>
                </div>
                <div class="footer_mobile_section q-mb-sm">
                    <div style="max-width: 350px;">
                        <div class="q-mb-lg">
                            <p style="margin: 0 0 4px;" class="text-white">Политика конфиденциальности</p>
                            <p class="text-white">Согласие на обработку персональных данных</p>
                        </div>
                        <div class="row">
                            <div class="col-3 flex items-center">
                                <p class="text-white" style="margin: 0 0 0px;">Сделано в</p>
                            </div>
                            <div class="col-7"><q-img fit="contain" src="src/assets/landing/titans_logo.svg"
                                    style="max-width: 140px;" class="svg_filter_white" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer_mobile_section q-pt-md">
                    <div style="opacity: 0.6;" class="text-white">© 2025 Text text text</div>
                </div>
            </div>


        </div>



    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
// сюда передавать тайп футера, исходя из него показывается определенный футер
const props = defineProps({
    footerTypeProp: {
        type: String,
        required: false,
        default: ""
    }
});
const footerTypeShown = ref("");

async function getfooterTypeShown() {
    if (
        (props.footerTypeProp !== null) ||
        (props.footerTypeProp !== undefined) ||
        (props.footerTypeProp !== '')
    ) {
        footerTypeShown.value = props.footerTypeProp;
    } else footerTypeShown.value = "";
}
onMounted(getfooterTypeShown)
// console.log(footerTypeShown.value)
</script>

<style lang="scss">
.svg_filter_white {
    filter: brightness(0) saturate(100%) invert(100%) sepia(23%) saturate(290%) hue-rotate(187deg) brightness(113%) contrast(100%);
}

.polAndMadeInBlock {
    max-width: 350px;
}

@media (max-width: 744px) {
    .polAndMadeInBlock {
        max-width: 250px;
    }
}
</style>