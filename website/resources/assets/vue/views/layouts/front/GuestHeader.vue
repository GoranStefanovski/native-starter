<script setup lang="ts">
  import { ref, computed, onMounted } from "vue";
  import type { Ref } from 'vue'
  import { useStore } from '@/store';
  import { useRouter } from 'vue-router/composables';
  import { isTouchDevice } from "@/utils/userAgentCheck";
  import AuthenticationModal from '../../../features/Front/Users/_components/AuthenticationModal.vue';
  import ProfileModal from '../../../features/Front/Users/_components/ProfileModal.vue';
  import EventBus from '../../../utils/event-bus';
  import Login from "@/features/Front/Users/_components/auth/Login.vue";

  const store = useStore();
  const router = useRouter();

  const setFrontActiveClass = (classesObj) => store.dispatch('Root/setFrontActiveClass', classesObj);
  const setBodyClasses = (classesObj) => store.dispatch('Root/setBodyClasses', classesObj);

  // const frontActiveClass = computed(() => store.state.Root.frontActiveClass);
  // const bodyClasses = computed(() => store.state.Root.bodyClasses);
  // const bookingEnabled = computed(() => store.state.Root.bookingEnabled);

  const props = defineProps({
    fixedHeader: {
      type: Boolean,
      default: false
    }
  });

  const authActive: Ref<boolean> = ref(false);
  const mobileMenuShow: Ref<boolean> = ref(false);
  const redirect: Ref<boolean> = ref(true);
  const activeModal: Ref<string> = ref('login');
  const profileModalActive: Ref<boolean> = ref(false);
  const name: Ref<string | null> = ref(null);
  const price: Ref<number | null> = ref(null);
  const product_id: Ref<number | null> = ref(null);
  const offer_type: Ref<number | null> = ref(null);

  const email = '';
  const password = '';

  const toggleAuth = (newRedirect = true, newActiveModal = 'login') => {
    redirect.value = newRedirect;
    authActive.value = !authActive.value;
    activeModal.value = newActiveModal;
  }

  const closeAuth = () => {
    authActive.value = false;
  }

  const closeProfileModal = () => {
    profileModalActive.value = false;
  }

  const toggleMobileMenu = () => {
    mobileMenuShow.value = !mobileMenuShow.value;
    setBodyClasses({ 'navMenuOpen' : mobileMenuShow });
  }

  const closeMobileMenu = () => {
    mobileMenuShow.value = false;
    setBodyClasses({ 'navMenuOpen' : false });
  }

  const openProfileModal = () => {
    profileModalActive.value = true;
  }

  const homeLinkClicked = () => {
    mobileMenuShow.value = false;
    if(router.currentRoute.name === 'homepage') {
      window.scrollTo(0,0);
    }
  }

  const headerStyles = computed(() => {
    const { isBodyOverflowing, modalOpen, navMenuOpen, scrollBarWidth } = bodyClasses.value;
    if (!isTouchDevice() && isBodyOverflowing && props.fixedHeader.value) {
      if (modalOpen || navMenuOpen)  {
        return `padding-right:${scrollBarWidth}px;`;
      }
    }

    return '';
  })

  onMounted(() => {
    if (router.currentRoute.name == 'public_login') {
      authActive.value = true
    }
    EventBus.$on('resetPassswordComplete', toggleAuth);
    EventBus.$on('tryLogin', data => {
      toggleAuth(data.redirect, data.activeSection);
    });
    EventBus.$on('resetPassswordShow', closeAuth);
    EventBus.$on("authenticationSuccessful", closeAuth);
  })

  const doLogin = () => {
    console.log('LOGGING')
  }
</script>
<template>
<!--  <div>-->
<!--    <div>-->
<!--      <div class="font-sans text-gray-900 antialiased">-->
<!--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Login Form</h2>-->
<!--      </div>-->
<!--      </br>-->
<!--      <form @submit.prevent="doLogin">-->
<!--        <label class="block font-medium text-sm text-gray-700" for="email">-->
<!--          Email-->
<!--        </label>-->
<!--        <input id="email" v-model="email"-->
<!--               class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"-->
<!--               type="text"-->
<!--               name="text">-->
<!--        <label class="block font-medium text-sm text-gray-700" for="password">-->
<!--          Password-->
<!--        </label>-->
<!--        <input id="password" v-model='password'-->
<!--               class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"-->
<!--               type="password"-->
<!--               name="password"/>-->
<!--        <button class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" type='submit'>Submit</button>-->
<!--      </form>-->
<!--&lt;!&ndash;      <div>{{this.storedUser}}</div>&ndash;&gt;-->
<!--    </div>-->
<!--  </div>-->
  <Login />
