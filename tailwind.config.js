const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    darkMode: false, // or 'media' or 'class'

    theme: {
        container: {
            center: true,
        },

        customForms: theme => ({
            default: {
                input: {
                    borderRadius: theme('borderRadius.lg'),
                    backgroundColor: theme('colors.gray.100'),
                    '&:focus': {
                        backgroundColor: theme('colors.white'),
                    }
                },

                textarea: {
                    borderRadius: theme('borderRadius.md'),
                    backgroundColor: theme('colors.gray.100'),
                    '&:focus': {
                        backgroundColor: theme('colors.white'),
                    }
                },

                select: {
                    borderRadius: theme('borderRadius.md'),
                    boxShadow: theme('boxShadow.none'),
                    backgroundColor: theme('colors.gray.100'),
                    '&:focus': {
                        backgroundColor: theme('colors.white'),
                    }
                },

                checkbox: {
                    backgroundColor: theme('colors.gray.100'),
                    width: theme('spacing.6'),
                    height: theme('spacing.6'),
                },

                radio: {
                    backgroundColor: theme('colors.gray.100'),
                    width: theme('spacing.6'),
                    height: theme('spacing.6'),
                },
            },
        }),

        typography: theme => ({
            default: {
                css: {
                    color: theme('colors.gray.600'),
                    a: {
                        color: '#0366D6',
                        '&:hover': {
                            color: '#035CC1',
                        },
                    },
                },
            },
        }),

        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                blue: {
                    100: '#E6F0FB',
                    200: '#C0D9F5',
                    300: '#9AC2EF',
                    400: '#4F94E2',
                    500: '#0366D6',
                    600: '#035CC1',
                    700: '#023D80',
                    800: '#012E60',
                    900: '#011F40',
                },
            }
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],

        extend: {},
    },

    plugins: [
        require('@tailwindcss/forms')
    ],
}
