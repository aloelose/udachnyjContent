<script setup>
import { ref, reactive, computed, onUnmounted } from 'vue';
import { api } from 'src/boot/axios';
import { useQuasar } from 'quasar';
import { useRouter } from 'vue-router';
import { useUserStore } from 'stores/userStore';
const userStore = useUserStore();
const router = useRouter();
const $q = useQuasar();
defineOptions({
    name: "AppAuthDialogue",
});
import { useDialogPluginComponent } from 'quasar'

const { dialogRef } = useDialogPluginComponent()

defineEmits([
    ...useDialogPluginComponent.emits
])

const props = defineProps({
    isShowLogin: {
        type: Boolean,
        default: true
    },
});
const showLogin = ref(props.isShowLogin); // for handling what window to show

const form1_isPasswordVisble_1 = ref(true);
const form1_login = ref();
const form1_phoneNumber = ref();
const form1_password_current = ref();

const form1_child_fio = ref();
const form1_child_age = ref();
const form1_parent_fio = ref();

const form1_diagnosis_status = ref(null);
const form1_diagnosis_cipher = ref(null);
const form1_diagnosis_status_options = [
    'Ребёнок с ОВЗ', 'Ребёнок инвалид'
];
const form1_diagnosis_cipher_options = [
    'F80 (специфические расстройства речи и языка)',
    'F 81 (расстройства развития учебных навыков)',
    'F82 (Специфические расстройства развития моторной функции)',
    'ЧF83 (Смешанные специфические расстройства психологического развития)',
    'F84 (Общие расстройства психологического развития – РАС)'
];
const loginApi = {
    formRefs: {
        loginForm: ref(null)
    },
    formIsValid: {
        loginForm: ref(false)
    },
    formFields: reactive({
        userEmail: form1_login,
        password: form1_password_current,
        passwordIsHidden: true,
    }),
    loadingStates: ref({
        login: false
    }),
    async validateForm(formName) {
        const form = this.formRefs[formName].value;
        if (!form) return false;

        const isValid = await form.validate();
        this.formIsValid[formName].value = isValid;
        return isValid;
    },
    get currentFormIsValid() {
        return this.formIsValid.loginForm.value;
    },
    login: async () => {
        const isValid = await loginApi.formRefs.loginForm?.value.validate(true)
        if (!isValid) return

        loginApi.loadingStates.value.login = true;
        try {
            const requestData = {
                email: loginApi.formFields.userEmail,
                password: loginApi.formFields.password,
            };
            const response = await api.post('/login', requestData, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            const { code, message } = response.data;
            if (code === 200) {
                const token = response.data.token;
                localStorage.setItem('authToken', token);
                userStore.refreshUserData();
                $q.notify({ 
                    color: 'uc_green',
                    message: 'Вы успешно вошли в аккаунт!',
                    icon: 'check'
                });
                router.push({ name: 'LKPage' });
            } else {
                $q.notify({
                    color: 'negative',
                    message: message || 'Ошибка при отправлении запроса',
                    icon: 'report_problem'
                });
            }
        } catch (error) {
            let message = 'Ошибка при отправлении запроса';
            if (error.response && error.response.data) {
                const { code, message: errorMessage } = error.response.data;
                switch (code) {
                    case 404:
                        message = 'Ошибка - такой электронной почты не существует';
                        break;
                    case 429:
                        message = 'Ошибка - слишком много запросов. Пожалуйста, попробуйте чуть позже.';
                        break;
                    case 401:
                        message = 'Неверный пароль или email';
                        break;
                    case 500:
                        message = 'Произошла ошибка на сервере, попробуйте позже';
                        break;
                    default:
                        message = errorMessage || message;
                }
            } else if (error.message) {
                message = 'Ошибка соединения с сервером, проверьте ваше интернет-соединение.';
            }
            $q.notify({
                color: 'negative',
                message,
                icon: 'report_problem'
            });
        } finally {
            loginApi.loadingStates.value.login = false;
        }
    }
};
const signinApi = {
    formRefs: {
        signinForm: ref(null)
    },
    formIsValid: {
        signinForm: ref(false)
    },
    formFields: reactive({
      name: form1_parent_fio,
      email: form1_login,
      phone_number: form1_phoneNumber,
      child_name: form1_child_fio,
      child_age: form1_child_age,
      child_status: form1_diagnosis_status,
      child_pmpk_code: form1_diagnosis_cipher,
    }),
  loadingStates: ref({
        signin: false
    }),
    async validateForm(formName) {
        const form = this.formRefs[formName].value;
        if (!form) return false;

        const isValid = await form.validate();
        this.formIsValid[formName].value = isValid;
        return isValid;
    },
    get currentFormIsValid() {
        return this.formIsValid.signinForm.value;
    },
    signin: async () => {
        const isValid = await signinApi.formRefs.signinForm?.value.validate(true)
        if (!isValid) return
        signinApi.loadingStates.value.signin = true;
        try {
            const requestData = {
                name: signinApi.formFields.name,
                email: signinApi.formFields.email,
                phone_number: signinApi.formFields.phone_number,
                child_name: signinApi.formFields.child_name,
                child_age: signinApi.formFields.child_age,
                child_status: signinApi.formFields.child_status,
                child_pmpk_code: signinApi.formFields.child_pmpk_code
            };
            const response = await api.post('/register', requestData, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            const { code, message } = response.data;
            if (code === 201) {
                $q.notify({
                    color: 'uc_green',
                    message: "Аккаунт зарегестрирован, подтверьте свою почту",
                    icon: 'check'
                });
                router.push({ name: 'LKPage' });
            } else {
                $q.notify({
                    color: 'negative',
                    message: message || 'Ошибка при отправлении запроса',
                    icon: 'report_problem'
                });
            }
        } catch (error) {
            let message = 'Ошибка при отправлении запроса';
            if (error.response && error.response.data) {
                const { code, message: errorMessage } = error.response.data;

                switch (code) {
                    case 404:
                        message = 'Ошибка - такой электронной почты не существует';
                        break;
                    case 429:
                        message = 'Ошибка - слишком много запросов. Пожалуйста, попробуйте чуть позже.';
                        break;
                    case 400:
                        message = 'Некорректные данные для регистрации';
                        break;
                    case 500:
                        message = 'Произошла ошибка на сервере, попробуйте позже';
                        break;
                    default:
                        message = errorMessage || message;
                }
            } else if (error.message) {
                message = 'Ошибка соединения с сервером, проверьте ваше интернет-соединение.';
            }
            $q.notify({
                color: 'negative',
                message,
                icon: 'report_problem'
            });
        } finally {
            signinApi.loadingStates.value.signin = false;
        }
    }
};
// restore password functions-----------restore password functions-----------restore password functions-----------restore password functions-----------restore password functions-----------

const timeRemaining = ref(0);
const isCooldown = ref(false);
const intervalId = ref(null);

const formattedTime = computed(() => {
    const minutes = Math.floor(timeRemaining.value / 60);
    const seconds = timeRemaining.value % 60;
    return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
});

const startTimer = () => {
    if (isCooldown.value) return;

    // Set cooldown duration in seconds (5 minutes = 300 seconds)
    timeRemaining.value = 62;
    isCooldown.value = true;

    intervalId.value = setInterval(() => {
        timeRemaining.value -= 1;

        if (timeRemaining.value <= 0) {
            clearInterval(intervalId.value);
            isCooldown.value = false;
        }
    }, 1000);
};

onUnmounted(() => {
    // Cleanup interval when component unmounts
    if (intervalId.value) {
        clearInterval(intervalId.value);
    }
});


// Restore Password API requests------Restore Password API requests------Restore Password API requests------Restore Password API requests------Restore Password API requests------
const restorePasswordDialog = ref(false);
// const restorePasswordState = ref(0); //
// const restorePasswordForms_emailCode = ref("");//
// const restorePasswordForms_newPassword = ref("");//
// const restorePasswordForms_newPasswordIsHidden = ref(true);//
// const restorePassword_EmailWhereWasSend = ref("");
// const loadingStates = ref({ //
//     email: false,
//     code: false,
//     password: false
// });
const restorePasswordApi = {
    formRefs: {
        emailForm: ref(null), // Email form
        codeForm: ref(null), // Code verification form
        newPasswordForm: ref(null)  // Password form
    },
    formIsValid: {
        emailForm: ref(false), // Email form
        codeForm: ref(false), // Code verification form
        newPasswordForm: ref(false)  // Password form
    },
    currentStep: ref(0),
    forms: reactive({
        userEmail: "",
        emailCode: "",
        newPassword: "",
        newPasswordIsHidden: true,
    }),
    loadingStates: ref({
        email: false,
        code: false,
        password: false,
    }),
    // this is weird generated code for handling checking if form is valid
    async validateForm(formName) {
        const form = this.formRefs[formName].value;
        if (!form) return false;

        const isValid = await form.validate();
        this.formIsValid[formName].value = isValid;
        return isValid;
    },
    get currentFormIsValid() {
        const forms = Object.keys(this.formIsValid);
        const currentFormName = forms[this.currentStep.value];
        return this.formIsValid[currentFormName].value;
    },
    writeSendEmail: async () => {
        const isValid = await restorePasswordApi.formRefs.emailForm?.value.validate(true)
        if (!isValid) return
        restorePasswordApi.loadingStates.value.email = true;
        try {
            const requestData = {
                email: form1_login.value
            };
            const response = await api.post('/password/forgot', requestData, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            const { code, message } = response.data;
            if (code === 200) {
                restorePasswordApi.currentStep.value = 1;
                restorePasswordApi.forms.userEmail = form1_login.value;
                startTimer();
                $q.notify({
                    color: 'uc_green',
                    message: 'Сообщение отправлено на вашу электронную почту!',
                    icon: 'check'
                });
            } else {
                $q.notify({
                    color: 'negative',
                    message: message || 'Ошибка при отправлении запроса',
                    icon: 'report_problem'
                });
            }
        } catch (error) {
            let message = 'Ошибка при отправлении запроса';
            if (error.response && error.response.data) {
                const { code, message: errorMessage } = error.response.data;
                switch (code) {
                    case 404:
                        message = 'Пользователь с таким email не найден';
                        break;
                    case 429:
                        message = 'Слишком много запросов. Пожалуйста, попробуйте чуть позже';
                        break;
                    case 400:
                        message = errorMessage || 'Неверный запрос';
                        break;
                    case 500:
                        message = 'Произошла ошибка на сервере, попробуйте позже';
                        break;
                    default:
                        message = errorMessage || message;
                }
            } else if (error.message) {
                message = 'Ошибка соединения с сервером, проверьте ваше интернет-соединение.';
            }
            $q.notify({
                color: 'negative',
                message,
                icon: 'report_problem'
            });
        } finally {
            restorePasswordApi.loadingStates.value.email = false;
        }
    },
    writeSendCodeFromEmail: async () => {
        const isValid = await restorePasswordApi.formRefs.codeForm?.value.validate(true)
        if (!isValid) return
        restorePasswordApi.loadingStates.value.code = true;
        try {
            const requestData = {
                email: restorePasswordApi.forms.userEmail,
                code: restorePasswordApi.forms.emailCode
            };
            const response = await api.post('/password/verify-code', requestData, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            const { code, message } = response.data;
            if (code === 200) {
                restorePasswordApi.currentStep.value = 2;
                $q.notify({
                    color: 'uc_green',
                    message: 'Код подтвержден!',
                    icon: 'check'
                });
            } else {
                $q.notify({
                    color: 'negative',
                    message: message || 'Ошибка при подтверждении кода',
                    icon: 'report_problem'
                });
            }
        } catch (error) {
            let message = 'Ошибка при отправлении запроса';
            if (error.response && error.response.data) {
                const { code, message: errorMessage } = error.response.data;
                switch (code) {
                    case 400:
                        message = 'Истек срок годности кода или код неверен';
                        break;
                    case 410:
                        message = 'Истек срок годности кода';
                        break;
                    case 404:
                        message = 'Пользователь с таким email не найден';
                        break;
                    case 500:
                        message = 'Произошла ошибка на сервере, попробуйте позже';
                        break;
                    default:
                        message = errorMessage || message;
                }
            } else if (error.message) {
                message = 'Ошибка соединения с сервером, проверьте ваше интернет-соединение.';
            }
            $q.notify({
                color: 'negative',
                message,
                icon: 'report_problem'
            });
        } finally {
            restorePasswordApi.loadingStates.value.code = false;
        }
    },
    writeSendNewPassword: async () => {
        const isValid = await restorePasswordApi.formRefs.newPasswordForm?.value.validate(true)
        if (!isValid) return
        restorePasswordApi.loadingStates.value.password = true;
        try {
            const requestData = {
                email: form1_login.value,
                code: restorePasswordApi.forms.emailCode,
                password: restorePasswordApi.forms.newPassword,
            };
            const response = await api.post('/password/reset', requestData, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            const { code, message } = response.data;
            if (code === 200) {
                restorePasswordApi.currentStep.value = 0;
                restorePasswordDialog.value = false;
                $q.notify({
                    color: 'uc_green',
                    message: 'Пароль успешно изменен, вы можете использовать его для входа в аккаунт',
                    icon: 'check'
                });
            } else {
                $q.notify({
                    color: 'negative',
                    message: message || 'Ошибка при изменении пароля',
                    icon: 'report_problem',
                    timeout: 3000
                });
            }
        } catch (error) {
            let message = 'Ошибка - изменение пароля провалено';
            if (error.response && error.response.data) {
                const { code, message: errorMessage } = error.response.data;
                switch (code) {
                    case 400:
                        message = 'Ваш новый пароль слишком простой, пожалуйста, придумайте другой пароль';
                        break;
                    case 401:
                        message = 'Срок действия сессии истек, закройте это окно и повторите процедуру введения кода снова';
                        break;
                    case 409:
                        message = 'Новый пароль не может совпадать со старым паролем';
                        break;
                    case 500:
                        message = 'Произошла ошибка на сервере, попробуйте позже';
                        break;
                    default:
                        message = errorMessage || message;
                }
            } else if (error.message) {
                message = 'Ошибка соединения с сервером, проверьте ваше интернет-соединение.';
            }
            $q.notify({
                color: 'negative',
                message,
                icon: 'report_problem',
                timeout: 3000
            });
        } finally {
            restorePasswordApi.loadingStates.value.password = false;
        }
    }
};
</script>
<template>
    <q-dialog ref="dialogRef" persistent maximized>
        <q-card class="bg-uc_light_green reg_wrapper" v-if="showLogin">
            <q-bar class="q-pa-xl fixed-full z-top"
                style="height: 60px; background-color: transparent;  pointer-events: auto;" v-if="$q.screen.gt.sm">
                <q-space />
                <q-btn dense flat round icon="close" v-close-popup size="lg"
                    :color="$q.screen.lt.md ? 'uc_green' : 'white'"
                    :style="$q.screen.lt.md ? 'border: solid 2px #315720' : 'border: solid 2px white'">
                    <q-tooltip class="bg-white text-primary">Закрыть</q-tooltip>
                </q-btn>
            </q-bar>
            <div class="fullscreen row" style="pointer-events: none">
                <div class="login_emptySpaceImg col-12 col-md" style="min-height: 50%;">
                    <q-bar class="q-pa-xl fixed-full z-top"
                        style="height: 60px; background-color: transparent; pointer-events: auto;"
                        v-if="$q.screen.lt.md">
                        <q-space />
                        <q-btn dense flat round icon="close" v-close-popup size="lg"
                            :color="$q.screen.lt.md ? 'uc_green' : 'white'"
                            :style="$q.screen.lt.md ? 'border: solid 2px #315720' : 'border: solid 2px white'">
                            <q-tooltip class="bg-white text-primary">Закрыть</q-tooltip>
                        </q-btn>
                    </q-bar>
                </div>
                <div class="login_bgVectorClouds col-12 col-md flex flex-center">
                    <q-form :ref="loginApi.formRefs.loginForm" @submit.prevent="loginApi.login" no-error-focus
                        class="login_form_wrapper q-pa-md q-gutter-y-md"
                        style="width: 100%; max-width: 580px; pointer-events: auto;">
                        <div class="text-center font_Sunday h1 text-white q-pb-md">Авторизация</div>

                        <div class="q-gutter-y-md q-pb-md">
                            <q-input bg-color="light_yellow" label-color="uc_light_green" placeholder="Email" outlined
                                rounded v-model="form1_login" type="email" class="input_field_UCStyle" :rules="[
                                    val => !!val || 'Пожалуйста, напишите свою электронную почту',
                                    val => /.+@.+\..+/.test(val) || 'Неверный email'
                                ]" lazy-rules reactive-rules @update:model-value="loginApi.validateForm('loginForm')">
                                <template v-slot:prepend>
                                    <div class="q-px-xs"></div>
                                </template>
                            </q-input>
                            <q-input bg-color="light_yellow" v-model="form1_password_current" placeholder="Пароль"
                                outlined rounded :type="form1_isPasswordVisble_1 ? 'password' : 'text'"
                                class="input_field_UCStyle" :rules="[
                                    val => !!val || 'Пожалуйста, напишите свой пароль'
                                ]" lazy-rules reactive-rules @update:model-value="loginApi.validateForm('loginForm')">
                                <template v-slot:prepend>
                                    <div class="q-px-xs"></div>
                                </template>
                                <template v-slot:append>
                                    <q-icon :name="form1_isPasswordVisble_1 ? 'visibility_off' : 'visibility'"
                                        class="cursor-pointer q-pr-sm"
                                        @click="form1_isPasswordVisble_1 = !form1_isPasswordVisble_1" />
                                </template>
                            </q-input>
                        </div>

                        <div class="q-gutter-y-md q-pb-md">
                            <div @click="restorePasswordDialog = true" class="text-white" style="cursor: pointer;">Не
                                помню пароль
                            </div>
                            <q-btn type="submit" flat no-caps size="xl" class="q-pa-none full-width"
                                style="border-radius: 22px" :loading="loginApi.loadingStates.value.login"
                                :disable="!loginApi.currentFormIsValid">
                                <template v-slot:loading>
                                    <div class="full-width ucButtonToQuasar__wrapper_1_white text-white">
                                        <div class="ucButtonToQuasar__wrapper_2_white q-px-xl q-py-sm">
                                            <q-spinner-hourglass class="on-left" color="white" />
                                            Загрузка...
                                        </div>
                                    </div>
                                </template>
                                <template v-slot:default>
                                    <div class="full-width ucButtonToQuasar__wrapper_1"
                                        :class="loginApi.currentFormIsValid ? '' : 'ucButtonToQuasar__wrapper_1_disable'">
                                        <div class="ucButtonToQuasar__wrapper_2 q-px-xl q-py-sm">
                                            Войти
                                        </div>
                                    </div>
                                </template>
                            </q-btn>
                        </div>

                        <div class="text-white text-center" style="cursor: pointer;" @click="showLogin = !showLogin">Нет
                            аккаунта?
                            Зарегистрироваться
                        </div>

                    </q-form>
                </div>
            </div>
        </q-card>
        <q-card class="login_wrapper" style="background-color: #EFDFBB;" v-if="!showLogin">
            <div class="fullscreen row" style="pointer-events: none">
                <div class="signIn_emptySpaceImg col-12 col-md" style="min-height: 50%;" v-if="$q.screen.gt.sm">
                </div>
                <div class="signIn_bgVectorClouds col-12 col-md flex flex-center">
                    <q-form :ref="signinApi.formRefs.signinForm" @submit.prevent="signinApi.signin" no-error-focus
                        class="login_form_wrapper q-pa-md q-gutter-y-md"
                        style="width: 100%; max-width: 580px; pointer-events: auto;">
                        <div class="text-center text-uc_green q-pb-md" v-if="$q.screen.lt.md">
                            <div class="font_Sunday h3 q-pb-md">Вступайте в команду «у-Дачников»</div>
                            <div>Заполните все поля и получите доступ к летнему курсу видеоуроков «Занимаемся на даче —
                                У-Дачный
                                контент»</div>
                        </div>


                        <div class="q-gutter-y-md q-pb-md">
                            <q-input bg-color="light_yellow" outlined rounded v-model="form1_child_fio"
                                placeholder="Ф.И.О ребёнка" class="input_field_UCStyle" :rules="[
                                    val => !!val || 'Пожалуйста, заполните это поле'
                                ]" lazy-rules reactive-rules
                                @update:model-value="signinApi.validateForm('signinForm')">
                                <template v-slot:prepend>
                                    <div class="q-px-xs"></div>
                                </template>
                            </q-input>
                            <q-input bg-color="light_yellow" outlined rounded v-model.number="form1_child_age"
                                type="number" placeholder="Возраст ребенка" class="input_field_UCStyle" :rules="[
                                    val => !!val || 'Пожалуйста, заполните это поле'
                                ]" lazy-rules reactive-rules
                                @update:model-value="signinApi.validateForm('signinForm')">
                                <template v-slot:prepend>
                                    <div class="q-px-xs"></div>
                                </template>
                            </q-input>
                            <q-input bg-color="light_yellow" outlined rounded v-model="form1_parent_fio"
                                placeholder="Ф.И.О законного представителя" class="input_field_UCStyle" :rules="[
                                    val => !!val || 'Пожалуйста, заполните это поле'
                                ]" lazy-rules reactive-rules
                                @update:model-value="signinApi.validateForm('signinForm')">
                                <template v-slot:prepend>
                                    <div class="q-px-xs"></div>
                                </template>
                            </q-input>
                            <q-select bg-color="light_yellow"
                                popup-content-class="ucSelectToQuasar__popup_content_class" outlined rounded
                                v-model="form1_diagnosis_status" :options="form1_diagnosis_status_options"
                                label="Статус ребенка" class="input_field_UCStyle" :rules="[
                                    val => !!val || 'Пожалуйста, заполните это поле'
                                ]" lazy-rules reactive-rules
                                @update:model-value="signinApi.validateForm('signinForm')">
                                <template v-slot:prepend>
                                    <div class="q-px-xs"></div>
                                </template>
                            </q-select>
                            <q-select bg-color="light_yellow"
                                popup-content-class="ucSelectToQuasar__popup_content_class" outlined rounded
                                v-model="form1_diagnosis_cipher" :options="form1_diagnosis_cipher_options"
                                label="Шифр по ПМПК" class="input_field_UCStyle" :rules="[
                                    val => !!val || 'Пожалуйста, заполните это поле'
                                ]" lazy-rules reactive-rules
                                @update:model-value="signinApi.validateForm('signinForm')">
                                <template v-slot:prepend>
                                    <div class="q-px-xs"></div>
                                </template>
                            </q-select>
                            <q-input bg-color="light_yellow" outlined rounded v-model="form1_phoneNumber"
                                label="Телефон" mask="8 (###) ###-##-##" fill-mask class="input_field_UCStyle" :rules="[
                                    val => !!val || 'Пожалуйста, заполните это поле'
                                ]" lazy-rules reactive-rules
                                @update:model-value="signinApi.validateForm('signinForm')">
                                <template v-slot:prepend>
                                    <div class="q-px-xs"></div>
                                </template>
                            </q-input>
                            <q-input bg-color="light_yellow" label-color="uc_light_green" placeholder="Email" outlined
                                rounded v-model="form1_login" type="email" class="input_field_UCStyle" :rules="[
                                    val => !!val || 'Пожалуйста, напишите свою электронную почту',
                                    val => /.+@.+\..+/.test(val) || 'Неверный email'
                                ]" lazy-rules reactive-rules
                                @update:model-value="signinApi.validateForm('signinForm')">
                                <template v-slot:prepend>
                                    <div class="q-px-xs"></div>
                                </template>
                            </q-input>
                        </div>

                        <div class="q-gutter-y-md q-pb-md">
                            <q-btn type="submit" flat no-caps size="xl" class="q-pa-none full-width"
                                style="border-radius: 22px" :loading="signinApi.loadingStates.value.login"
                                :disable="!signinApi.currentFormIsValid">
                                <template v-slot:loading>
                                    <div class="full-width ucButtonToQuasar__wrapper_1_uc_green text-uc_green">
                                        <div class="ucButtonToQuasar__wrapper_2_uc_green q-px-xl q-py-sm">
                                            <q-spinner-hourglass class="on-left" color="uc_green" />
                                            Загрузка...
                                        </div>
                                    </div>
                                </template>
                                <template v-slot:default>
                                    <div class="full-width ucButtonToQuasar__wrapper_1"
                                        :class="signinApi.currentFormIsValid ? '' : 'ucButtonToQuasar__wrapper_1_disable'">
                                        <div class="ucButtonToQuasar__wrapper_2 q-px-xl q-py-sm">
                                            Войти
                                        </div>
                                    </div>
                                </template>
                            </q-btn>
                        </div>

                        <div class="text-uc_green text-center" style="cursor: pointer;" @click="showLogin = !showLogin">
                            Уже
                            есть
                            аккаунт?
                            Войти
                        </div>

                    </q-form>
                </div>
            </div>
            <q-bar class="q-pa-xl fixed-full z-top"
                style="height: 60px; background-color: transparent;  pointer-events: auto;">
                <q-space />
                <q-btn dense flat round icon="close" v-close-popup size="lg" color="uc_green"
                    style="border: solid 2px #315720;background-color: #EFDFBB;">
                    <q-tooltip class="bg-white text-primary">Закрыть</q-tooltip>
                </q-btn>
            </q-bar>
        </q-card>
        <!-- Second dialog -->
        <q-dialog v-model="restorePasswordDialog" persistent maximized>
            <q-card class="fullscreen bg-uc_light_green">
                <div class="fullscreen restorePassword_dialog flex flex-center">

                    <div class="restorePassword_formWrapper flex flex-center q-pa-md"
                        style="width: 100%; max-width: 650px; pointer-events: auto;">

                        <div class="bg-uc_fon q-pa-lg" style="border-radius: 20px; height: 100%;"
                            :class="$q.screen.lt.md ? 'fullscreen' : ''"
                            :style="$q.screen.lt.md ? '' : 'max-width: 426px'">
                            <div class="q-gutter-y-md restorePassword_formWrapper_fields" style="height: 100%;">
                                <q-bar style="height: 60px; background-color: transparent;  pointer-events: auto;">
                                    <q-space />
                                    <q-btn dense flat round icon="close" v-close-popup size="lg" color="uc_green"
                                        style="border: solid 2px #315720"
                                        @click="restorePasswordApi.currentStep.value = 0">
                                        <q-tooltip class="bg-white text-primary">Закрыть</q-tooltip>
                                    </q-btn>
                                </q-bar>
                                <div class="flex flex-center" style="height: 80%;">

                                    <div class="q-gutter-y-md">

                                        <div class="text-center font_Sunday h1 text-uc_green q-pb-xl">Восстановление
                                            пароля
                                        </div>
                                        <q-form :ref="restorePasswordApi.formRefs.emailForm"
                                            @submit.prevent="restorePasswordApi.writeSendEmail" class="q-gutter-y-md"
                                            v-if="restorePasswordApi.currentStep.value == 0">
                                            <q-input bg-color="light_yellow" label-color="uc_light_green"
                                                placeholder="Email" outlined rounded v-model="form1_login" type="email"
                                                class="input_field_UCStyle" input-class="text-uc_green" :rules="[
                                                    val => !!val || 'Пожалуйста, напишите свою электронную почту',
                                                    val => /.+@.+\..+/.test(val) || 'Неверный email'
                                                ]" lazy-rules reactive-rules
                                                @update:model-value="restorePasswordApi.validateForm('emailForm')">
                                                <template v-slot:prepend>
                                                    <div class="q-px-xs"></div>
                                                </template>
                                            </q-input>
                                            <q-btn flat no-caps size="xl" type="submit" class="q-pa-none full-width"
                                                style="border-radius: 22px"
                                                :loading="restorePasswordApi.loadingStates.value.email"
                                                :disable="!restorePasswordApi.currentFormIsValid">
                                                <template v-slot:loading>
                                                    <div
                                                        class="full-width ucButtonToQuasar__wrapper_1_uc_green text-uc_green">
                                                        <div
                                                            class="ucButtonToQuasar__wrapper_2_uc_green q-px-xl q-py-sm">
                                                            <q-spinner-hourglass class="on-left" color="uc_green" />
                                                            Загрузка...
                                                        </div>
                                                    </div>
                                                </template>
                                                <template v-slot:default>
                                                    <div class="full-width ucButtonToQuasar__wrapper_1"
                                                        :class="restorePasswordApi.currentFormIsValid ? '' : 'ucButtonToQuasar__wrapper_1_disable'">
                                                        <div class="ucButtonToQuasar__wrapper_2 q-px-xl q-py-sm">
                                                            Далее
                                                        </div>
                                                    </div>
                                                </template>
                                            </q-btn>
                                        </q-form>
                                        <q-form :ref="restorePasswordApi.formRefs.codeForm"
                                            @submit.prevent="restorePasswordApi.writeSendCodeFromEmail"
                                            class="q-gutter-y-md" v-if="restorePasswordApi.currentStep.value == 1">
                                            <div class="text-uc_green text-center text-weight-bold h6">Введите код с
                                                почты
                                            </div>
                                            <q-input bg-color="light_yellow" label-color="uc_light_green"
                                                placeholder="Введите код с почты" outlined rounded
                                                v-model="restorePasswordApi.forms.emailCode" class="input_field_UCStyle"
                                                input-class="text-uc_green"
                                                :rules="[val => !!val || 'Пожалуйста, напишите код с почты']" lazy-rules
                                                reactive-rules
                                                @update:model-value="restorePasswordApi.validateForm('codeForm')">
                                                <template v-slot:prepend>
                                                    <div class="q-px-xs"></div>
                                                </template>
                                            </q-input>
                                            <div class="text-uc_green">
                                                <div class="q-mb-md">Мы отправили проверочный код на почту по адресу {{
                                                    restorePasswordApi.forms.userEmail }}.
                                                    Если
                                                    сообщение не пришло, повторите попытку.</div>
                                                <div
                                                    class="send_again_timerAndText_wrapper row text-uc_green text-weight-bold h6">
                                                    <div class="send_again_text col-8">Отправить код еще раз</div>
                                                    <div class="send_again_timer col-4 text-right">через {{
                                                        formattedTime }}
                                                    </div>
                                                </div>
                                            </div>
                                            <q-btn flat no-caps size="xl" type="submit" class="q-pa-none full-width"
                                                style="border-radius: 22px"
                                                :loading="restorePasswordApi.loadingStates.value.code"
                                                :disable="!restorePasswordApi.currentFormIsValid">
                                                <template v-slot:loading>
                                                    <div
                                                        class="full-width ucButtonToQuasar__wrapper_1_uc_green text-uc_green">
                                                        <div
                                                            class="ucButtonToQuasar__wrapper_2_uc_green q-px-xl q-py-sm">
                                                            <q-spinner-hourglass class="on-left" color="uc_green" />
                                                            Загрузка...
                                                        </div>
                                                    </div>
                                                </template>
                                                <template v-slot:default>
                                                    <div class="full-width ucButtonToQuasar__wrapper_1"
                                                        :class="restorePasswordApi.currentFormIsValid ? '' : 'ucButtonToQuasar__wrapper_1_disable'">
                                                        <div class="ucButtonToQuasar__wrapper_2 q-px-xl q-py-sm">
                                                            Далее
                                                        </div>
                                                    </div>
                                                </template>
                                            </q-btn>
                                        </q-form>
                                        <q-form :ref="restorePasswordApi.formRefs.newPasswordForm"
                                            @submit.prevent="restorePasswordApi.writeSendNewPassword"
                                            class="q-gutter-y-md" v-if="restorePasswordApi.currentStep.value == 2">
                                            <q-input bg-color="light_yellow"
                                                v-model="restorePasswordApi.forms.newPassword"
                                                placeholder="Введите новый пароль" outlined rounded
                                                :type="restorePasswordApi.forms.newPasswordIsHidden ? 'password' : 'text'"
                                                class="input_field_UCStyle" input-class="text-uc_green" :rules="[
                                                    val => !!val || 'Пожалуйста, напишите свой новый пароль',
                                                    val => val.length >= 6 || 'Минимум 6 символов'
                                                ]" lazy-rules reactive-rules
                                                @update:model-value="restorePasswordApi.validateForm('newPasswordForm')">
                                                <template v-slot:prepend>
                                                    <div class="q-px-xs"></div>
                                                </template>
                                                <template v-slot:append>
                                                    <q-icon
                                                        :name="restorePasswordApi.forms.newPasswordIsHidden ? 'visibility_off' : 'visibility'"
                                                        class="cursor-pointer q-pr-sm"
                                                        @click="restorePasswordApi.forms.newPasswordIsHidden = !restorePasswordApi.forms.newPasswordIsHidden" />
                                                </template>
                                            </q-input>
                                            <q-btn flat no-caps size="xl" type="submit" class="q-pa-none full-width"
                                                style="border-radius: 22px"
                                                :loading="restorePasswordApi.loadingStates.value.password"
                                                :disable="!restorePasswordApi.currentFormIsValid">
                                                <template v-slot:loading>
                                                    <div
                                                        class="full-width ucButtonToQuasar__wrapper_1_uc_green text-uc_green">
                                                        <div
                                                            class="ucButtonToQuasar__wrapper_2_uc_green q-px-xl q-py-sm">
                                                            <q-spinner-hourglass class="on-left" color="uc_green" />
                                                            Загрузка...
                                                        </div>
                                                    </div>
                                                </template>
                                                <template v-slot:default>
                                                    <div class="full-width ucButtonToQuasar__wrapper_1"
                                                        :class="restorePasswordApi.currentFormIsValid ? '' : 'ucButtonToQuasar__wrapper_1_disable'">
                                                        <div class="ucButtonToQuasar__wrapper_2 q-px-xl q-py-sm">
                                                            Далее
                                                        </div>
                                                    </div>
                                                </template>
                                            </q-btn>
                                        </q-form>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </q-card>
        </q-dialog>
    </q-dialog>