<!--  <header-->
<!--    :style="headerStyles"-->
<!--    :class="['main-header',{-->
<!--      'main-header&#45;&#45;fixed':fixedHeader,-->
<!--    }]"-->
<!--  >-->
<!--    <div class="main-header__upper">-->
<!--      <div class="container main-header__upper-wrap">-->
<!--        <ul class="main-header__upper__list">-->
<!--          <li class="main-header__upper__list-item">-->
<!--            <a-->
<!--              href=""-->
<!--              class="main-header__upper__link"-->
<!--            >-->
<!--              store-icon-->
<!--              Народни Херои 17, Битола-->
<!--            </a>-->
<!--          </li>-->
<!--          <li class="main-header__upper__list-item main-header__upper__list-item&#45;&#45;left">-->
<!--            <a-->
<!--              href=""-->
<!--              class="main-header__upper__link"-->
<!--            >-->
<!--              079 / 221 - 777</a>-->
<!--          </li>-->

<!--          <li-->
<!--            v-if="bookingEnabled"-->
<!--            class="main-header__upper__list-item"-->
<!--          >-->
<!--            <a-->
<!--              v-if="$auth.ready() && $auth.check()"-->
<!--              href=""-->
<!--              class="main-header__upper__link"-->
<!--              @click.prevent="openProfileModal"-->
<!--            >-->
<!--              Profile-->
<!--            </a>-->
<!--            <a-->
<!--              v-else-->
<!--              href=""-->
<!--              class="main-header__upper__link"-->
<!--              @click.prevent="toggleAuth"-->
<!--            >-->
<!--              Login-->
<!--            </a>-->
<!--          </li>-->
<!--          <li class="main-header__upper__list-item">-->
<!--            &lt;!&ndash; <language-switcher /> &ndash;&gt;-->
<!--          </li>-->
<!--        </ul>-->
<!--      </div>-->
<!--    </div>-->

<!--    <div class="container main-header__container">-->
<!--      <div class="main-header__column">-->
<!--        <div class="main-header__logo">-->
<!--          <router-link-->
<!--            :to="{ name: 'homepage' }"-->
<!--            title="Home"-->
<!--            @click.native="closeMobileMenu"-->
<!--          >-->
<!--            <img-->
<!--              alt="Freja logo"-->
<!--              src="images/freja/freja-web-logo.png"-->
<!--            >-->
<!--          </router-link>-->
<!--        </div>-->
<!--      </div>-->

<!--      <div class="main-header__column main-header__left-column">-->
<!--        <nav class="main-header__nav">-->
<!--          <ul class="main-header__list">-->
<!--            <li-->
<!--              class="main-header__nav__item"-->
<!--              :class="{'active':frontActiveClass === 'homepage'}"-->
<!--            >-->
<!--              <router-link-->
<!--                :to="{ name: 'homepage' }"-->
<!--                title="Home"-->
<!--                class="main-header__nav__link"-->
<!--                @click.native="closeMobileMenu"-->
<!--              >-->
<!--                <span class="hover-bg">-->
<!--                  <span class="menu-text">Дома</span>-->
<!--                </span>-->
<!--              </router-link>-->
<!--            </li>-->
<!--            <li-->
<!--              class="main-header__nav__item"-->
<!--              :class="{'active':frontActiveClass === 'about'}"-->
<!--            >-->
<!--              <router-link-->
<!--                :to="{ name: 'about' }"-->
<!--                title="About"-->
<!--                class="main-header__nav__link"-->
<!--                @click.native="closeMobileMenu"-->
<!--              >-->
<!--                <span class="hover-bg">-->
<!--                  <span class="menu-text">За нас</span>-->
<!--                </span>-->
<!--              </router-link>-->
<!--            </li>-->
<!--            <li-->
<!--              class="main-header__nav__item"-->
<!--              :class="{'active':frontActiveClass === 'services'}"-->
<!--            >-->
<!--              <router-link-->
<!--                :to="{ name: 'services' }"-->
<!--                title="Services"-->
<!--                class="main-header__nav__link"-->
<!--                @click.native="closeMobileMenu"-->
<!--              >-->
<!--                <span class="hover-bg">-->
<!--                  <span class="menu-text">Услуги</span>-->
<!--                </span>-->
<!--              </router-link>-->
<!--            </li>-->
<!--          </ul>-->
<!--        </nav>-->

