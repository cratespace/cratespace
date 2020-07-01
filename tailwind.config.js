module.exports = {
  theme: {
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
            borderRadius: theme('borderRadius.lg'),
            backgroundColor: theme('colors.gray.100'),
            '&:focus': {
              backgroundColor: theme('colors.white'),
            }
        },
        select: {
          borderRadius: theme('borderRadius.lg'),
          boxShadow: theme('boxShadow.none'),
          backgroundColor: theme('colors.gray.100'),
          '&:focus': {
            backgroundColor: theme('colors.white'),
          }
        },
        checkbox: {
          backgroundColor: theme('colors.gray.100'),
          width: theme('spacing.5'),
          height: theme('spacing.5'),
        },
        radio: {
          backgroundColor: theme('colors.gray.100'),
          width: theme('spacing.5'),
          height: theme('spacing.5'),
        },
      },
    }),
  },
  variants: {},
  plugins: [
    require('@tailwindcss/custom-forms'),
  ],
}
