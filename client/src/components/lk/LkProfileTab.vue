<script setup>
import { ref, computed, reactive, onMounted, watchEffect } from 'vue';
import { useQuasar } from 'quasar';
import { api } from 'src/boot/axios';
import { useUserStore } from 'stores/userStore';
const $q = useQuasar();
const dense = false;
const isPasswordVisble_1 = ref(true);
const isPasswordVisble_2 = ref(true);
const isPasswordVisble_3 = ref(true);

const login = ref("loginexample@mail.com");
const phoneNumber = ref();
const password_current = ref();
const password_new = ref();
const password_newRepeat = ref();

const child_fio = ref();
const child_age = ref();
const parent_fio = ref();

const diagnosis_status = ref(null);
const diagnosis_cipher = ref(null);
const diagnosis_status_options = [
  'Ребёнок с ОВЗ', 'Ребёнок инвалид'
];
const diagnosis_cipher_options = [
  'F80 (специфические расстройства речи и языка)',
  'F 81 (расстройства развития учебных навыков)',
  'F82 (Специфические расстройства развития моторной функции)',
  'ЧF83 (Смешанные специфические расстройства психологического развития)',
  'F84 (Общие расстройства психологического развития – РАС)'
];
const token = localStorage.getItem('authToken'); 
const userStore = useUserStore();

onMounted(() => {
  userStore.loadUserData($q);
  updateTicketProgression();
});
watchEffect(() => {
  login.value = userStore.login;
  phoneNumber.value = userStore.phoneNumber;
  child_fio.value = userStore.child_fio;
  child_age.value = userStore.child_age;
  parent_fio.value = userStore.parent_fio;
  diagnosis_status.value = userStore.diagnosis_status;
  diagnosis_cipher.value = userStore.diagnosis_cipher;
});

