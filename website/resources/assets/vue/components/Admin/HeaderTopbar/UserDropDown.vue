<script>
  import { defineComponent } from "vue";
  // import './HeaderTopBar.scss';
  import { navMenu } from "@/data/navMenu";
  import { mapActions, mapState } from "vuex";

  export default defineComponent({
    name: 'UserDropDown',
    components: {
    },
    data() {
      return {
        dropdownOpen: false,
        backgroundImage: './assets/media/misc/bg-1.jpg', // Adjust the image URL
        username: 'Sean Stone',
        messagesBadge: '23 messages', // Change to your data
        navigationItems: [
          // Define your navigation items here
        ],
        customActions: [
          // Define your custom actions here
        ]
      };
    },
    methods: {
      toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
      }
    }
  })


</script>
<template>
  <div class="kt-header__topbar-item kt-header__topbar-item--user dropdown-toggle">
    <div
      class="kt-header__topbar-wrapper"
      @click="toggleDropdown()"
    >
      <div class="kt-header__topbar-user">
        <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
        <span class="kt-header__topbar-username kt-hidden-mobile">{{ username }}</span>
        <!-- You can add an image/avatar here if needed -->
        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">{{ username[0] }}</span>
      </div>
    </div>
    <div
      class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl"
    >
      <!-- User Card -->
      <!--      <div-->
      <!--        class="kt-user-card kt-user-card&#45;&#45;skin-dark kt-notification-item-padding-x"-->
      <!--        :style="'background-image: url(' + backgroundImage + ')'"-->
      <!--      >-->
      <div class="kt-user-card__avatar">
        <!-- You can add an image/avatar here if needed -->
        <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{ username[0] }}</span>
      </div>
      <div class="kt-user-card__name">
        {{ username }}
      </div>
      <div class="kt-user-card__badge">
        <span class="btn btn-success btn-sm btn-bold btn-font-md">{{ messagesBadge }}</span>
      </div>
    </div>
    <!-- Navigation -->
    <div class="kt-notification">
      <!-- Loop through navigation items -->
      <!--          <a-->
      <!--            v-for="(item, index) in navigationItems"-->
      <!--            :key="index"-->
      <!--            :href="item.link"-->
      <!--            class="kt-notification__item"-->
      <!--          >-->
      <!--            <div class="kt-notification__item-icon">-->
      <!--              <i :class="item.iconClasses"></i>-->
      <!--            </div>-->
      <!--            <div class="kt-notification__item-details">-->
      <!--              <div class="kt-notification__item-title kt-font-bold">{{ item.title }}</div>-->
      <!--              <div class="kt-notification__item-time">{{ item.subtitle }}</div>-->
      <!--            </div>-->
      <!--          </a>-->
    </div>
    <div class="kt-notification__custom kt-space-between">
      <!-- Loop through custom actions -->
      <!--          <a-->
      <!--            v-for="(action, index) in customActions"-->
      <!--            :key="index"-->
      <!--            :href="action.link"-->
      <!--            :class="['btn', action.class]"-->
      <!--          >-->
      <!--            {{ action.text }}-->
      <!--          </a>-->
    </div>
  </div>
</template>