<!--        <button-->
<!--          :class="['main-header__trigger-button','main-header__trigger-button&#45;&#45;menu',{-->
<!--            'main-header__trigger-button&#45;&#45;menu&#45;&#45;open': bodyClasses.navMenuOpen,-->
<!--          }]"-->
<!--          @click="toggleMobileMenu"-->
<!--        >-->
<!--          close/menu-icons-->
<!--        </button>-->
<!--      </div>-->

<!--      <div class="main-header__row main-header__row&#45;&#45;mobile-nav">-->
<!--        <nav-->
<!--          :class="['main-header__nav','main-header__nav&#45;&#45;mobile',{-->
<!--            'main-header__nav&#45;&#45;mobile&#45;&#45;open':bodyClasses.navMenuOpen,-->
<!--          }]"-->
<!--        >-->
<!--          <ul class="main-header__list">-->
<!--            <li-->
<!--              class="main-header__nav__item"-->
<!--              :class="{'active':frontActiveClass === 'homepage'}"-->
<!--            >-->
<!--              <router-link-->
<!--                :to="{ name: 'homepage' }"-->
<!--                title="Home"-->
<!--                class="main-header__nav__link"-->
<!--                @click.native="closeMobileMenu"-->
<!--              >-->
<!--                <span class="hover-bg">-->
<!--                  <span class="menu-text">Дома</span>-->
<!--                </span>-->
<!--              </router-link>-->
<!--            </li>-->
<!--            <li-->
<!--              class="main-header__nav__item"-->
<!--              :class="{'active':frontActiveClass === 'about'}"-->
<!--            >-->
<!--              <router-link-->
<!--                :to="{ name: 'about' }"-->
<!--                title="About"-->
<!--                class="main-header__nav__link"-->
<!--                @click.native="closeMobileMenu"-->
<!--              >-->
<!--                <span class="hover-bg">-->
<!--                  <span class="menu-text">За нас</span>-->
<!--                </span>-->
<!--              </router-link>-->
<!--            </li>-->
<!--            <li-->
<!--              class="main-header__nav__item"-->
<!--              :class="{'active':frontActiveClass === 'services'}"-->
<!--            >-->
<!--              <router-link-->
<!--                :to="{ name: 'services' }"-->
<!--                title="Services"-->
<!--                class="main-header__nav__link"-->
<!--                @click.native="closeMobileMenu"-->
<!--              >-->
<!--                <span class="hover-bg">-->
<!--                  <span class="menu-text">Услуги</span>-->
<!--                </span>-->
<!--              </router-link>-->
<!--            </li>-->
<!--            <li-->
<!--              class="main-header__nav__item"-->
<!--              :class="{'active':frontActiveClass === 'contact'}"-->
<!--            >-->
<!--              <router-link-->
<!--                :to="{ name: 'contact' }"-->
<!--                title="Contact"-->
<!--                class="main-header__nav__link"-->
<!--                @click.native="closeMobileMenu"-->
<!--              >-->
<!--                <span class="hover-bg">-->
<!--                  <span class="menu-text">Контакт</span>-->
<!--                </span>-->
<!--              </router-link>-->
<!--            </li>-->
<!--          </ul>-->
<!--        </nav>-->
<!--      </div>-->

<!--&lt;!&ndash;      <language-switcher :mobile="true" />&ndash;&gt;-->
<!--    </div>-->

<!--    <authentication-modal-->
<!--      v-if="authActive"-->
<!--      :redirect="redirect"-->
<!--      :name="name"-->
<!--      :active-section="activeModal"-->
<!--      @close-auth="closeAuth()"-->
<!--    />-->

<!--    <profile-modal-->
<!--      v-if="profileModalActive"-->
<!--      @close-profile-modal="closeProfileModal"-->
<!--    />-->
<!--  </header>-->
</template>
