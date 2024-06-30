const languageFiles = {
    en: 'en.json',
    ar: 'ar.json'
};

// Function to fetch and load language translations
function loadTranslations(language) {
    fetch(languageFiles[language])
        .then(response => response.json())
        .then(data => {
            // Update text content based on translations
            Object.keys(data).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    element.textContent = data[key];
                } 
            });
        })
        .catch(error => console.error('Error loading translations:', error));
}

// Function to initialize language based on query parameter in the URL
function initializeLanguage() {
    const urlParams = new URLSearchParams(window.location.search);
    const selectedLanguage = urlParams.get('lang');
    if (selectedLanguage) {
        loadTranslations(selectedLanguage);
    } else {
        // If no language is specified in the URL, use a default language or fallback mechanism
    }
}

// Initial load of translations based on stored preference
initializeLanguage();