</template>

<style lang="scss" scoped>
.input_field_UCStyle :deep(.q-field__control) {
    border-radius: 22px !important;
}

.login_bgVectorClouds {
    background: url(../assets/images/authDialog/login_bgVectorClouds.svg) repeat;
    background-clip: border-box;
    background-position-x: left;
    background-position-y: top;
}

.login_emptySpaceImg {
    background: url(../assets/images/authDialog/login_emptySpaceImg_desktop.webp) no-repeat;
    background-size: 986px auto;
    background-position-x: right;
    background-position-y: bottom;
}

.signIn_bgVectorClouds {
    background: url(../assets/images/authDialog/signIn_bgVectorClouds.svg) repeat;
    background-clip: border-box;
    background-position-x: center;
    background-position-y: center;
}

.signIn_emptySpaceImg {
    background: url(../assets/images/authDialog/signIn_emptySpaceImg_desktop.webp) no-repeat;
    background-color: #E2B377;
    background-size: auto auto;
    background-position-x: center; // (посмотреть подробнее из-за суб-пиксельного рендеринга)
    background-position-y: top;
}

.restorePassword_dialog {
    background: url(../assets/images/authDialog/restorePassword_bgClouds.svg) repeat;
    background-clip: border-box;
    background-position-x: center;
    background-position-y: center;
}

@media (max-width: 1024px) {
    .login_bgVectorClouds {
        background: url(../assets/images/authDialog/login_bgVectorClouds_tablet.svg) repeat;
    }

    .login_emptySpaceImg {
        background: url(../assets/images/authDialog/login_emptySpaceImg_tablet.webp) no-repeat;
        background-size: auto 100%;
        background-clip: border-box;
        background-position-x: center;
        background-position-y: bottom;
    }
}
</style>
