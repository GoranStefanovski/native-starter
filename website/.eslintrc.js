module.exports = {
    env: {
        browser: true,
        es2021: true
    },
    rules: {
        'indent': ['error', 4, { SwitchCase: 1 }],
        'comma-dangle': ['error', 'never'],
        'max-len': ['error', { code: 130 }],
        'import/no-named-default': 0,
        'import/prefer-default-export': 0,
        'import/no-cycle': 0,
        'max-len': "off"
    },
    overrides: [{
        files: ['*.vue'],
        parserOptions: {
            parser: '@typescript-eslint/parser',
            sourceType: 'module'
        },
        extends: [
            "plugin:vue/recommended"
        ],
        rules: {
            'indent': 'off',
            'vue/script-indent': [
                'warn',
                2,
                {
                    baseIndent: 1,
                    switchCase: 1,
                    ignores: []
                }
            ],
            'vue/no-v-html': 'off',
            'max-len': "off",
            "object-curly-spacing": ["error", "always"]
        }
    }]
};
