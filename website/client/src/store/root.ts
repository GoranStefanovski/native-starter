import { defineStore } from 'pinia';
import { mergeWith } from 'lodash';
import { bodyClasses } from "@/utils/bodyClasses";
import { i18n } from '@/utils/i18n';
import { get } from "@/services/HTTP";
import type { RootState, SetActiveClassesPayload } from "./types/root";

export const useRootStore = defineStore('root', {
    state: (): RootState => ({
        appName: '',
        backUrl: '',
        csrfToken: '',
        mainMenu: [],
        menu: [],
        activeClasses: {},
        homePath: 'TESTING PURPOSES ONLY',
        frontActiveClass: {},
        bodyClasses: {
            modalOpen: false,
            navMenuOpen: false,
            navSearchActive: false,
            isBodyOverflowing: false,
            scrollBarWidth: 0
        },
        sidebarState: {
          minimized: false,
          minimizeHover: false,
          minimizing: false
        }
    }),
    actions: {
        setBackUrl(payload) {
            this.backUrl = payload
        },
        setMenu(payload) {
            this.menu = payload;
        },
        setActiveClasses(payload: SetActiveClassesPayload) {
            this.activeClasses = payload;
        },
        setBodyClasses(payload) {
            const newClasses = mergeWith(
                {},
                this.bodyClasses,
                payload,
                (a, b) => b === null ? a : undefined
            );
            this.bodyClasses = newClasses;
            bodyClasses(newClasses);
        },
        setFrontActiveClass(payload) {
            this.frontActiveClass = payload;
        },
        setSidebarState(payload) {
          console.log(payload);
          this.bodyClasses.sidebarState = payload;
        },
        async setData() {
            try {
                const response = await get('vue');
                const { status, data } = response;

                if (status === 200 && !data.errors) {
                    const token = document.head.querySelector('meta[name="csrf-token"]');

                    if (token) {
                        data.csrfToken = (<HTMLMetaElement>token).content;
                    }

                    this.$state = data;
                }
            } catch (error) {
                const { t } = i18n.global
                alert(t('errors.generic_error', null));
                window.location.reload();

                return;
            }
        }
    }
})
