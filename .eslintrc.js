module.exports = {
    extends: ['eslint:recommended', 'plugin:vue/recommended'],
    rules: {
        indent: ['error', 4],
        quotes: 'single',
        semi: 'never',
        'comma-dangle': ['warn', 'always-multiline'],
        'vue/max-attributes-per-line': false,
        'vue/require-default-prop': false,
        'vue/singleline-html-element-content-newline': false,
        'prettier/prettier': [
            'warn',
            {
                singleQuote: true,
                semi: false,
                trailingComma: 'none',
            },
        ],
    },
};