const redactUserDataApi = {
  formRefs: {
    redactUserForm: ref(null)
  },
  formIsValid: {
    redactUserForm: ref(false)
  },
  formFields: reactive({
    userEmail: "",
    password: "",
    passwordIsHidden: true,
  }),
  loadingStates: ref({
    redactUser: false
  }),
  async validateForm(formName) {
    const form = this.formRefs[formName].value;
    if (!form) return false;

    const isValid = await form.validate();
    this.formIsValid[formName].value = isValid;
    return isValid;
  },
  get currentFormIsValid() {
    return this.formIsValid.redactUserForm.value;
  },
  redactUser: async () => {
    const isValid = await redactUserDataApi.formRefs.redactUserForm?.value.validate(true);
    if (!isValid) return;
    redactUserDataApi.loadingStates.value.redactUser = true;
    try {
        const requestData = {
            email: login.value,
            full_name: parent_fio.value,
            phone_number: phoneNumber.value,
            child_full_name: child_fio.value,
            child_age: child_age.value,
            child_status: diagnosis_status.value,
            child_pmpk_code: diagnosis_cipher.value,
            current_password: password_current.value,
            new_password: password_new.value,
            new_password_confirmation: password_newRepeat.value
        };
        const response = await api.put('/user/update', requestData, {
            headers: {
                Authorization: `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        });
        if (response.data.code === 200) {
          userStore.refreshUserData();
            $q.notify({
                color: 'uc_green',
                message: 'Вы успешно отредактировали данные своего аккаунта!',
                icon: 'check'
            });
        } else {
            const errorMessage = response.data.message || 'Произошла ошибка при обновлении данных!';
             $q.notify({
                color: 'negative',
                message: errorMessage,
                icon: 'error'
            });
        }
      } 
      catch (error) {
          let message = 'Ошибка при отправлении запроса';
          if (error.response) {
              switch (error.response.status) {
                  case 404:
                      message = 'Ошибка - такой электронной почты не существует';
                      break;
                  case 429:
                      message = 'Ошибка - слишком много запросов. Пожалуйста, попробуйте чуть позже.';
                      break;
                  case 400: 
                      message = error.response.data.message || 'Ошибка с данными в запросе';
                      break;
                  default:
                      message = error.response.data?.message || message;
              }
          } else {
              message = 'Произошла ошибка, но не удалось получить данные об ошибке.';
          }
          $q.notify({
              color: 'negative',
              message,
              icon: 'report_problem'
          });
      } finally {
          redactUserDataApi.loadingStates.value.redactUser = false;
      }
  }
};

const ticketProgression = ref(0); // 0-12 (0 = all locked, 12 = all unlocked)
const updateTicketProgression = async () => {
  try {
    const response = await api.get('/lessons/completed', {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json'
      }
    });
    if (response.data) {
      ticketProgression.value = response.data.completed_lessons.length;
    }
  } catch (error) {
    console.error('Ошибка при получении списка пройденных уроков:', error);
  }
};
const isTicketFullyUnlocked = computed(() => ticketProgression.value === 12);
const blocks = computed(() =>
  Array.from({ length: 12 }, (_, i) => ({
    id: i,
    locked: i >= ticketProgression.value,
    progress: i < ticketProgression.value ? 100 : 0
  }))
);

// Example of how you would update the progression later:
// function updateProgressionFromServer(newValue) {
//   ticketProgression.value = Math.min(Math.max(newValue, 0), 12);
// }
</script>

<template>
  <q-form :ref="redactUserDataApi.formRefs.redactUserForm" @submit.prevent="redactUserDataApi.redactUser" no-error-focus
    class="input_fieldsAndSubmit_wrapper q-pb-lg q-mb-lg">
    <div class="input_fields_wrapper row q-gutter-y-sm q-pb-sm"
      :class="$q.screen.lt.sm ? 'q-gutter-x-sm' : 'q-gutter-x-lg'">
      <div class="field_column_no_styles col-12 col-md q-gutter-y-md q-pb-md">
        <div>
          <div class="q-mb-md">Логин</div>
          <div>
            <q-input bg-color="light_yellow" label-color="uc_light_green" input-class="text-uc_light_green" outlined
              rounded v-model="login" type="email" disable class="input_field_UCStyle" readonly :rules="[
                val => !!val || 'Пожалуйста, заполните это поле'
              ]" lazy-rules reactive-rules>
              <template v-slot:prepend>
                <div class="q-px-xs"></div>
              </template>
            </q-input>
          </div>
        </div>
        <div>
          <div class="q-mb-md">Телефон</div>
          <div>
            <q-input bg-color="light_yellow" outlined rounded v-model="phoneNumber" mask="8 (###) ###-##-##" fill-mask
              class="input_field_UCStyle" :rules="[
                val => !!val || 'Пожалуйста, заполните это поле'
              ]" lazy-rules reactive-rules @update:model-value="redactUserDataApi.validateForm('redactUserForm')">
              <template v-slot:prepend>
                <div class="q-px-xs"></div>
              </template>
            </q-input>
          </div>
        </div>
        <div>
          <div class="q-mb-md">Текущий пароль</div>
          <div>
            <q-input bg-color="light_yellow" v-model="password_current" placeholder="Введите текущий пароль" outlined
              rounded :type="isPasswordVisble_1 ? 'password' : 'text'" class="input_field_UCStyle" :rules="[
                val => !!val || 'Пожалуйста, заполните это поле'
              ]" lazy-rules reactive-rules @update:model-value="redactUserDataApi.validateForm('redactUserForm')">
              <template v-slot:prepend>
                <div class="q-px-xs"></div>
              </template>
              <template v-slot:append>
                <q-icon :name="isPasswordVisble_1 ? 'visibility_off' : 'visibility'" class="cursor-pointer q-pr-sm"
                  @click="isPasswordVisble_1 = !isPasswordVisble_1" />
              </template>
            </q-input>
          </div>
        </div>
        <div>
          <div class="q-mb-md">Новый пароль</div>
          <div>
            <q-input bg-color="light_yellow" v-model="password_new" placeholder="Введите новый пароль" outlined rounded
              :type="isPasswordVisble_2 ? 'password' : 'text'" class="input_field_UCStyle" :rules="[
                val => !!val || 'Пожалуйста, заполните это поле'
              ]" lazy-rules reactive-rules @update:model-value="redactUserDataApi.validateForm('redactUserForm')">
              <template v-slot:prepend>
                <div class="q-px-xs"></div>
              </template>
              <template v-slot:append>
                <q-icon :name="isPasswordVisble_2 ? 'visibility_off' : 'visibility'" class="cursor-pointer q-pr-sm"
                  @click="isPasswordVisble_2 = !isPasswordVisble_2" />
              </template>
            </q-input>
          </div>
        </div>
        <div>
          <div class="q-mb-md">Повторить пароль</div>
          <div>
            <q-input bg-color="light_yellow" v-model="password_newRepeat" placeholder="Повторите новый пароль" outlined
              rounded :type="isPasswordVisble_3 ? 'password' : 'text'" class="input_field_UCStyle" :rules="[
                val => !!val || 'Пожалуйста, заполните это поле'
              ]" lazy-rules reactive-rules @update:model-value="redactUserDataApi.validateForm('redactUserForm')">
              <template v-slot:prepend>
                <div class="q-px-xs"></div>
              </template>
              <template v-slot:append>
                <q-icon :name="isPasswordVisble_3 ? 'visibility_off' : 'visibility'" class="cursor-pointer q-pr-sm"
                  @click="isPasswordVisble_3 = !isPasswordVisble_3" />
              </template>
            </q-input>
          </div>
        </div>
      </div>
      <div class="field_column_no_styles col-12 col-md q-gutter-y-md q-pb-md">
        <div>
          <div class="q-mb-md">Ф.И.О ребёнка</div>
          <div>
            <q-input bg-color="light_yellow" outlined rounded v-model="child_fio" placeholder="Ф.И.О ребёнка"
              :dense="dense" class="input_field_UCStyle" :rules="[
                val => !!val || 'Пожалуйста, заполните это поле'
              ]" lazy-rules reactive-rules @update:model-value="redactUserDataApi.validateForm('redactUserForm')">
              <template v-slot:prepend>
                <div class="q-px-xs"></div>
              </template>
            </q-input>
          </div>
        </div>
        <div>
          <div class="q-mb-md">Возраст ребёнка</div>
          <div>
            <q-input bg-color="light_yellow" outlined rounded v-model.number="child_age" type="number"
              placeholder="Введите возраст ребенка" class="input_field_UCStyle" :rules="[
                val => !!val || 'Пожалуйста, заполните это поле'
              ]" lazy-rules reactive-rules @update:model-value="redactUserDataApi.validateForm('redactUserForm')">
              <template v-slot:prepend>
                <div class="q-px-xs"></div>
              </template>
            </q-input>
          </div>
        </div>
        <div>
          <div class="q-mb-md">Ф.И.О законного представителя</div>
          <div>
            <q-input bg-color="light_yellow" outlined rounded v-model="parent_fio"
              placeholder="Ф.И.О законного представителя" :dense="dense" class="input_field_UCStyle" :rules="[
                val => !!val || 'Пожалуйста, заполните это поле'
              ]" lazy-rules reactive-rules @update:model-value="redactUserDataApi.validateForm('redactUserForm')">
              <template v-slot:prepend>
                <div class="q-px-xs"></div>
              </template>
            </q-input>
          </div>
        </div>
      </div>
      <div class="field_column_no_styles col-12 col-md q-gutter-y-md q-pb-md">
        <div>
          <div class="q-mb-md">Статус ребёнка</div>
          <div>
            <q-select bg-color="light_yellow" outlined rounded v-model="diagnosis_status"
              popup-content-class="ucSelectToQuasar__popup_content_class" :options="diagnosis_status_options"
              label="Выберите из спика" class="input_field_UCStyle" :rules="[
                val => !!val || 'Пожалуйста, заполните это поле'
              ]" lazy-rules reactive-rules @update:model-value="redactUserDataApi.validateForm('redactUserForm')">
              <template v-slot:prepend>
                <div class="q-px-xs"></div>
              </template>
            </q-select>
          </div>
        </div>
        <div>
          <div class="q-mb-md">Шифр по ПМПК</div>
          <div>
            <q-select bg-color="light_yellow" outlined rounded v-model="diagnosis_cipher"
              popup-content-class="ucSelectToQuasar__popup_content_class" :options="diagnosis_cipher_options"
              label="Выберите из спика" class="input_field_UCStyle" :rules="[
                val => !!val || 'Пожалуйста, заполните это поле'
              ]" lazy-rules reactive-rules @update:model-value="redactUserDataApi.validateForm('redactUserForm')">
              <template v-slot:prepend>
                <div class="q-px-xs"></div>
              </template>
            </q-select>
          </div>
        </div>
      </div>
    </div>
    <div class="submit_wrapper">
      <q-btn type="submit" flat no-caps size="xl" class="q-pa-none" style="border-radius: 22px; min-width: 230px;"
        :loading="redactUserDataApi.loadingStates.value.redactUser" :disable="!redactUserDataApi.currentFormIsValid">
        <template v-slot:loading>
          <div class="full-width ucButtonToQuasar__wrapper_1_uc_green text-uc_green">
            <div class="ucButtonToQuasar__wrapper_2_uc_green q-px-xl q-py-sm row">
              <q-spinner-hourglass class="on-left" color="uc_green" />
              Сохраняем...
            </div>
          </div>
        </template>
        <template v-slot:default>
          <div class="full-width ucButtonToQuasar__wrapper_1"
            :class="redactUserDataApi.currentFormIsValid ? '' : 'ucButtonToQuasar__wrapper_1_disable'">
            <div class="ucButtonToQuasar__wrapper_2 q-px-xl q-py-sm">
              Сохранить
            </div>
          </div>
        </template>
      </q-btn>
    </div>
  </q-form>
  <div class="ticketAndButton_wrapper">
    <div v-if="$q.screen.gt.sm">
      <div class="ticket_wrapper q-pb-lg row">
        <div class="background-container ticketBackground col-2">
          <div class="text-overlay q-pa-md" style="max-width: 500px;">
            <div class="text_overlay_container">
              <div>
                <q-item>
                  <q-item-section side top>
                    <q-icon name="calendar_month" color="uc_light_green" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label class="h5 text-uc_dark_green">27 сентября 2025 года</q-item-label>
                  </q-item-section>
                </q-item>
              </div>
              <div>
                <q-item>
                  <q-item-section side top>
                    <q-icon name="not_listed_location" color="uc_light_green" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label class="h6 text-uc_dark_green">г. Иркутск, улица
                      Желябова, 5</q-item-label>
                  </q-item-section>
                </q-item>
              </div>
              <div>
                <q-item>
                  <q-item-section>
                    <q-item-label class="h5 text-uc_dark_green">Актовый зал Дворца детского и юношеского
                      творчества</q-item-label>
                  </q-item-section>
                </q-item>
              </div>
            </div>
          </div>
          <div class="grid" :class="{ 'full-unlocked': isTicketFullyUnlocked }">
            <div v-for="block in blocks" :key="block.id" class="block"
              :class="{ 'full-progress': block.progress >= 100 }">
              <div class="lock-overlay" v-if="block.locked"></div>
              <div class="border" :class="{ unlocked: !block.locked }"></div>
            </div>
          </div>
        </div>
        <div class="ticked_body_sideText col-3">
        </div>
      </div>
    </div>
    <div v-else class="flex flex-center">
      <div class="ticket_wrapper q-pb-lg" style="width: 100%; max-width: 600px;">
        <q-img src="src/assets/images/lk/profile/profile_ticket_sideText_mobile.svg" fit="fill"></q-img>
        <div class="background-container_mobile ticketBackground">
          <div class="text-overlay q-pa-md" style="width: 100%;">
            <div class="text_overlay_container">
              <div>
                <q-item>
                  <q-item-section side top>
                    <q-icon name="calendar_month" color="uc_light_green" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label class="h5 text-uc_dark_green">27 сентября 2025 года</q-item-label>
                  </q-item-section>
                </q-item>
              </div>
              <div>
                <q-item>
                  <q-item-section side top>
                    <q-icon name="not_listed_location" color="uc_light_green" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label class="h6 text-uc_dark_green">г. Иркутск, улица
                      Желябова, 5</q-item-label>
                  </q-item-section>
                </q-item>
              </div>
              <div>
                <q-item>
                  <q-item-section>
                    <q-item-label class="h5 text-uc_dark_green">Актовый зал Дворца детского и юношеского
                      творчества</q-item-label>
                  </q-item-section>
                </q-item>
              </div>
            </div>
          </div>
          <div class="grid_mobile" :class="{ 'full-unlocked': isTicketFullyUnlocked }">
            <div v-for="block in blocks" :key="block.id" class="block_moblie"
              :class="{ 'full-progress': block.progress >= 100 }">
              <div class="lock-overlay" v-if="block.locked"></div>
              <div class="border" :class="{ unlocked: !block.locked }"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="downloadTicket_wrapper">
      <q-btn flat no-caps color="white" size="xl" class="q-pa-none" style="border-radius: 22px; min-width: 230px;"
        :disable="!isTicketFullyUnlocked">
        <template v-slot:loading>
          <div class="full-width ucButtonToQuasar__wrapper_1_uc_green text-uc_green">
            <div class="ucButtonToQuasar__wrapper_2_uc_green q-px-xl q-py-sm row">
              <q-spinner-hourglass class="on-left" color="uc_green" />
              Сохраняем...
            </div>
          </div>
        </template>
        <template v-slot:default>
          <div class="full-width ucButtonToQuasar__wrapper_1"
            :class="redactUserDataApi.currentFormIsValid ? '' : 'ucButtonToQuasar__wrapper_1_disable'">
            <div class="ucButtonToQuasar__wrapper_2 q-px-xl q-py-sm row">
              <div class="col-9 flex flex-center  q-px-md">Сохранить</div>
              <div class="col-3 flex flex-center"><q-img non-selectable src="src/assets/images/icons/download.svg"
                  spinner-color="white" style=" height: 30px; width: 30px" />
              </div>
            </div>
          </div>
        </template>
      </q-btn>
    </div>
  </div>
</template>

<style lang="scss" scoped>
// со style scoped работает только :deep!
// .input_field_UCStyle :deep>*>.q-field__control {
//   border-radius: 22px !important;
// }
.input_field_UCStyle :deep(.q-field__control) {
  border-radius: 22px !important;
}

// apply a border-radius: 22px !important; to an element that has a input_field class, that element is a 2nd level child input_field>child1>child2_TARGET
.ticked_body_sideText {
  background-image: url(../../assets/images/lk/profile/profile_ticket_sideText_desktop.svg);
  background-size: contain;
  background-repeat: no-repeat;
}

.ticketBackground {
  background-image: url(../../assets/images/lk/profile/profile_ticket_background.webp);
  background-size: cover;
  background-position: left;
  background-repeat: no-repeat;
}

.background-container {
  position: relative;
  width: 70%;
  height: 600px;
  border-radius: 24px;
  overflow: hidden;
}

.background-container_mobile {
  position: relative;
  width: 100%;
  height: 600px;
  border-radius: 24px;
  overflow: hidden;
}

.text-overlay {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 0;
  /* Between background (0) and grid (2) */
  display: flex;
  align-items: center;
  justify-content: center;
  // text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
  pointer-events: none;
  /* Allows clicks to pass through */
}

.grid {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: repeat(3, 1fr);
  gap: 0;
}

.grid_mobile {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-template-rows: repeat(4, 1fr);
  gap: 0;
}

.block {
  position: relative;
  border-right: 2px solid white;
  border-bottom: 2px solid white;
  background: transparent;
}

.block_moblie {
  position: relative;
  border-right: 2px solid white;
  border-bottom: 2px solid white;
  background: transparent;
}

/* Remove borders when fully unlocked */
.grid.full-unlocked .block {
  border-right: none;
  border-bottom: none;
}

.block:nth-child(4n) {
  border-right: none;
}

.block:nth-child(n+9) {
  border-bottom: none;
}

.grid_moblie.full-unlocked .block_moblie {
  border-right: none;
  border-bottom: none;
}

/* Existing styles remain unchanged */
.lock-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.7);
  z-index: 2;
}

.border {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  transition: all 0.3s ease;
}

.unlocked {
  border: 2px solid white;
  box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.5);
}

.full-progress .border {
  border: none;
  box-shadow: none;
}
</style>