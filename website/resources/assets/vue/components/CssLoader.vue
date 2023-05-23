<script setup lang="ts">
  const isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
</script>

<template>
  <div class="fr-loader">
    <!-- Google Chrome -->
    <div
      v-if="isChrome"
      class="fr-loader__infinity-chrome"
    >
      <div />
      <div />
      <div />
    </div>

    <!-- Safari and others -->
    <div
      v-else
      class="fr-loader__infinity"
    >
      <div>
        <span />
      </div>
      <div>
        <span />
      </div>
      <div>
        <span />
      </div>
    </div>

    <!-- Stuff -->
    <svg
      xmlns="http://www.w3.org/2000/svg"
      version="1.1"
      style="display: none;"
    >
      <defs>
        <filter id="goo">
          <feGaussianBlur
            in="SourceGraphic"
            stdDeviation="6"
            result="blur"
          />
          <feColorMatrix
            in="blur"
            mode="matrix"
            values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7"
            result="goo"
          />
          <feBlend
            in="SourceGraphic"
            in2="goo"
          />
        </filter>
      </defs>
    </svg>
  </div>
</template>
