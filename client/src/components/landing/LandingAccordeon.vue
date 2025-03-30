<script>
/* eslint-disable vue/no-unused-vars */
</script>

<template>
    <q-item class="q-pa-md" style="max-width: 850px; width: 100%;">
        <q-list bordered class="landing_accordeon bg-uc_light_green text-white q-pa-md no-border"
            style="border-radius: 20px; width: 100%;" dense>
            <q-expansion-item expand-separator label="Психомоторика" header-class="font_Sunday" class="q-pt-md"
                expand-icon-class="text-white">
                <template v-slot:header="{ expanded: _ }">
                    <q-item-section avatar>
                        <q-avatar size="30px">
                            <img src="src/assets/landing/blocks/circleNumber_1.svg">
                        </q-avatar>
                    </q-item-section>

                    <q-item-section>
                        Психомоторика
                    </q-item-section>
                </template>
                <q-card class="bg-uc_fon text-black" style="border-radius: 0 0 20px 20px / 0% 0% 20px 20px ;">
                    <q-card-section class="">
                        При работе с детьми с особыми потребностями развиваем физические навыки: координацию, моторику
                        и равновесие совместно с психологическими навыками, улучшая концентрацию, память, самооценку
                        и социальное взаимодействие.
                    </q-card-section>
                </q-card>
            </q-expansion-item>

            <q-expansion-item expand-separator label="Формат" header-class="font_Sunday" expand-icon-class="text-white">
                <template v-slot:header="{ expanded: _ }">
                    <q-item-section avatar>
                        <q-avatar size="30px">
                            <img src="src/assets/landing/blocks/circleNumber_2.svg">
                        </q-avatar>
                    </q-item-section>

                    <q-item-section>
                        Формат
                    </q-item-section>
                </template>
                <q-card class="bg-uc_fon text-black" style="border-radius: 0 0 20px 20px / 0% 0% 20px 20px ;">
                    <q-card-section>
                        12 выпусков коррекционно-развивающего видеоконтента разбитые по летним месяцам формате
                        10-минутных
                        занятий на даче, в том числе: упражнения и игры, разные элементы движения по логоритмике, игры
                        с предметами и другие активности для развития ребёнка.
                    </q-card-section>
                </q-card>
            </q-expansion-item>

            <q-expansion-item expand-separator label="Медиакомпетентность" header-class="font_Sunday"
                expand-icon-class="text-white">
                <template v-slot:header="{ expanded: _ }">
                    <q-item-section avatar>
                        <q-avatar size="30px">
                            <img src="src/assets/landing/blocks/circleNumber_3.svg">
                        </q-avatar>
                    </q-item-section>

                    <q-item-section>
                        Медиакомпетентность
                    </q-item-section>
                </template>
                <q-card class="bg-uc_fon text-black" style="border-radius: 0 0 20px 20px / 0% 0% 20px 20px ;">
                    <q-card-section>
                        Короткие видеоролики с совместным участием педагогов, логопедов, нейропсихологов и детей с ОВЗ,
                        направленные на развитие психомоторики, речи и когнитивных функций, поднимут уровень умений
                        ребенки
                        и
                        помогут с развитием критического твор­ческого мышления.
                    </q-card-section>
                </q-card>
            </q-expansion-item>
        </q-list>
    </q-item>
</template>

<style lang="scss" scoped>
.landing_accordeon::before {
    pointer-events: none;
    content: '';
    background-image: url(../../assets/landing/blocks/Vector_cloud.svg);
    background-size: contain;
    background-repeat: no-repeat;
    width: 220px;
    height: 113px;
    position: absolute;
    top: -50px;
    /* Half of image height to center on edge */
    left: 63%;
    transform: translateX(-20%);
    display: block;
    z-index: 1;
}

.landing_accordeon::after {
    pointer-events: none;
    content: '';
    background-image: url(../../assets/landing/blocks/Vector_cloud.svg);
    background-size: contain;
    background-repeat: no-repeat;
    width: 150px;
    height: 113px;
    position: absolute;
    top: -20px;
    /* Half of image height to center on edge */
    left: 20%;
    transform: translateX(-20%);
    display: block;
    z-index: 1;
}

@media (max-width: 1440px) {
    .landing_accordeon::before {
        width: 165px;
        height: 75px;
        top: -30px;
        left: 58%;
    }

    .landing_accordeon::after {
        width: 100px;
        height: 50px;
        top: -10px;
        left: 20%;
    }
}

@media (max-width: 744px) {
    .landing_accordeon::before {
        width: 145px;
        height: 75px;
        top: -30px;
        left: 55%;
    }

    .landing_accordeon::after {
        width: 100px;
        height: 50px;
        top: -10px;
        left: 18%;
    }
}

@media (max-width: 440px) {
    .landing_accordeon::before {
        width: 165px;
        height: 75px;
        top: -30px;
        left: 58%;
    }

    .landing_accordeon::after {
        width: 100px;
        height: 50px;
        top: -10px;
        left: 20%;
    }
}

@media (max-width: 380px) {
    .landing_accordeon::before {
        width: 135px;
        height: 75px;
        top: -20px;
        left: 58%;
    }

    .landing_accordeon::after {
        width: 100px;
        height: 50px;
        top: -10px;
        left: 20%;
    }
}
</style>