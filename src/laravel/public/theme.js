window.localStorageThemeKey = 'theme_exp'
window.defaultTheme = 'light'

// 'dark' | 'light'

const theme = localStorage.getItem(window.localStorageThemeKey) || window.defaultTheme 

if (theme === 'dark') {
  document.documentElement.classList.add('dark')
}